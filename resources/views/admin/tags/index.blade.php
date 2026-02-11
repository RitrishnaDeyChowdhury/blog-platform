@extends('layouts.app')

@section('title', 'Tags')

@section('content')
<div class="container-fluid py-4">
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <h3 class="fw-semibold mb-3 mb-md-0">Tags</h3>

        <a href="{{ route('tags.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Add Tags
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
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tags as $tag)
                            <tr>
                                <td class="ps-4 fw-medium">
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    <span class="fw-semibold">{{ $tag->name }}</span>
                                </td>

                                <td>
                                    <span class="text-muted">{{ $tag->slug }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    No tags found.
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
