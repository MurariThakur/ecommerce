<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Http\Requests\FaqRequest;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('sort_order')->orderBy('created_at', 'desc')->get();
        return view('admin.faq.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faq.create');
    }

    public function store(FaqRequest $request)
    {
        Faq::create($request->validated());
        return redirect()->route('admin.faq.index')->with('success', 'FAQ created successfully!');
    }

    public function show(Faq $faq)
    {
        return view('admin.faq.show', compact('faq'));
    }

    public function edit(Faq $faq)
    {
        return view('admin.faq.edit', compact('faq'));
    }

    public function update(FaqRequest $request, Faq $faq)
    {
        $faq->update($request->validated());
        return redirect()->route('admin.faq.index')->with('success', 'FAQ updated successfully!');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faq.index')->with('success', 'FAQ deleted successfully!');
    }

    public function toggleStatus(Faq $faq)
    {
        $faq->update(['status' => !$faq->status]);
        $status = $faq->status ? 'activated' : 'deactivated';
        return redirect()->route('admin.faq.index')->with('success', "FAQ {$status} successfully!");
    }
}