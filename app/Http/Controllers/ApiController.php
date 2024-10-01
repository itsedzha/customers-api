<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    // Method to fetch all customers along with their orders
    public function getCustomers()
    {
        // Retrieve all customers with their related orders
        $customers = Customer::with('orders')->get();  // Eager load the orders relationship

        return response()->json($customers);  // Return the response in JSON format
    }

    // Optional: Method to fetch a specific customer by ID
    public function getCustomerById($id)
    {
        // Retrieve a specific customer and their orders
        $customer = Customer::with('orders')->find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        return response()->json($customer);  // Return the customer data in JSON format
    }
}
