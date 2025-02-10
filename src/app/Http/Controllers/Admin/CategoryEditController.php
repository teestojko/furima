<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryEditController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(4);
        return view('admin.category_index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:categories|max:255',
        ]);

        Category::create(['name' => $request->name]);

        return redirect()->route('admin.categories.index')->with('success', 'カテゴリーを追加しました');
    }

    public function edit(Category $category)
    {
        return view('admin.category_edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name,' . $category->id . '|max:255',
        ]);

        $category->update(['name' => $request->name]);

        return redirect()->route('admin.categories.index')->with('success', 'カテゴリーを更新しました');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'カテゴリーを削除しました');
    }
}


