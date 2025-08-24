<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerOrderActionsController extends Controller
{
    public function index($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $actions = OrderAction::where('order_id', $orderId)
            ->with('order')
            ->latest()
            ->paginate(10);

        return view('customer.orders.actions', compact('actions', 'order'));
    }
}
