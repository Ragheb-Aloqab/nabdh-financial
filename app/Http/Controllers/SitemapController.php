<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $programs = Program::where('is_published', true)->orderBy('updated_at', 'desc')->get();

        $content = view('sitemap', compact('programs'))->render();

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }
}
