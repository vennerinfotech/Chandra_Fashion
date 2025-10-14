<?php

namespace App\Http\Controllers\Admin;

use App\Models\About;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    // copy of your SettingController helper (stores under public/images/<subFolder>)
    protected function storeImagePublic($file, $subFolder)
    {
        if ($file instanceof \Illuminate\Http\UploadedFile) {
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $path = public_path('images/' . $subFolder);
            if (!file_exists($path)) mkdir($path, 0755, true);
            $file->move($path, $filename);
            return 'images/' . $subFolder . '/' . $filename;
        }
        return null;
    }

    public function manage()
    {
        $about = About::first();
        return view('admin.settings.about', compact('about'));
    }

    // Update or create the about content
    public function update(Request $request)
    {
        $request->validate([
            'about_title' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer',
            'hero_image' => 'nullable|image|max:4096',
            // Add more validation as needed
        ]);

        $about = About::first() ?? new About();

        // Basic fields
        $about->about_title = $request->about_title ?? $about->about_title;
        $about->about_subtitle = $request->about_subtitle ?? $about->about_subtitle;
        $about->paragraph1 = $request->paragraph1 ?? $about->paragraph1;
        $about->paragraph2 = $request->paragraph2 ?? $about->paragraph2;
        $about->experience_years = $request->experience_years ?? $about->experience_years;
        $about->testimonial_text = $request->testimonial_text ?? $about->testimonial_text;
        $about->testimonial_author = $request->testimonial_author ?? $about->testimonial_author;
        $about->why_title = $request->why_title ?? $about->why_title;
        $about->why_paragraph = $request->why_paragraph ?? $about->why_paragraph;
        $about->why_choose_us_1 = $request->why_choose_us_1;
        $about->why_choose_us_2 = $request->why_choose_us_2;
        // Hero image handling
        if ($request->hasFile('hero_image')) {
            if ($about->hero_image && file_exists(public_path($about->hero_image))) {
                @unlink(public_path($about->hero_image));
            }
            $about->hero_image = $this->storeImagePublic($request->file('hero_image'), 'about');
        }
        // Why Choose Us Image Upload
        if ($request->hasFile('why_choose_us_image')) {
            if ($about->why_choose_us_image && file_exists(public_path($about->why_choose_us_image))) {
                @unlink(public_path($about->why_choose_us_image));
            }
            $about->why_choose_us_image = $this->storeImagePublic($request->file('why_choose_us_image'), 'about/why');
        }

        // Why list (array of bullets)
        $why_list = array_values(array_filter($request->input('why_list', []), fn($v) => trim($v) !== ''));
        $about->why_list = $why_list;

        // Stats (labels, numbers, suffix)
        $stats = [];
        $labels = $request->input('stats_label', []);
        $numbers = $request->input('stats_number', []);
        $suffixes = $request->input('stats_suffix', []);
        foreach ($labels as $i => $label) {
            if (trim($label) === '') continue;
            $stats[] = [
                'label' => $label,
                'number' => $numbers[$i] ?? 0,
                'suffix' => $suffixes[$i] ?? '',
            ];
        }
        $about->stats = $stats;

        // Team members (dynamic). We expect: team_name[], team_designation[], team_image[] and existing_team_image[] (hidden paths)
        $team = [];
        $teamNames = $request->input('team_name', []);
        $teamDesignations = $request->input('team_designation', []);
        $existingTeamImages = $request->input('existing_team_image', []);
        $teamImages = $request->file('team_image') ?? [];

        foreach ($teamNames as $i => $name) {
            if (trim($name) === '') continue;

            // prefer uploaded file
            $imagePath = $existingTeamImages[$i] ?? null;

            if (isset($teamImages[$i]) && $teamImages[$i] instanceof \Illuminate\Http\UploadedFile) {
                // delete old if existed
                if ($imagePath && file_exists(public_path($imagePath))) {
                    @unlink(public_path($imagePath));
                }
                $imagePath = $this->storeImagePublic($teamImages[$i], 'about/team');
            }

            $team[] = [
                'name' => $name,
                'designation' => $teamDesignations[$i] ?? '',
                'image' => $imagePath,
            ];
        }
        $about->team = $team;

        $about->save();

        return back()->with('success', 'About section updated successfully.');
    }
}
