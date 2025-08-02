<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Http\Requests\ColorRequest;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colors = Color::notDeleted()
            ->latest()
            ->paginate(10);
        return view('admin.color.index', compact('colors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.color.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ColorRequest $request)
    {
        Color::create($request->validated());

        return redirect()->route('admin.color.index')->with('success', 'Color created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Color $color)
    {
        return view('admin.color.show', compact('color'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Color $color)
    {
        return view('admin.color.edit', compact('color'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ColorRequest $request, Color $color)
    {
        $color->update($request->validated());

        return redirect()->route('admin.color.index')->with('success', 'Color updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color)
    {
        // Get product count for success message
        $productCount = $color->products()->count();
        
        // Soft delete all products first (if applicable)
        if ($productCount > 0) {
            $color->products()->update(['is_deleted' => true]);
        }
        
        // Then soft delete the color
        $color->softDelete();
        
        $message = 'Color deleted successfully.';
        if ($productCount > 0) {
            $message .= " {$productCount} associated product(s) were also deleted.";
        }
        
        return redirect()->route('admin.color.index')->with('success', $message);
    }

    /**
     * Toggle the status of the specified resource.
     */
    public function toggleStatus(Color $color)
    {
        $color->toggleStatus();
        return back()->with('success', 'Color status updated successfully.');
    }
}
