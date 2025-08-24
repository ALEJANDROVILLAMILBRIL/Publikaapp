<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderAction;
use Illuminate\Http\Request;

class OrderActionController extends Controller
{
    public function returnRequest(Order $order)
    {
        OrderAction::create([
            'order_id'   => $order->id,
            'action_type' => 'return_request',
            'description' => 'Solicitud de devolución generada por el cliente.',
        ]);

        return redirect()->back()->with('success', 'Solicitud de devolución registrada.');
    }

    public function incidentReport(Order $order)
    {
        OrderAction::create([
            'order_id'   => $order->id,
            'action_type' => 'incident_report',
            'description' => 'Incidente reportado por el cliente.',
        ]);

        return redirect()->back()->with('success', 'Incidente reportado correctamente.');
    }
}
