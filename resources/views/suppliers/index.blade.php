@extends('layouts.app')

@section('title', 'Suppliers')

@section('content')
<div class="page-header">
    <h1 class="page-title">Suppliers</h1>
    <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Supplier
    </a>
</div>

@if($suppliers->count() > 0)
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Contact Person</th>
                    <th scope="col">Email</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suppliers as $supplier)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary-light rounded d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    <i class="fas fa-truck text-primary"></i>
                                </div>
                                <div>
                                    <div class="fw-medium">{{ $supplier->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>{{ $supplier->contact_person ?? 'N/A' }}</div>
                        </td>
                        <td>
                            @if($supplier->email)
                                <a href="mailto:{{ $supplier->email }}" class="text-decoration-none">
                                    <i class="fas fa-envelope me-1"></i>{{ $supplier->email }}
                                </a>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn btn-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this supplier?');" class="d-inline">
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
        {{ $suppliers->links() }}
    </div>
@else
    <div class="alert alert-warning" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>No suppliers found. <a href="{{ route('suppliers.create') }}" class="alert-link">Add the first one!</a>
    </div>
@endif
@endsection