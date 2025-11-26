<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * This shows a list of all products.
     */
    public function index()
    {
        // Eager load 'category' and 'supplier' to avoid N+1 queries
        // Order by the latest products first
        $products = Product::with('category', 'supplier')->latest()->paginate(10);

        // You will create a view file named 'products.index.blade.php'
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     * This displays the "Add New Product" page.
     */
    public function create()
    {
        // We need lists of categories and suppliers to populate the dropdown menus in the form
        $categories = Category::all();
        $suppliers = Supplier::all();

        // You will create a view file named 'products.create.blade.php'
        return view('products.create', compact('categories', 'suppliers'));
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
            'sku' => 'required|string|max:100|unique:products,sku',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'description' => 'nullable|string',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'quantity_in_stock' => 'required|integer|min:0',
            'image_url' => 'nullable|url',
        ]);

        // Create the product in the database using the validated data
        Product::create($request->all());

        // Redirect to the products list with a success message
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     * This shows the details for a single product.
     */
    public function show(Product $product)
    {
        // The 'Product $product' part is called "Route Model Binding".
        // Laravel automatically finds the product by its ID from the URL.
        // We also eager load the category and supplier for this single product.
        $product->load('category', 'supplier');

        // You will create a view file named 'products.show.blade.php'
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     * This displays the "Edit Product" page.
     */
    public function edit(Product $product)
    {
        // Get the product to edit and the lists for the dropdowns
        $categories = Category::all();
        $suppliers = Supplier::all();

        // You will create a view file named 'products.edit.blade.php'
        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     * This handles the form submission from the edit() method.
     */
    public function update(Request $request, Product $product)
    {
        // Validate the incoming request data
        // For the 'sku', we add a rule to ignore the current product's ID
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'description' => 'nullable|string',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'quantity_in_stock' => 'required|integer|min:0',
            'image_url' => 'nullable|url',
        ]);

        // Update the product with the validated data
        $product->update($request->all());

        // Redirect to the product details page with a success message
        return redirect()->route('products.show', $product->id)->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     * This deletes the product.
     */
    public function destroy(Product $product)
    {
        // Delete the product
        // Because we set `onDelete('restrict')` in the migration,
        // this will fail if the product is part of an order, which is good!
        $product->delete();

        // Redirect to the products list with a success message
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}