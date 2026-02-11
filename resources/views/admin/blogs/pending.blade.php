@extends('layouts.app')

@section('title', 'Blog Approval')

@section('content')
<div class="container">
    <h2 class="mb-4">Pending Blogs</h2>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($blogs as $blog)
                    <tr>
                        <td>{{ $blog->id }}</td>
                        <td>{{ $blog->title }}</td>
                        <td>{{ $blog->category->name }}</td>
                        <td>{{ $blog->created_at->format('d M Y') }}</td>
                        <td>
                            {{-- <a href="{{ route('admin.blogs.approve', $blog->id) }}" class="btn btn-sm btn-success">Approve</a>
                            <a href="{{ route('admin.blogs.reject', $blog->id) }}" class="btn btn-sm btn-danger">Reject</a> --}}

                            <button class="btn btn-warning view-blog" data-bs-toggle="modal" data-bs-target="#blogModal" data-title="{{ $blog->title }}" data-content="{{ $blog->content }}" data-image={{ asset('storage/' . $blog->featured_image) }} data-status={{$blog->status}} data-id="{{ $blog->id }}"><i class="bi bi-eye"></i></button>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No pending blogs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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

                <form method="POST" action="{{ route('blogs.updateStatus') }}">
                    @csrf
                    @method('PATCH')
                
                    <input type="hidden" name="blog_id" id="modalBlogId">
                    <div class="row">
                        <div class="col-md-5">
                            <select name="status" id="modalStatus" class="form-control" required>
                                <option value="">Change Status</option>
                                <option value="draft">Draft</option>
                                <option value="approved">Approved</option>
                                <option value="published">Published</option>
                            </select>
                        </div>
                        <div class="col-md-5 d-flex">
                            <input type="datetime-local" class="form-control mx-2" name="publish_at" min="{{ now()->format('Y-m-d\TH:i') }}" value="{{ now()->format('Y-m-d\TH:i') }}"/>
                            <button class="btn btn-primary btn-sm w-100">
                                Update
                            </button>
                        </div>
                    </div>
                    
                </form>

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
