<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Order::with('contact','projects')->get();
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
        $data = $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'type' => 'required|string',
            'status' => 'nullable|string',
            'amount' => 'nullable|numeric',
            'deposit' => 'nullable|numeric',
        ]);

        return Order::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return $order->load('projects');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'contact_id' => 'sometimes|exists:contacts,id',
            'type' => 'sometimes|string',
            'status' => 'nullable|string',
            'amount' => 'nullable|numeric',
            'deposit' => 'nullable|numeric',
        ]);

        $order->update($data);

        return $order;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->noContent();
    }
}
