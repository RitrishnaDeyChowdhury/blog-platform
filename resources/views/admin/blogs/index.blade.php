@extends('layouts.app')

@section('title', 'Blog List')

@section('content')
<div class="container-fluid py-4">

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <h3 class="fw-semibold mb-3 mb-md-0">Blog List</h3>

        <a href="{{ route('blogs.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Add Blog
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($blogs as $blog)
                    @php
                        // Map status to Bootstrap badge classes
                        $statusClasses = [
                            'draft'     => 'bg-secondary text-light',
                            'pending'   => 'bg-warning text-dark',
                            'approved'  => 'bg-success text-light',
                            'scheduled' => 'bg-info text-dark',
                            'published' => 'bg-primary text-light',
                        ];

                        // Default class if status not in list
                        $badgeClass = $statusClasses[$blog->status] ?? 'bg-secondary text-light';
                    @endphp
                    <tr>
                        <td>{{ $blog->id }}</td>
                        <td>{{ $blog->title }}</td>
                        <td>{{ $blog->category->name }}</td>
                        <td><span class="badge {{ $badgeClass }}">{{ ucfirst($blog->status) }}</span></td>
                        <td>{{ $blog->created_at->format('d M Y') }}</td>
                        <td>
                            <button title="View" class="btn btn-warning view-blog" data-bs-toggle="modal" data-bs-target="#blogModal" data-title="{{ $blog->title }}" data-content="{{ $blog->content }}" data-image={{ asset('storage/' . $blog->featured_image) }} data-status={{$blog->status}} data-id="{{ $blog->id }}"><i class="bi bi-eye"></i>
                            </button>

                            <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-outline-warning" title="Edit"> <i class="bi bi-pencil-square"></i></a>

                            <form action="{{ route('blogs.destroy', $blog->id) }}"  method="POST" onsubmit="return confirm('Are you sure you want to delete this blogs?');">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No pending blogs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $blogs->links() }}
        </div>
    </div>
</div>

{{-- Start Blog View Modal --}}
<div class="modal fade" id="blogModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="text-center mb-3">
                    <img id="modalImage" src="" class="img-fluid rounded" style="max-height: 300px;">
                </div>

                <div id="modalContent" class="mt-2"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>


{{-- End Blog View Modal --}}   
@endsection

@push('scripts')
<script>
    $(document).on('click', '.view-blog', function () {
        const $btn = $(this);

        $('#modalTitle').text($btn.data('title'));
        $('#modalContent').html($btn.data('content'));
        $('#modalStatus').val($btn.data('status'));
        $('#modalBlogId').val($btn.data('id'));

        const image = $btn.data('image');
        if (image) {
            $('#modalImage').attr('src', image).show();
        } else {
            $('#modalImage').hide();
        }
    });
</script>
@endpush

