<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\SiteSetting;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function show(string $slug): View
    {
        $program = Program::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $settings = SiteSetting::current();

        $relatedPrograms = Program::where('is_published', true)
            ->where('id', '!=', $program->id)
            ->limit(3)
            ->get();

        return view('programs.show', compact('program', 'settings', 'relatedPrograms'));
    }
}
