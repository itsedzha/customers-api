<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders for a specific customer.
     */
    public function index($customer_id)
    {
        // Check if the customer exists
        $customer = Customer::find($customer_id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $orders = $customer->orders;
    
        if ($orders->isEmpty()) {
            return response()->json(['message' => 'Customer has no orders'], 200);
        }
    
        return response()->json($orders);
    }
    

    /**
     * Display a specific order for a specific customer.
     */
    public function show($customer_id, $order_id)
    {
        // Check if the customer exists
        $customer = Customer::find($customer_id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }
    
        // Retrieve the specific order for the customer
        $order = $customer->orders()->where('order_id', $order_id)->first();
        if (!$order) {
            return response()->json(['message' => 'Order not found for this customer'], 404);
        }
    
        return response()->json($order);
    }
    
    

    /**
     * Store a newly created order for a specific customer.
     */
    public function store(Request $request, $customer_id)
    {
        // Check if the customer exists
        $customer = Customer::find($customer_id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $validatedData = $request->validate([
            'order_date' => 'required|date',
            'status' => 'required|string',
            'comments' => 'nullable|string',
            'shipped_date' => 'nullable|date',
            'shipper_id' => 'nullable|integer',
        ]);

        // Create the order for the specific customer
        $order = new Order($validatedData);
        $order->customer_id = $customer_id;
        $order->save();

        return response()->json($order, 201);
    }

    /**
     * Update a specific order for a specific customer.
     */
    public function update(Request $request, $customer_id, $order_id)
    {
        // Check if the customer exists
        $customer = Customer::find($customer_id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        // Retrieve the specific order for the customer
        $order = $customer->orders()->find($order_id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $validatedData = $request->validate([
            'order_date' => 'sometimes|required|date',
            'status' => 'sometimes|required|string',
            'comments' => 'nullable|string',
            'shipped_date' => 'nullable|date',
            'shipper_id' => 'nullable|integer',
        ]);

        // Update the order
        $order->update($validatedData);

        return response()->json($order);
    }

    /**
     * Remove a specific order for a specific customer.
     */
    public function destroy($customer_id, $order_id)
    {
        // Check if the customer exists
        $customer = Customer::find($customer_id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        // Retrieve the specific order for the customer
        $order = $customer->orders()->find($order_id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Delete the order
        $order->delete();

        return response()->json(['message' => 'Order deleted']);
    }
}
