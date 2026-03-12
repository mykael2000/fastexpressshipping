@extends('layouts.admin')
@section('title', 'Static Pages')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-fes-navy">Static Pages</h1>
    <a href="{{ route('admin.static-pages.create') }}" class="bg-fes-orange text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-orange-600 transition inline-flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Create Page
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    @if($pages->isEmpty())
        <div class="py-16 text-center text-gray-400 text-sm">No static pages yet.</div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                    <tr>
                        <th class="px-5 py-3 text-left">Title</th>
                        <th class="px-5 py-3 text-left">Slug</th>
                        <th class="px-5 py-3 text-left">Nav Order</th>
                        <th class="px-5 py-3 text-left">Show in Nav</th>
                        <th class="px-5 py-3 text-left">Published</th>
                        <th class="px-5 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($pages as $page)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-4 font-medium text-gray-800">{{ $page->title }}</td>
                        <td class="px-5 py-4 font-mono text-xs text-gray-500">{{ $page->slug }}</td>
                        <td class="px-5 py-4 text-gray-500">{{ $page->nav_order ?? '—' }}</td>
                        <td class="px-5 py-4">
                            @if($page->show_in_nav)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Yes</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-400">No</span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            @if($page->is_published)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Published</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-400">Draft</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 flex items-center gap-3">
                            <a href="{{ route('admin.static-pages.edit', $page) }}" class="text-fes-orange hover:underline font-medium text-xs">Edit</a>
                            <a href="{{ route('pages.show', $page->slug) }}" target="_blank" class="text-gray-400 hover:text-gray-600 font-medium text-xs">View</a>
                            <form method="POST" action="{{ route('admin.static-pages.destroy', $page) }}" onsubmit="return confirm('Delete this page?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600 font-medium text-xs">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
