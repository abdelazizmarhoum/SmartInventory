<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * This shows a list of all categories.
     */
    public function index()
    {
        // Get all categories, ordered by name
        $categories = Category::orderBy('name')->paginate(10);

        // You will create a view file named 'categories.index.blade.php'
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     * This displays the "Add New Category" page.
     */
    public function create()
    {
        // You will create a view file named 'categories.create.blade.php'
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     * This handles the form submission from the create() method.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        // Create the category in the database using the validated data
        Category::create($request->all());

        // Redirect to the categories list with a success message
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     * This shows the details for a single category, including its products.
     */
    public function show(Category $category)
    {
        // Eager load the products associated with this category
        // This is useful to show all products within a specific category
        $category->load('products');

        // You will create a view file named 'categories.show.blade.php'
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     * This displays the "Edit Category" page.
     */
    public function edit(Category $category)
    {
        // You will create a view file named 'categories.edit.blade.php'
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     * This handles the form submission from the edit() method.
     */
    public function update(Request $request, Category $category)
    {
        // Validate the incoming request data
        // For the 'name', we add a rule to ignore the current category's ID
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        // Update the category with the validated data
        $category->update($request->all());

        // Redirect to the category details page with a success message
        return redirect()->route('categories.show', $category->id)->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     * This deletes the category.
     */
    public function destroy(Category $category)
    {
        // Check if the category has any products before deleting
        if ($category->products()->count() > 0) {
            // If it does, redirect back with an error message
            return redirect()->route('categories.index')
                             ->with('error', 'Cannot delete category because it has associated products.');
        }

        // Otherwise, delete the category
        $category->delete();

        // Redirect to the categories list with a success message
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}