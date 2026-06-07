<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('kategori');

        $posts = BlogPost::published()
            ->with('category')
            ->when($category, fn ($q) => $q->whereHas('category', fn ($c) => $c->where('slug', $category)))
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('pages.blog.index', [
            'posts'      => $posts,
            'categories' => BlogCategory::withCount(['posts' => fn ($q) => $q->published()])->orderBy('name')->get(),
            'active'     => $category,
        ]);
    }

    public function show(BlogPost $post)
    {
        abort_unless($post->is_published, 404);

        $jsonLd = json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $post->title,
            'description' => strip_tags((string) $post->excerpt),
            'datePublished' => optional($post->published_at)->toIso8601String(),
            'author' => ['@type' => 'Person', 'name' => $post->author ?: site('short_name')],
            'publisher' => ['@type' => 'Organization', 'name' => site('name')],
            'image' => $post->coverUrl(),
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return view('pages.blog.show', [
            'post'    => $post->load('category'),
            'related' => BlogPost::published()->where('id', '!=', $post->id)
                ->when($post->blog_category_id, fn ($q) => $q->where('blog_category_id', $post->blog_category_id))
                ->latest('published_at')->take(3)->get(),
            'jsonLd'  => $jsonLd,
        ]);
    }
}
