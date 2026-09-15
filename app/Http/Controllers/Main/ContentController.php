<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\SiteSetting;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function consultation(): View
    {
        return view('main.consultation', ['siteSettings' => SiteSetting::current()]);
    }

    public function blog(): View
    {
        $posts = BlogPost::query()
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderByDesc('is_featured')
            ->latest('published_at')
            ->paginate(9);

        return view('main.blogsurge', ['posts' => $posts, 'siteSettings' => SiteSetting::current()]);
    }

    public function post(string $slug): View
    {
        $post = BlogPost::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->firstOrFail();

        return view('main.blogsurge-post', ['post' => $post, 'siteSettings' => SiteSetting::current()]);
    }
}
