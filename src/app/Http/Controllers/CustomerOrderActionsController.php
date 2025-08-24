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

    public function confirmResolution(Request $request, OrderAction $action)
    {
        $user = Auth::user();

        if ($action->solved_by_seller || $action->solved_by_admin) {
            $action->update([
                'solved_by_user' => true,
                'user_id' => $user->id,
            ]);

            return redirect()->back()->with('success', 'You have confirmed the resolution of the action.');
        }

        return redirect()->back()->with('error', 'This action has not been resolved by the seller or admin yet.');
    }
}
