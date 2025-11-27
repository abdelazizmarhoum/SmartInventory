@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="page-header">
    <h1 class="page-title">Products</h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Product
    </a>
</div>

@if($products->count() > 0)
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">SKU</th>
                    <th scope="col">Category</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Selling Price</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
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
                                    @if($product->description)
                                        <div class="small text-muted">{{ Str::limit($product->description, 30) }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-primary-light text-primary">{{ $product->sku }}</span>
                        </td>
                        <td>
                            <span class="badge bg-info-light text-info">{{ $product->category->name }}</span>
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
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $products->links() }}
    </div>
@else
    <div class="alert alert-warning" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>No products found. <a href="{{ route('products.create') }}" class="alert-link">Add the first one!</a>
    </div>
@endif
@endsection