@extends('layouts.app')

@section('title', 'Customer Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Customer Details</h1>
    <div>
        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit Customer
        </a>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>{{ $customer->name }}</h3>
    </div>
    <div class="card-body">
        <p><strong>Email:</strong> {{ $customer->email ?? 'N/A' }}</p>
        <p><strong>Phone:</strong> {{ $customer->phone ?? 'N/A' }}</p>
        <p><strong>Address:</strong> {{ $customer->address ?? 'N/A' }}</p>
    </div>
</div>

@if($customer->orders->count() > 0)
    <div class="mt-5">
        <h3>Order History</h3>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customer->orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->order_date->format('M d, Y') }}</td>
                            <td>${{ number_format($order->total_amount, 2) }}</td>
                            <td><span class="badge bg-primary">{{ $order->status }}</span></td>
                            <td>
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-info">View Order</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="mt-5">
        <h3>Order History</h3>
        <p>This customer has no orders yet.</p>
    </div>
@endif
@endsection