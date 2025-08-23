<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        if ($carts->isEmpty()) {
            flash()->warning(__('Your cart is empty'));
            return redirect()->route('carts.index');
        }

        $total = $carts->sum(function ($cart) {
            return $cart->product->price * $cart->quantity;
        });

        return view('checkout.index', compact('carts', 'total'));
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,paypal',
            'notes' => 'nullable|string|max:500'
        ]);

        $carts = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        if ($carts->isEmpty()) {
            flash()->error(__('Your cart is empty'));
            return redirect()->route('carts.index');
        }

        $total = $carts->sum(function ($cart) {
            return $cart->product->price * $cart->quantity;
        });

        DB::beginTransaction();
        try {
            // Generar número de orden
            $orderNumber = Order::generateOrderNumber();

            $order = Order::create([
                'order_number' => $orderNumber,
                'slug' => Order::generateSlug($orderNumber),
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'cash' ? 'pending' : 'pending',
                'order_status' => 'pending',
                'notes' => $request->notes
            ]);

            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->product->price,
                    'total' => $cart->product->price * $cart->quantity
                ]);
            }

            if ($request->payment_method === 'paypal') {
                $paypalOrder = $this->createPayPalOrder($order, $total);

                if ($paypalOrder['success']) {
                    $order->update([
                        'paypal_order_id' => $paypalOrder['order_id'],
                        'payment_details' => $paypalOrder['details']
                    ]);

                    DB::commit();
                    return redirect($paypalOrder['approval_url']);
                } else {
                    DB::rollback();
                    flash()->error(__('Error processing PayPal payment'));
                    return back();
                }
            } else {
                Cart::where('user_id', Auth::id())->delete();
                DB::commit();
                flash()->success(__('Order placed successfully! You will pay in cash.'));
                return redirect()->route('orders.show', $order->slug);
            }
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error(__('Error processing order: ') . $e->getMessage());
            return back();
        }
    }

    private function convertCOPtoUSD($amountCOP)
    {
        try {
            $response = Http::get('https://api.exchangerate-api.com/v4/latest/COP');
            if ($response->successful()) {
                $exchangeRate = $response->json()['rates']['USD'] ?? 0.00025;
                return max($amountCOP * $exchangeRate, 1.0);
            }
        } catch (\Exception $e) {
            // fallback silencioso
        }
        return max($amountCOP / 4000, 1.0);
    }

    private function createPayPalOrder($order, $total)
    {
        try {
            $accessToken = $this->getPayPalAccessToken();

            if (!$accessToken) {
                return ['success' => false, 'error' => 'Unable to get PayPal access token'];
            }

            $totalUSD = $this->convertCOPtoUSD($total);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->post(config('services.paypal.base_url') . '/v2/checkout/orders', [
                'intent' => 'CAPTURE',
                'purchase_units' => [[
                    'reference_id' => $order->order_number,
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => number_format($totalUSD, 2, '.', '')
                    ]
                ]],
                'application_context' => [
                    'return_url' => route('checkout.paypal.success'),
                    'cancel_url' => route('checkout.paypal.cancel')
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $approvalUrl = collect($data['links'])->firstWhere('rel', 'approve')['href'];

                return [
                    'success' => true,
                    'order_id' => $data['id'],
                    'approval_url' => $approvalUrl,
                    'details' => $data
                ];
            }

            return ['success' => false, 'error' => 'PayPal API error'];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    private function getPayPalAccessToken()
    {
        try {
            $response = Http::asForm()
                ->withBasicAuth(config('services.paypal.client_id'), config('services.paypal.client_secret'))
                ->post(config('services.paypal.base_url') . '/v1/oauth2/token', [
                    'grant_type' => 'client_credentials'
                ]);

            if ($response->successful()) {
                return $response->json()['access_token'];
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function paypalSuccess(Request $request)
    {
        $orderID = $request->get('token');
        $payerID = $request->get('PayerID');

        $order = Order::where('paypal_order_id', $orderID)->first();

        if (!$order) {
            flash()->error(__('Order not found'));
            return redirect()->route('carts.index');
        }

        $capture = $this->capturePayPalPayment($orderID);

        if ($capture['success']) {
            $order->update([
                'payment_status' => 'paid',
                'payment_details' => array_merge($order->payment_details ?? [], $capture['details'])
            ]);

            Cart::where('user_id', $order->user_id)->delete();

            flash()->success(__('Payment completed successfully!'));
            return redirect()->route('orders.show', $order->slug);
        } else {
            $order->update(['payment_status' => 'failed']);
            flash()->error(__('Payment failed'));
            return redirect()->route('checkout.index');
        }
    }

    public function paypalCancel()
    {
        flash()->warning(__('Payment cancelled'));
        return redirect()->route('checkout.index');
    }

    private function capturePayPalPayment($orderID)
    {
        try {
            $accessToken = $this->getPayPalAccessToken();
            if (!$accessToken) {
                return ['success' => false, 'error' => 'Unable to get PayPal access token'];
            }

            $url = config('services.paypal.base_url') . "/v2/checkout/orders/{$orderID}/capture";
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $accessToken,
                    'Content-Type: application/json',
                    'Accept: application/json',
                    'Content-Length: 0'
                ],
                CURLOPT_POSTFIELDS => ''
            ]);

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $error = curl_error($curl);
            curl_close($curl);

            if ($error) {
                return ['success' => false, 'error' => 'Network error: ' . $error];
            }

            $data = json_decode($response, true);

            if ($httpCode >= 200 && $httpCode < 300) {
                $captureStatus = $data['purchase_units'][0]['payments']['captures'][0]['status'] ?? null;
                if ($captureStatus === 'COMPLETED') {
                    return ['success' => true, 'details' => $data];
                }
                return ['success' => false, 'error' => 'Capture status: ' . ($captureStatus ?? 'unknown')];
            }

            return ['success' => false, 'error' => 'PayPal capture failed with status: ' . $httpCode];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
