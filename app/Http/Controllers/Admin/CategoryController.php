<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with(['subcategories' => function($query) {
                $query->notDeleted();
            }])
            ->notDeleted()
            ->latest()
            ->paginate(10);
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {

        Category::create($request->validated());

        return redirect()->route('admin.category.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('admin.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return redirect()->route('admin.category.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Get subcategory count for success message
        $subcategoryCount = $category->subcategories()->count();
        
        // Soft delete all subcategories first
        $category->subcategories()->update(['isdelete' => true]);
        
        // Then soft delete the category
        $category->softDelete();
        
        $message = 'Category deleted successfully.';
        if ($subcategoryCount > 0) {
            $message .= " {$subcategoryCount} associated subcategory(ies) were also deleted.";
        }
        
        return redirect()->route('admin.category.index')->with('success', $message);
    }

    /**
     * Toggle the status of the specified resource.
     */
    public function toggleStatus(Category $category)
    {
        $category->toggleStatus();
        return back()->with('success', 'Category status updated successfully.');
    }
}
