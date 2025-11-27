@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="page-header">
    <h1 class="page-title">Categories</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Category
    </a>
</div>

@if($categories->count() > 0)
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Product Count</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary-light rounded d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    <i class="fas fa-tags text-primary"></i>
                                </div>
                                <div>
                                    <div class="fw-medium">{{ $category->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="text-muted">{{ Str::limit($category->description, 50) ?? 'N/A' }}</div>
                        </td>
                        <td>
                            <span class="badge bg-info-light text-info">{{ $category->products->count() }}</span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('categories.show', $category->id) }}" class="btn btn-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');" class="d-inline">
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
        {{ $categories->links() }}
    </div>
@else
    <div class="alert alert-warning" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>No categories found. <a href="{{ route('categories.create') }}" class="alert-link">Add the first one!</a>
    </div>
@endif
@endsection