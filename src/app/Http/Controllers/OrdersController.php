<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('orderItems.product')
            ->withCount([
                'actions' => function ($query) {
                    $query->where(function ($subQuery) {
                        $subQuery->where('solved_by_user', false)
                            ->orWhere(function ($innerQuery) {
                                $innerQuery->where('solved_by_seller', false)
                                    ->where('solved_by_admin', false);
                            });
                    });
                }
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function ordersIndex()
    {
        $orders = Order::with('orderItems.product', 'user')
            ->withCount([
                'actions' => function ($query) {
                    $query->where(function ($subQuery) {
                        $subQuery->where('solved_by_user', false)
                            ->orWhere(function ($innerQuery) {
                                $innerQuery->where('solved_by_seller', false)
                                    ->where('solved_by_admin', false);
                            });
                    });
                }
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $ordersData = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'latitude' => $order->latitude,
                'longitude' => $order->longitude,
                'order_number' => $order->order_number ?? '',
                'customer' => $order->user->name ?? 'Sin nombre',
            ];
        });

        return view('orders.management.index', compact('orders', 'ordersData'));
    }

    public function resolveAction(Request $request, OrderAction $action)
    {
        $user = Auth::user();

        $actionData = [
            'solution_notes' => $request->input('solution_notes'),
        ];

        if ($user->role_id == 1) {
            $actionData['solved_by_admin'] = true;
            $actionData['admin_id'] = $user->id;
        } elseif ($user->role_id == 3) {
            $actionData['solved_by_seller'] = true;
            $actionData['seller_id'] = $user->id;
        }

        $action->update($actionData);

        return redirect()->back()
            ->with('success', __('Report has been resolved successfully. The customer will be notified to confirm the resolution.'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:pending,accepted,rejected',
            'payment_status' => 'nullable|in:pending,paid,failed,cancelled'
        ]);

        if ($order->payment_method === 'cash' && $request->payment_status) {
            $order->payment_status = $request->payment_status;
        }

        $order->order_status = $request->order_status;
        $order->save();

        flash()->success(__('Order updated successfully'));
        return back();
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $order->load('orderItems.product');

        return view('orders.show', compact('order'));
    }

    public function actions(Order $order)
    {
        $actions = $order->actions()->latest()->get();

        return view('orders.actions', compact('order', 'actions'));
    }
}
