@extends('layouts.app')

@section('title', 'Customers')

@section('content')
<div class="page-header">
    <h1 class="page-title">Customers</h1>
    <a href="{{ route('customers.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Customer
    </a>
</div>

@if($customers->count() > 0)
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary-light rounded d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div>
                                    <div class="fw-medium">{{ $customer->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($customer->email)
                                <a href="mailto:{{ $customer->email }}" class="text-decoration-none">
                                    <i class="fas fa-envelope me-1"></i>{{ $customer->email }}
                                </a>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            @if($customer->phone)
                                <a href="tel:{{ $customer->phone }}" class="text-decoration-none">
                                    <i class="fas fa-phone me-1"></i>{{ $customer->phone }}
                                </a>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this customer?');" class="d-inline">
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
        {{ $customers->links() }}
    </div>
@else
    <div class="alert alert-warning" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>No customers found. <a href="{{ route('customers.create') }}" class="alert-link">Add the first one!</a>
    </div>
@endif
@endsection