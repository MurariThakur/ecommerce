<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Http\Requests\BlogCategoryRequest;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogCategory::notDeleted();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $status = $request->status === 'active' ? 1 : 0;
            $query->where('status', $status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $blogCategories = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.blog-category.index', compact('blogCategories'));
    }

    public function create()
    {
        return view('admin.blog-category.create');
    }

    public function store(BlogCategoryRequest $request)
    {
        BlogCategory::create($request->validated());

        return redirect()->route('admin.blog-category.index')
            ->with('success', 'Blog category created successfully.');
    }

    public function show(BlogCategory $blogCategory)
    {
        return view('admin.blog-category.show', compact('blogCategory'));
    }

    public function edit(BlogCategory $blogCategory)
    {
        return view('admin.blog-category.edit', compact('blogCategory'));
    }

    public function update(BlogCategoryRequest $request, BlogCategory $blogCategory)
    {
        $blogCategory->update($request->validated());

        return redirect()->route('admin.blog-category.index')
            ->with('success', 'Blog category updated successfully.');
    }

    public function destroy(BlogCategory $blogCategory)
    {
        $blogCategory->softDelete();

        return redirect()->route('admin.blog-category.index')
            ->with('success', 'Blog category deleted successfully.');
    }

    public function toggleStatus(BlogCategory $blogCategory)
    {
        $blogCategory->toggleStatus();

        return redirect()->route('admin.blog-category.index')
            ->with('success', 'Blog category status updated successfully.');
    }
}