<?php

namespace Plugins\AnnouncementBar;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function edit(): View
    {
        $settings = cms()->settings();

        return view('announcement-bar::settings', [
            'enabled' => $settings->get('announcement_bar.enabled', '0'),
            'message' => $settings->get('announcement_bar.message', ''),
            'bg_color' => $settings->get('announcement_bar.bg_color', '#fbbf24'),
            'text_color' => $settings->get('announcement_bar.text_color', '#1c1917'),
            'dismissible' => $settings->get('announcement_bar.dismissible', '1'),
            'position' => $settings->get('announcement_bar.position', 'top'),
            'link_url' => $settings->get('announcement_bar.link_url', ''),
            'link_text' => $settings->get('announcement_bar.link_text', ''),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'message' => 'required|string|max:500',
            'bg_color' => 'required|string|max:7',
            'text_color' => 'required|string|max:7',
            'position' => 'required|in:top,bottom',
            'link_url' => 'nullable|url|max:500',
            'link_text' => 'nullable|string|max:100',
        ]);

        $settings = cms()->settings();

        $settings->set('announcement_bar.enabled', $request->has('enabled') ? '1' : '0');
        $settings->set('announcement_bar.message', $request->input('message'));
        $settings->set('announcement_bar.bg_color', $request->input('bg_color'));
        $settings->set('announcement_bar.text_color', $request->input('text_color'));
        $settings->set('announcement_bar.dismissible', $request->has('dismissible') ? '1' : '0');
        $settings->set('announcement_bar.position', $request->input('position', 'top'));
        $settings->set('announcement_bar.link_url', $request->input('link_url', ''));
        $settings->set('announcement_bar.link_text', $request->input('link_text', ''));

        return redirect()->route('backend.announcement-bar.settings')
            ->with('success', __('announcement-bar::ab.saved'));
    }
}
