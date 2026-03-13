<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StaticPageController extends Controller
{
    public function index()
    {
        $pages = StaticPage::orderBy('nav_order')->get();
        return view('admin.static-pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.static-pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:static_pages,slug',
            'content' => 'required|string',
            'show_in_nav' => 'nullable|boolean',
            'nav_order' => 'nullable|integer|min:0',
            'is_published' => 'nullable|boolean',
        ]);
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);
        $validated['show_in_nav'] = $request->boolean('show_in_nav');
        $validated['is_published'] = $request->boolean('is_published');
        StaticPage::create($validated);
        return redirect()->route('admin.static-pages.index')->with('success', 'Page created.');
    }

    public function edit(StaticPage $staticPage)
    {
        return view('admin.static-pages.edit', compact('staticPage'));
    }

    public function update(Request $request, StaticPage $staticPage)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:static_pages,slug,' . $staticPage->id,
            'content' => 'required|string',
            'show_in_nav' => 'nullable|boolean',
            'nav_order' => 'nullable|integer|min:0',
            'is_published' => 'nullable|boolean',
        ]);
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);
        $validated['show_in_nav'] = $request->boolean('show_in_nav');
        $validated['is_published'] = $request->boolean('is_published');
        $staticPage->update($validated);
        return redirect()->route('admin.static-pages.index')->with('success', 'Page updated.');
    }

    public function destroy(StaticPage $staticPage)
    {
        $staticPage->delete();
        return redirect()->route('admin.static-pages.index')->with('success', 'Page deleted.');
    }
}
