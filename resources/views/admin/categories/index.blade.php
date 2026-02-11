@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="container-fluid py-4">
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <h3 class="fw-semibold mb-3 mb-md-0">Categories</h3>

        <a href="{{ route('categories.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Add Category
        </a>
    </div>

    <!-- Card -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">

            <!-- Responsive Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 60px;">#</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th class="text-end pe-4" style="width: 150px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td class="ps-4 fw-medium">
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    <span class="fw-semibold">{{ $category->name }}</span>
                                </td>

                                <td>
                                    <span class="text-muted">{{ $category->slug }}</span>
                                </td>

                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('categories.edit', $category->id) }}"
                                           class="btn btn-outline-warning"
                                           title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('categories.destroy', $category->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this category?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-outline-danger"
                                                    title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    No categories found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection
