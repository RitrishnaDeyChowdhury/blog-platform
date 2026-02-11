<?php

namespace App\Models;
use App\Models\Blog;
use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    protected static function booted(){
        static::observe(CategoryObserver::class);
    }
}
