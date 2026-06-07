<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Doctor;
use App\Models\GalleryCase;
use App\Models\Testimonial;
use App\Models\Treatment;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.home', [
            'treatments'   => Treatment::active()->orderBy('sort_order')->take(6)->get(),
            'doctors'      => Doctor::active()->orderBy('sort_order')->take(4)->get(),
            'testimonials' => Testimonial::approved()->orderByDesc('is_featured')->orderBy('sort_order')->take(6)->get(),
            'cases'        => GalleryCase::published()->with('treatment')->orderBy('sort_order')->take(6)->get(),
            'posts'        => BlogPost::published()->with('category')->latest('published_at')->take(3)->get(),
        ]);
    }
}
