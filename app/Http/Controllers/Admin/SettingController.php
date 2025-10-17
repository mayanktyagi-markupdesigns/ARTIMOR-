<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    } 

    public function update(Request $request)
    {
        $submittedKeys   = $request->input('settings.keys', []);
        $submittedValues = $request->input('settings.values', []);

        // Step 1: Build submitted key-value pairs
        $newData = [];
        foreach ($submittedKeys as $index => $key) {
            $value = $submittedValues[$index] ?? null;

            if (!empty($key) && !is_null($value)) {
                $newData[$key] = $value;
            }
        }

        // Step 2: Get all existing keys from DB
        $existingSettings = Setting::pluck('id', 'key')->toArray();

        // Step 3: Delete keys that are missing in form submission
        foreach ($existingSettings as $existingKey => $id) {
            if (!array_key_exists($existingKey, $newData)) {
                Setting::where('key', $existingKey)->delete();
            }
        }

        // Step 4: Create or update submitted data
        foreach ($newData as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->back()->with('success', 'Settings updated successfully!');
        // return redirect()->route('admin.settings.edit')->with('success', 'Settings updated successfully!');
    }
}
