@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="page-header">
    <h1 class="page-title">Order Details</h1>
    <div>
        <a href="{{ route('orders.export-pdf', $order->id) }}" class="btn btn-success" target="_blank">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit Order
        </a>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="mb-0">Order Information</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <p class="mb-1"><strong>Order ID:</strong></p>
                        <p class="text-muted mb-3">#{{ $order->id }}</p>
                        
                        <p class="mb-1"><strong>Customer:</strong></p>
                        <p class="text-muted mb-3">{{ $order->customer->name }}</p>
                        
                        <p class="mb-1"><strong>Order Date:</strong></p>
                        <p class="text-muted mb-3">{{ $order->order_date->format('M d, Y') }}</p>
                        
                        <p class="mb-1"><strong>Status:</strong></p>
                        @php
                            $badgeClass = match($order->status) {
                                'pending' => 'bg-warning text-dark',
                                'processing' => 'bg-info',
                                'shipped' => 'bg-primary',
                                'completed' => 'bg-success',
                                'cancelled' => 'bg-danger',
                                default => 'bg-secondary',
                            };
                        @endphp
                        <p class="mb-0"><span class="badge {{ $badgeClass }}">{{ ucfirst($order->status) }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="mb-0">Order Summary</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <h3 class="mb-0 fw-bold text-success">Total Amount: ${{ number_format($order->total_amount, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Order Items</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Product Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($item->product->image_url)
                                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="rounded me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <div class="bg-primary-light rounded d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-box text-primary"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-medium">{{ $item->product->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted">${{ number_format($item->price_at_time_of_purchase, 2) }}</span>
                            </td>
                            <td>
                                <span class="badge bg-primary-light text-primary">{{ $item->quantity }}</span>
                            </td>
                            <td>
                                <span class="fw-bold text-success">${{ number_format($item->price_at_time_of_purchase * $item->quantity, 2) }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection