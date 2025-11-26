<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     * This shows a list of all customers who have NOT been soft-deleted.
     */
    public function index()
    {
        // Get all customers, ordered alphabetically by name.
        // The default Eloquent query automatically excludes soft-deleted models.
        $customers = Customer::orderBy('name')->paginate(10);

        // You will create a view file named 'customers.index.blade.php'
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // You will create a view file named 'customers.create.blade.php'
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        // Create the customer in the database using the validated data
        Customer::create($request->all());

        // Redirect to the customers list with a success message
        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     * This shows the details for a single customer, including their orders.
     */
    public function show(Customer $customer)
    {
        // Eager load the orders associated with this customer
        $customer->load('orders');

        // You will create a view file named 'customers.show.blade.php'
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        // You will create a view file named 'customers.edit.blade.php'
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        // Validate the incoming request data
        // For the 'email', we add a rule to ignore the current customer's ID
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        // Update the customer with the validated data
        $customer->update($request->all());

        // Redirect to the customer details page with a success message
        return redirect()->route('customers.show', $customer->id)->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     * This performs a SOFT DELETE.
     */
    public function destroy(Customer $customer)
    {
        // Check if the customer has any orders before deleting
        if ($customer->orders()->count() > 0) {
            // If it does, redirect back with an error message.
            // We prevent deletion to preserve sales history.
            return redirect()->route('customers.index')
                             ->with('error', 'Cannot delete customer because they have associated orders.');
        }

        // Perform the soft delete. This sets the 'deleted_at' column in the database.
        // The customer will no longer appear in queries by default.
        $customer->delete();

        // Redirect to the customers list with a success message
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}