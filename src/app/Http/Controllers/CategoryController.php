<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }
    
    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if (Category::where('name', $request->name)->exists()) {
            flash()->warning(__('messages.duplicate_resource', [
                'article' => __('categories.article'),
                'resource' => __('categories.singular'),
            ]));
            return redirect()->back()->withInput();
        }

        Category::create([
            'name' => $request->name,
        ]);

        flash()->success(__('messages.created_successfully', [
            'resource' => __('categories.singular')
        ]));

        return redirect()->route('admin.categories.index');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        $newName = trim(Str::lower($request->name));
        $currentName = trim(Str::lower($category->name));

        if ($newName !== $currentName) {
            if (Category::whereRaw('LOWER(name) = ?', [$newName])->where('id', '!=', $category->id)->exists()) {
                flash()->warning(__('messages.duplicate_resource', [
                    'article' => __('categories.article'),
                    'resource' => __('categories.singular'),
                ]));
                return redirect()->back()->withInput();
            }

            $category->name = $request->name;
            $category->slug = Str::slug($request->name);
            $category->save();
        }

        flash()->success(__('messages.updated_successfully', [
            'resource' => __('categories.singular')
        ]));

        return redirect()->route('admin.categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        flash()->success(__('messages.deleted_successfully', [
            'resource' => __('categories.singular')
        ]));

        return redirect()->route('admin.categories.index');
    }
}
