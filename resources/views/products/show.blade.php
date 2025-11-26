@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Product Details</h1>
    <div>
        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit Product
        </a>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3>{{ $product->name }}</h3>
            </div>
            <div class="card-body">
                <p><strong>SKU:</strong> {{ $product->sku }}</p>
                <p><strong>Description:</strong> {{ $product->description ?? 'N/A' }}</p>
                <p><strong>Category:</strong> {{ $product->category->name }}</p>
                <p><strong>Supplier:</strong> {{ $product->supplier->name }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4>Stock & Pricing</h4>
            </div>
            <div class="card-body">
                <p><strong>Quantity in Stock:</strong> {{ $product->quantity_in_stock }}</p>
                <p><strong>Purchase Price:</strong> ${{ number_format($product->purchase_price, 2) }}</p>
                <p><strong>Selling Price:</strong> ${{ number_format($product->selling_price, 2) }}</p>
            </div>
        </div>
        @if($product->image_url)
            <div class="card mt-3">
                <div class="card-header">
                    <h4>Product Image</h4>
                </div>
                <div class="card-body text-center">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 200px;">
                </div>
            </div>
        @endif
    </div>
</div>
@endsection