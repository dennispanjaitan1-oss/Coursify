<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    private const KEYS = [
        'email_notification',
        'maintenance_mode',
        'open_registration',
        'auto_approval',
        'dark_mode',
    ];

    public function index(): View
    {
        $settings = collect(self::KEYS)
            ->mapWithKeys(fn (string $key) => [$key => Setting::get($key, $this->defaultValue($key)) === '1']);

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email_notification' => ['nullable', 'boolean'],
            'maintenance_mode' => ['nullable', 'boolean'],
            'open_registration' => ['nullable', 'boolean'],
            'auto_approval' => ['nullable', 'boolean'],
            'dark_mode' => ['nullable', 'boolean'],
        ]);

        foreach (self::KEYS as $key) {
            Setting::set($key, array_key_exists($key, $validated) ? '1' : '0');
        }

        return redirect()->route('admin.settings')->with('success', 'Pengaturan berhasil disimpan.');
    }

    private function defaultValue(string $key): string
    {
        return in_array($key, ['email_notification', 'open_registration'], true) ? '1' : '0';
    }
}
