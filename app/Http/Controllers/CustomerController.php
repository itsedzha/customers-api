<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use Illuminate\Http\Request;


class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */

     public function index()
{
    // Get the SQL query as a string for debugging
    $sqlQuery = DB::table('customers as c')
        ->join('orders as o', 'c.customer_id', '=', 'o.customer_id')
        ->join('order_statuses as os', 'o.status', '=', 'os.order_status_id')
        ->select(
            'c.customer_id',
            'c.first_name',
            'c.last_name',
            'c.address',
            'c.city',
            'c.state',
            'c.points',
            'o.order_date',
            'os.name as order_status_name'
        )
        ->toSql(); // This will return the SQL query as a string

    // Return the SQL query string as the response (for debugging)
    return response()->json(['sql' => $sqlQuery]);
}


    // public function index()
    // {
    //     $customersWithOrders = DB::table('customers as c')
    //         ->join('orders as o', 'c.customer_id', '=', 'o.customer_id')
    //         ->join('order_statuses as os', 'o.status', '=', 'os.order_status_id')
    //         ->select(
    //             'c.customer_id',
    //             'c.first_name',
    //             'c.last_name',
    //             'c.address',
    //             'c.city',
    //             'c.state',
    //             'c.points',
    //             'o.order_date',
    //             'os.name as order_status_name'
    //         )
    //         ->get();

    //     return response()->json($customersWithOrders);
    // }

    /**
     * Display a specific customer.
     */
    public function show($id)
{
    // Fetch the SQL query for customer with orders and order statuses using their customer_id
    $sqlQuery = DB::table('customers as c')
        ->join('orders as o', 'c.customer_id', '=', 'o.customer_id')
        ->join('order_statuses as os', 'o.status', '=', 'os.order_status_id')
        ->select(
            'c.customer_id',
            'c.first_name',
            'c.last_name',
            'c.address',
            'c.city',
            'c.state',
            'c.points',
            'o.order_date',
            'os.name as order_status_name'
        )
        ->where('c.customer_id', '=', $id)
        ->toSql(); // This returns the SQL query as a string

    // Return the SQL query string as the response (for debugging)
    return response()->json(['sql' => $sqlQuery]);
}


    // public function show($id)
    // {
    //     // Fetch customer with orders and order statuses using their customer_id
    //     $customerWithOrders = DB::table('customers as c')
    //         ->join('orders as o', 'c.customer_id', '=', 'o.customer_id')
    //         ->join('order_statuses as os', 'o.status', '=', 'os.order_status_id')
    //         ->select(
    //             'c.customer_id',
    //             'c.first_name',
    //             'c.last_name',
    //             'c.address',
    //             'c.city',
    //             'c.state',
    //             'c.points',
    //             'o.order_date',
    //             'os.name as order_status_name'
    //         )
    //         ->where('c.customer_id', '=', $id)
    //         ->get();
    
    //     if ($customerWithOrders->isEmpty()) {
    //         return response()->json(['message' => 'Customer not found'], 404);
    //     }
    
    //     return response()->json($customerWithOrders);
    // }
    

    /**
     * Store a newly created customer.
     */
    public function store(Request $request, $customer_id)
    {
        // Check if the customer exists
        $customer = Customer::find($customer_id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }
    
        // Validation rules for order creation
        $validatedData = $request->validate([
            'order_date' => 'required|date',
            'status' => 'required|string',
            'comments' => 'nullable|string',
            'shipped_date' => 'nullable|date',
            'shipper_id' => 'nullable|integer',
        ]);
    
        // Create a new order for the specific customer
        $order = new Order($validatedData);
        $order->customer_id = $customer_id;
        $order->save();
    
        return response()->json($order, 201); // Return the newly created order
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
