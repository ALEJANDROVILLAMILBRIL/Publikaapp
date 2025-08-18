<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('created_at')) {
            $query->whereDate('created_at', $request->created_at);
        }

        $products = $query->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function homepage(Request $request)
    {
        $search = $request->input('search');

        if (empty($search)) {
            $products = Product::with('category:id,name')
                ->latest()
                ->paginate(12);
        } else {
            $products = Product::with('category:id,name')
                ->where('name', 'LIKE', "%{$search}%")
                ->latest()
                ->paginate(12)
                ->withQueryString();
        }

        return view('welcome', compact('products', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        if (Product::where('name', $request->name)->exists()) {
            flash()->warning(__('messages.duplicate_resource', [
                'article' => __('products.article'),
                'resource' => __('products.singular'),
            ]));
            return redirect()->back()->withInput();
        }

        Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
        ]);

        flash()->success(__('messages.created_successfully', [
            'resource' => ucfirst(__('products.singular'))
        ]));

        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $newName = trim(Str::lower($request->name));
        $currentName = trim(Str::lower($product->name));

        if ($newName !== $currentName) {
            if (Product::whereRaw('LOWER(name) = ?', [$newName])->where('id', '!=', $product->id)->exists()) {
                flash()->warning(__('messages.duplicate_resource', [
                    'article' => __('products.article'),
                    'resource' => __('products.singular'),
                ]));
                return redirect()->back()->withInput();
            }

            $product->name = $request->name;
            $product->slug = Str::slug($request->name);
        }

        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->save();

        flash()->success(__('messages.updated_successfully', [
            'resource' => ucfirst(__('products.singular'))
        ]));

        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        flash()->success(__('messages.deleted_successfully', [
            'resource' => __('products.singular')
        ]));

        return redirect()->route('admin.products.index');
    }
}
