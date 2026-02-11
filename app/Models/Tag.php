<?php

namespace App\Models;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name', 'slug'];

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => [
                'name' => $value,
                'slug' => Str::slug($value),
            ]
        );
    }

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_tag', 'tag_id', 'blog_id');
    }
    
}
