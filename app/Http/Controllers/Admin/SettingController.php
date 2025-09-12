<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $freeShippingSetting = Setting::firstOrCreate(
            ['key' => 'free_shipping_threshold'],
            ['value' => '100', 'status' => false]
        );

        return view('admin.settings.index', compact('freeShippingSetting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'value' => 'required|numeric|min:0'
        ]);

        $freeShippingSetting = Setting::where('key', 'free_shipping_threshold')->first();
        $freeShippingSetting->update([
            'value' => $request->value,
            'status' => $request->has('status')
        ]);

        return redirect()->back()->with('success', 'Free shipping settings updated successfully');
    }
}
