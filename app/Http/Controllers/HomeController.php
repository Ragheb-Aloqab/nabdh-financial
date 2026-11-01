<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\MediaItem;
use App\Models\PageSection;
use App\Models\Partner;
use App\Models\Pillar;
use App\Models\Program;
use App\Models\ProgramPhase;
use App\Models\RoadmapStep;
use App\Models\SiteSetting;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $settings = SiteSetting::current();

        $sections = PageSection::where('is_visible', true)
            ->orderBy('sort_order')
            ->get()
            ->keyBy('section_key');

        $pillars = Pillar::where('is_published', true)
            ->orderBy('sort_order')
            ->get();

        $programs = Program::where('is_published', true)
            ->orderBy('sort_order')
            ->get();

        $phases = ProgramPhase::where('is_published', true)
            ->orderBy('phase_number')
            ->get();

        $roadmapSteps = RoadmapStep::where('is_published', true)
            ->orderBy('step_number')
            ->get();

        $achievements = Achievement::where('is_published', true)
            ->orderBy('sort_order')
            ->get();

        $testimonials = Testimonial::where('is_published', true)
            ->orderBy('sort_order')
            ->get();

        $teamMembers = TeamMember::where('is_published', true)
            ->orderBy('sort_order')
            ->get();

        $partners = Partner::where('is_published', true)
            ->orderBy('sort_order')
            ->get();

        $mediaItems = MediaItem::where('is_published', true)
            ->orderBy('sort_order')
            ->get();

        return view('home', compact(
            'settings',
            'sections',
            'pillars',
            'programs',
            'phases',
            'roadmapSteps',
            'achievements',
            'testimonials',
            'teamMembers',
            'partners',
            'mediaItems'
        ));
    }
}
