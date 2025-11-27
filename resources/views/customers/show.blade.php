@extends('layouts.app')

@section('title', 'Customer Details')

@section('content')
<div class="page-header">
    <h1 class="page-title">Customer Details</h1>
    <div>
        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit Customer
        </a>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h3 class="mb-0">{{ $customer->name }}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <p class="mb-1"><strong>Email:</strong></p>
                @if($customer->email)
                    <p class="text-muted mb-3">
                        <a href="mailto:{{ $customer->email }}" class="text-decoration-none">
                            <i class="fas fa-envelope me-1"></i>{{ $customer->email }}
                        </a>
                    </p>
                @else
                    <p class="text-muted mb-3">N/A</p>
                @endif
                
                <p class="mb-1"><strong>Phone:</strong></p>
                @if($customer->phone)
                    <p class="text-muted mb-0">
                        <a href="tel:{{ $customer->phone }}" class="text-decoration-none">
                            <i class="fas fa-phone me-1"></i>{{ $customer->phone }}
                        </a>
                    </p>
                @else
                    <p class="text-muted mb-0">N/A</p>
                @endif
            </div>
            <div class="col-md-6 mb-3">
                <p class="mb-1"><strong>Address:</strong></p>
                <p class="text-muted mb-0">{{ $customer->address ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>

@if($customer->orders->count() > 0)
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Order History</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Order ID</th>
                            <th scope="col">Order Date</th>
                            <th scope="col">Total Amount</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customer->orders as $order)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary-light rounded d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-receipt text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-medium">#{{ $order->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $order->order_date->format('M d, Y') }}</span>
                                </td>
                                <td>
                                    <span class="fw-bold text-success">${{ number_format($order->total_amount, 2) }}</span>
                                </td>
                                <td>
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
                                    <span class="badge {{ $badgeClass }}">{{ ucfirst($order->status) }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-info">
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
            <h4 class="mb-0">Order History</h4>
        </div>
        <div class="card-body">
            <div class="alert alert-info mb-0">
                <i class="fas fa-info-circle me-2"></i>This customer has no orders yet.
            </div>
        </div>
    </div>
@endif
@endsection