<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index()
    {
        return Customer::all(); 
    }

    /**
     * Display a specific customer.
     */
    public function show(Customer $customer)
    {
        return $customer; 
    }

    /**
     * Store a newly created customer.
     */
    public function store(Request $request)
    {
        // Validation rules based on your table schema
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            // 'birth_date' => 'nullable|date',
            // 'phone' => 'required|string|max:50',
            'address' => 'nullable|string|max:50',
            'city' => 'required|string|max:50',
            'state' => 'required|string|size:2',
            'points' => 'required|integer|min:0',
        ]);
    
        // Create the customer if validation passes
        $customer = Customer::create($validated);
    
        return response()->json($customer, 201);
    }

    /**
     * Update the specified customer.
     */
    public function update(Request $request, Customer $customer)
    {
        // Use validate method to ensure the input is valid
        $validated = $request->validate([
            'first_name' => 'sometimes|string',
            'last_name' => 'sometimes|string',
            // 'birth_date' => 'sometimes|date',
            // 'phone' => 'sometimes|string',
            'address' => 'sometimes|string',
            'city' => 'sometimes|string',
            'state' => 'sometimes|string',
            'points' => 'sometimes|integer|min:0',
        ]);

        // Update customer and return the updated model
        $customer->update($validated);

        return $customer;
    }

    /**
     * Remove the specified customer.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete(); // Delete the customer
        return response()->json(['message' => 'Customer deleted'], 200); // Return success message
    }

    /**
     * Check if a customer is a gold member.
     */
    public function checkGoldMember(Customer $customer)
    {
        return response()->json([
            'customer_id' => $customer->customer_id,
            'is_gold_member' => $customer->goldMember(),
        ]);
    }
}
