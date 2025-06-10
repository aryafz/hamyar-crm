<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return OrderResource::collection(
            Order::with(['contact','projects.tasks'])->get()
        );
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

        $order = Order::create($data);
        return new OrderResource($order->load('projects.tasks'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return new OrderResource($order->load('projects.tasks'));
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

        return new OrderResource($order->load('projects.tasks'));
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
