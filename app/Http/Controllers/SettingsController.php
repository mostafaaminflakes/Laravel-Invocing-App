<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SettingsRequest;
use App\Classes\Settings;
use App\Models\User;

class SettingsController extends Controller
{
    public function load_settings()
    {
        return view('settings');
    }

    public function save_settings(SettingsRequest $request, Settings $settings)
    {
        // Update Users table
        $data = $request->only(['name', 'email']);
        $user = User::find(auth()->id());
        $user->update($data);

        // Update the config file
        $settings->reset($settings->allStartingWith('sfc_search_meta'), 'off');
        $settings->reset($settings->allStartingWith('sfc_allow'), 'off');
        $required_settings = $request->except(['_token', '_method', 'name', 'email']);

        foreach ($required_settings as $key => $value) {
            if ($settings->has('sfc_' . $key)) {
                $settings->put('sfc_' . $key, $value);
            }
        }

        return redirect('settings')->with('status', __('Settings saved successfully.'));
    }
}
