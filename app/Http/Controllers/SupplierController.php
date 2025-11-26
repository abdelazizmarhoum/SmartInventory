<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     * This shows a list of all suppliers.
     */
    public function index()
    {
        // Get all suppliers, ordered alphabetically by name
        $suppliers = Supplier::orderBy('name')->paginate(10);

        // You will create a view file named 'suppliers.index.blade.php'
        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     * This displays the "Add New Supplier" page.
     */
    public function create()
    {
        // You will create a view file named 'suppliers.create.blade.php'
        return view('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     * This handles the form submission from the create() method.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:suppliers,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        // Create the supplier in the database using the validated data
        Supplier::create($request->all());

        // Redirect to the suppliers list with a success message
        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully.');
    }

    /**
     * Display the specified resource.
     * This shows the details for a single supplier, including its products.
     */
    public function show(Supplier $supplier)
    {
        // Eager load the products associated with this supplier
        // This is useful to show all products supplied by this specific company
        $supplier->load('products');

        // You will create a view file named 'suppliers.show.blade.php'
        return view('suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     * This displays the "Edit Supplier" page.
     */
    public function edit(Supplier $supplier)
    {
        // You will create a view file named 'suppliers.edit.blade.php'
        return view('suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     * This handles the form submission from the edit() method.
     */
    public function update(Request $request, Supplier $supplier)
    {
        // Validate the incoming request data
        // For the 'email', we add a rule to ignore the current supplier's ID
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:suppliers,email,' . $supplier->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        // Update the supplier with the validated data
        $supplier->update($request->all());

        // Redirect to the supplier details page with a success message
        return redirect()->route('suppliers.show', $supplier->id)->with('success', 'Supplier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     * This deletes the supplier.
     */
    public function destroy(Supplier $supplier)
    {
        // Check if the supplier has any products before deleting
        if ($supplier->products()->count() > 0) {
            // If it does, redirect back with an error message
            return redirect()->route('suppliers.index')
                             ->with('error', 'Cannot delete supplier because it has associated products.');
        }

        // Otherwise, delete the supplier
        $supplier->delete();

        // Redirect to the suppliers list with a success message
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
    }
}