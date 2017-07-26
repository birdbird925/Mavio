<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;

class PageController extends Controller
{
    public function index()
    {
        return view('page');
    }

    public function home()
    {
        $tag = Tag::where('name', 'featured')->first();
        $featured = $tag->products;
        return view('home', compact('featured'));
    }

    public function faq()
    {
        return view('faq');
    }

    public function about()
    {
        return view('about');
    }
}
