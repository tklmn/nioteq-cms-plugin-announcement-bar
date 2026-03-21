<?php

namespace Plugins\AnnouncementBar;

use App\Services\Plugins\PluginServiceProvider;
use Illuminate\Support\Facades\View;

class AnnouncementBarServiceProvider extends PluginServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $viewPath = $this->getPluginPath() . '/views';
        $langPath = $this->getPluginPath() . '/lang';

        View::addNamespace('announcement-bar', $viewPath);
        $this->app['translator']->addNamespace('announcement-bar', $langPath);

        // Register a body hook so the bar renders on every frontend page
        $this->extensions()->registerBodyHook('announcement-bar::bar');

        // Register a sidebar item for the settings page
        $this->extensions()->registerSidebarItem([
            'label' => 'Announcement Bar',
            'route' => 'backend.announcement-bar.settings',
            'icon' => 'bi bi-megaphone',
            'permission' => 'manage-plugins',
        ]);

        // Register the settings route
        $this->routes()->backend('announcement-bar', function () {
            \Illuminate\Support\Facades\Route::get('settings', [SettingsController::class, 'edit'])
                ->name('backend.announcement-bar.settings');
            \Illuminate\Support\Facades\Route::post('settings', [SettingsController::class, 'update'])
                ->name('backend.announcement-bar.settings.save');
        });
    }

    public function install(): void
    {
        // Seed default settings
        $this->settings()->set('announcement_bar.enabled', '0', 'plugin_setting', 'Announcement bar enabled');
        $this->settings()->set('announcement_bar.message', 'Welcome to our site!', 'plugin_setting', 'Announcement bar message');
        $this->settings()->set('announcement_bar.bg_color', '#fbbf24', 'plugin_setting', 'Announcement bar background color');
        $this->settings()->set('announcement_bar.text_color', '#1c1917', 'plugin_setting', 'Announcement bar text color');
        $this->settings()->set('announcement_bar.dismissible', '1', 'plugin_setting', 'Announcement bar can be dismissed');
        $this->settings()->set('announcement_bar.position', 'top', 'plugin_setting', 'Announcement bar position (top or bottom)');
        $this->settings()->set('announcement_bar.link_url', '', 'plugin_setting', 'Announcement bar link URL');
        $this->settings()->set('announcement_bar.link_text', '', 'plugin_setting', 'Announcement bar link text');
    }

    public function uninstall(): void
    {
        $this->settings()->delete('announcement_bar.enabled');
        $this->settings()->delete('announcement_bar.message');
        $this->settings()->delete('announcement_bar.bg_color');
        $this->settings()->delete('announcement_bar.text_color');
        $this->settings()->delete('announcement_bar.dismissible');
        $this->settings()->delete('announcement_bar.position');
        $this->settings()->delete('announcement_bar.link_url');
        $this->settings()->delete('announcement_bar.link_text');
    }
}
