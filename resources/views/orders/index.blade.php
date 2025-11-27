@extends('layouts.app')

@section('title', 'Orders')

@section('content')
<div class="page-header">
    <h1 class="page-title">Orders</h1>
    <a href="{{ route('orders.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Create New Order
    </a>
</div>

@if($orders->count() > 0)
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Date</th>
                    <th scope="col">Total Amount</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
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
                            <div class="fw-medium">{{ $order->customer->name }}</div>
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
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure? This will delete the order and restore the stock.');" class="d-inline">
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
        {{ $orders->links() }}
    </div>
@else
    <div class="alert alert-warning" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>No orders found. <a href="{{ route('orders.create') }}" class="alert-link">Create the first one!</a>
    </div>
@endif
@endsection