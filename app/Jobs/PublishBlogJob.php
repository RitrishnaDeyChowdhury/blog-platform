<?php

namespace App\Jobs;

use App\Models\Blog;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};

class PublishBlogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */


    public function __construct(public int $blog_id)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $blog = Blog::findOrFail($this->blog_id);

        if (! $blog) {
            Log::warning('PublishBlogJob: Blog not found', [
                'blog_id' => $this->blog_id
            ]);
            return;
        }

        Log::info('PublishBlogJob executed', [
            'blog_id' => $this->blog_id
        ]);

        if($blog->status !== 'scheduled'){
            return;
        }

        // update blog status

        $blog->update([
            'status'=>'published',
        ]);
    }
}
