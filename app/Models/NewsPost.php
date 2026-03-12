<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id', 'title', 'slug', 'excerpt', 'body',
        'image', 'published_at', 'is_published',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
}
