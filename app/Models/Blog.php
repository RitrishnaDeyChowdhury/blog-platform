<?php

namespace App\Models;

use App\Models\{Category, User};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'featured_image',
        'slug',
        'content',
        'status',
        'publish_at',
        'approved_at',
    ];

    protected $casts = [
        'approved_at'  => 'datetime',
        'publish_at' => 'datetime',
    ];

    // Blog belongs to a author
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'blog_tag', 'blog_id', 'tag_id');
    }
}
