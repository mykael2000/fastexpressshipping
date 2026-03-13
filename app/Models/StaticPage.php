<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'content', 'show_in_nav', 'nav_order', 'is_published',
    ];

    protected $casts = [
        'show_in_nav' => 'boolean',
        'is_published' => 'boolean',
        'nav_order' => 'integer',
    ];
}
