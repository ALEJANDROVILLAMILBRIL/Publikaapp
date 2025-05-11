<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }
    
    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if (Category::where('name', $request->name)->exists()) {
            flash()->warning(__('messages.duplicate_resource', [
                'resource' => __('categories.singular')
            ]));
            return redirect()->back()->withInput();
        }

        Category::create([
            'name' => $request->name,
        ]);

        flash()->success('Category created successfully!');

        return redirect()->route('categories.index');
    }
}
