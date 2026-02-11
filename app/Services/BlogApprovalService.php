<?php
namespace App\Services;

use Illuminate\Support\Facades\{DB, Log};
use App\Models\Blog;
use App\Jobs\PublishBlogJob;
use Carbon\Carbon;

class BlogApprovalService {
    
    public function approve($blog_id, Carbon $publish_at){
        // DB::transaction(function () use ($blog_id, $publish_at){

            // update blog status

            $blog = Blog::findOrFail($blog_id);
            
            $blog->update([
                'status'=>'scheduled',
                'publish_at'=>$publish_at,
                'approved_at'=>Carbon::now()
            ]);

            // schedule published job

            Log::info("Blog scheduled for approval");

            PublishBlogJob::dispatch($blog_id)->delay($publish_at);
        // });
    }
}