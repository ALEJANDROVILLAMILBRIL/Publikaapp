<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderAction;
use Illuminate\Http\Request;

class OrderActionController extends Controller
{
    public function returnRequest(Request $request, Order $order)
    {
        OrderAction::create([
            'order_id'    => $order->id,
            'action_type' => 'return_request',
            'description' => $request->input('description') ?: 'Solicitud de devolución generada por el cliente.',
            'phone_number' => $order->user->phone_number,
            'email'       => $order->user->email,
        ]);

        return redirect()->back()->with('success', 'Solicitud de devolución registrada.');
    }

    public function incidentReport(Request $request, Order $order)
    {
        OrderAction::create([
            'order_id'    => $order->id,
            'action_type' => 'incident_report',
            'description' => $request->input('description') ?: 'Incidente reportado por el cliente.',
            'phone_number' => $order->user->phone_number,
            'email'       => $order->user->email,
        ]);

        return redirect()->back()->with('success', 'Incidente reportado correctamente.');
    }
}
