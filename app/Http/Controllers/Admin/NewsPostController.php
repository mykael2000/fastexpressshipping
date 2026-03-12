<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NewsPostController extends Controller
{
    public function index()
    {
        $posts = NewsPost::latest()->paginate(20);
        return view('admin.news-posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.news-posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:news_posts,slug',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string',
            'published_at' => 'nullable|date',
            'is_published' => 'nullable|boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);
        $validated['author_id'] = Auth::id();
        $validated['is_published'] = $request->boolean('is_published');
        $validated['published_at'] = $validated['published_at'] ?? now();

        NewsPost::create($validated);
        return redirect()->route('admin.news-posts.index')->with('success', 'News post created.');
    }

    public function edit(NewsPost $newsPost)
    {
        return view('admin.news-posts.edit', compact('newsPost'));
    }

    public function update(Request $request, NewsPost $newsPost)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:news_posts,slug,' . $newsPost->id,
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string',
            'published_at' => 'nullable|date',
            'is_published' => 'nullable|boolean',
        ]);
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);
        $validated['is_published'] = $request->boolean('is_published');
        $newsPost->update($validated);
        return redirect()->route('admin.news-posts.index')->with('success', 'News post updated.');
    }

    public function destroy(NewsPost $newsPost)
    {
        $newsPost->delete();
        return redirect()->route('admin.news-posts.index')->with('success', 'News post deleted.');
    }
}
