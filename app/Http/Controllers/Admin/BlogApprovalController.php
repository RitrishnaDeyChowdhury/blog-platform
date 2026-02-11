<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BlogApprovalService;
use App\Notifications\BlogApprovedNotification;

class BlogApprovalController extends Controller
{
    public function index(){
        $blogs = Blog::where('status', 'draft')->latest()->get();

        //dd($blogs);
        return view('admin.blogs.pending',compact('blogs'));
    }

    public function updateStatus(Request $request, BlogApprovalService $blogApprovalService)
    {
        $request->validate([
            'blog_id' => 'required|exists:blogs,id',
            'status'  => 'required|in:draft,approved,scheduled,published',
        ]);

        if($request->status == 'approved'){
            $blogApprovalService->approve($request->blog_id, Carbon::parse($request->publish_at));

        }else if($request->status == 'published'){
            $blog = Blog::findOrFail($request->blog_id);
            $blog->update(['status' => $request->status, 'publish_at' => $request->publish_at]);

            
            $blog->users->notify(new BlogApprovedNotification($request->blog_id));
            
        }

        return back()->with('success', 'Blog status updated successfully.');
    }

}
