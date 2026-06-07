<?php

namespace App\Http\Controllers;

use App\Models\GalleryCase;
use App\Models\Treatment;

class GalleryController extends Controller
{
    public function index()
    {
        return view('pages.gallery', [
            'cases'      => GalleryCase::published()->with('treatment')->orderBy('sort_order')->get(),
            'treatments' => Treatment::active()->whereHas('galleryCases', fn ($q) => $q->published())->orderBy('name')->get(),
        ]);
    }
}
