<?php
namespace App\Http\Controllers;

use App\Models\NewsPost;
use App\Models\ServiceAlert;
use App\Models\StaticPage;
use Illuminate\Http\Request;

class PublicPageController extends Controller
{
    public function services()
    {
        return view('public.services');
    }

    public function about()
    {
        return view('public.about');
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function faq()
    {
        return view('public.faq');
    }

    public function serviceAlerts()
    {
        $alerts = ServiceAlert::active()->latest()->get();
        return view('public.service-alerts', compact('alerts'));
    }

    public function newsIndex()
    {
        $posts = NewsPost::published()->latest('published_at')->paginate(9);
        return view('public.news.index', compact('posts'));
    }

    public function newsShow(string $slug)
    {
        $post = NewsPost::published()->where('slug', $slug)->firstOrFail();
        $recent = NewsPost::published()->where('id', '!=', $post->id)->latest('published_at')->take(3)->get();
        return view('public.news.show', compact('post', 'recent'));
    }

    public function page(string $slug)
    {
        $page = StaticPage::where('slug', $slug)->where('is_published', true)->firstOrFail();
        return view('public.page', compact('page'));
    }
}
