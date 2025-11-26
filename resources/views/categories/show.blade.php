@extends('layouts.app')

@section('title', 'Category Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Category Details</h1>
    <div>
        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit Category
        </a>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>{{ $category->name }}</h3>
    </div>
    <div class="card-body">
        <p><strong>Description:</strong> {{ $category->description ?? 'N/A' }}</p>
    </div>
</div>

@if($category->products->count() > 0)
    <div class="mt-5">
        <h3>Products in this Category</h3>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>SKU</th>
                        <th>Stock</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($category->products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->quantity_in_stock }}</td>
                            <td>${{ number_format($product->selling_price, 2) }}</td>
                            <td>
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info">View Product</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="mt-5">
        <h3>Products in this Category</h3>
        <p>No products are currently in this category.</p>
    </div>
@endif
@endsection