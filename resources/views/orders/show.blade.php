@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Order Details</h1>
    <div>
        <a href="{{ route('orders.export-pdf', $order->id) }}" class="btn btn-success" target="_blank">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit Order
        </a>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4>Order Information</h4>
            </div>
            <div class="card-body">
                <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                <p><strong>Customer:</strong> {{ $order->customer->name }}</p>
                <p><strong>Order Date:</strong> {{ $order->order_date->format('M d, Y') }}</p>
                <p><strong>Status:</strong> <span class="badge bg-primary">{{ ucfirst($order->status) }}</span></p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4>Order Summary</h4>
            </div>
            <div class="card-body">
                <h3>Total Amount: ${{ number_format($order->total_amount, 2) }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="mt-5">
    <h3>Order Items</h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>${{ number_format($item->price_at_time_of_purchase, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->price_at_time_of_purchase * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection