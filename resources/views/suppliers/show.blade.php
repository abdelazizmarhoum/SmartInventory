@extends('layouts.app')

@section('title', 'Supplier Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Supplier Details</h1>
    <div>
        <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit Supplier
        </a>
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>{{ $supplier->name }}</h3>
    </div>
    <div class="card-body">
        <p><strong>Contact Person:</strong> {{ $supplier->contact_person ?? 'N/A' }}</p>
        <p><strong>Email:</strong> {{ $supplier->email ?? 'N/A' }}</p>
        <p><strong>Phone:</strong> {{ $supplier->phone ?? 'N/A' }}</p>
        <p><strong>Address:</strong> {{ $supplier->address ?? 'N/A' }}</p>
    </div>
</div>

@if($supplier->products->count() > 0)
    <div class="mt-5">
        <h3>Products Supplied</h3>
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
                    @foreach($supplier->products as $product)
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
        <h3>Products Supplied</h3>
        <p>No products are currently linked to this supplier.</p>
    </div>
@endif
@endsection