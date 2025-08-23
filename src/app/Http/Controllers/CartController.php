<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('cart.index', compact('carts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $userId = Auth::id();
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $cart = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($cart) {
            $cart->quantity += $quantity;
            $cart->save();
        } else {
            Cart::create([
                'user_id'    => $userId,
                'product_id' => $productId,
                'quantity'   => $quantity,
            ]);
        }

        flash()->success(__('messages.created_successfully', [
            'resource' => ucfirst(__('carts.singular'))
        ]));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cart = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $action = $request->input('action');
        $quantity = (int) $request->input('quantity');

        if ($action === 'increase') {
            $cart->quantity++;
        } elseif ($action === 'decrease') {
            $cart->quantity = max(1, $cart->quantity - 1);
        } elseif ($action === 'set_quantity') {
            $cart->quantity = max(1, $quantity);
        } else {
            $cart->quantity = max(1, $quantity);
        }

        $cart->save();
        flash()->success(__('messages.updated_successfully', [
            'resource' => ucfirst(__('carts.singular'))
        ]));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cart = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $cart->delete();

        flash()->success(__('messages.deleted_successfully', [
            'resource' => ucfirst(__('carts.singular'))
        ]));

        return redirect()->back();
    }
}
