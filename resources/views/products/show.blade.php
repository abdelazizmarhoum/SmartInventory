@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
<div class="page-header">
    <h1 class="page-title">Product Details</h1>
    <div>
        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit Product
        </a>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="mb-0">{{ $product->name }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <p class="mb-1"><strong>SKU:</strong></p>
                        <p class="text-muted mb-3">{{ $product->sku }}</p>
                        
                        <p class="mb-1"><strong>Category:</strong></p>
                        <p class="text-muted mb-3">
                            <span class="badge bg-info-light text-info">{{ $product->category->name }}</span>
                        </p>
                        
                        <p class="mb-1"><strong>Supplier:</strong></p>
                        <p class="text-muted mb-0">{{ $product->supplier->name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="mb-1"><strong>Description:</strong></p>
                        <p class="text-muted mb-0">{{ $product->description ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="mb-0">Stock & Pricing</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <span><strong>Quantity in Stock:</strong></span>
                    @if($product->quantity_in_stock > 10)
                        <span class="badge bg-success">{{ $product->quantity_in_stock }}</span>
                    @elseif($product->quantity_in_stock > 0)
                        <span class="badge bg-warning">{{ $product->quantity_in_stock }}</span>
                    @else
                        <span class="badge bg-danger">{{ $product->quantity_in_stock }}</span>
                    @endif
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span><strong>Purchase Price:</strong></span>
                    <span class="text-muted">${{ number_format($product->purchase_price, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span><strong>Selling Price:</strong></span>
                    <span class="fw-bold text-success">${{ number_format($product->selling_price, 2) }}</span>
                </div>
            </div>
        </div>
        
        @if($product->image_url)
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Product Image</h4>
                </div>
                <div class="card-body text-center">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid rounded" style="max-height: 200px; object-fit: cover;">
                </div>
            </div>
        @endif
    </div>
</div>
@endsection