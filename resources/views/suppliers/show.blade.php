@extends('layouts.app')

@section('title', 'Supplier Details')

@section('content')
<div class="page-header">
    <h1 class="page-title">Supplier Details</h1>
    <div>
        <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit Supplier
        </a>
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h3 class="mb-0">{{ $supplier->name }}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <p class="mb-1"><strong>Contact Person:</strong></p>
                <p class="text-muted mb-3">{{ $supplier->contact_person ?? 'N/A' }}</p>
                
                <p class="mb-1"><strong>Email:</strong></p>
                @if($supplier->email)
                    <p class="text-muted mb-0">
                        <a href="mailto:{{ $supplier->email }}" class="text-decoration-none">
                            <i class="fas fa-envelope me-1"></i>{{ $supplier->email }}
                        </a>
                    </p>
                @else
                    <p class="text-muted mb-0">N/A</p>
                @endif
            </div>
            <div class="col-md-6 mb-3">
                <p class="mb-1"><strong>Phone:</strong></p>
                @if($supplier->phone)
                    <p class="text-muted mb-3">
                        <a href="tel:{{ $supplier->phone }}" class="text-decoration-none">
                            <i class="fas fa-phone me-1"></i>{{ $supplier->phone }}
                        </a>
                    </p>
                @else
                    <p class="text-muted mb-3">N/A</p>
                @endif
                
                <p class="mb-1"><strong>Address:</strong></p>
                <p class="text-muted mb-0">{{ $supplier->address ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>

@if($supplier->products->count() > 0)
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Products Supplied</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Product Name</th>
                            <th scope="col">SKU</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Price</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($supplier->products as $product)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($product->image_url)
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="rounded me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-primary-light rounded d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="fas fa-box text-primary"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-medium">{{ $product->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary-light text-primary">{{ $product->sku }}</span>
                                </td>
                                <td>
                                    @if($product->quantity_in_stock > 10)
                                        <span class="badge bg-success">{{ $product->quantity_in_stock }}</span>
                                    @elseif($product->quantity_in_stock > 0)
                                        <span class="badge bg-warning">{{ $product->quantity_in_stock }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $product->quantity_in_stock }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-bold text-success">${{ number_format($product->selling_price, 2) }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye me-1"></i>View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Products Supplied</h4>
        </div>
        <div class="card-body">
            <div class="alert alert-info mb-0">
                <i class="fas fa-info-circle me-2"></i>No products are currently linked to this supplier.
            </div>
        </div>
    </div>
@endif
@endsection