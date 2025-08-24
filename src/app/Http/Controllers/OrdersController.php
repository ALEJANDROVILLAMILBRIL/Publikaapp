<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('orderItems.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function ordersIndex()
    {
        $orders = Order::with('orderItems.product', 'user')
            ->withCount('actions')
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
