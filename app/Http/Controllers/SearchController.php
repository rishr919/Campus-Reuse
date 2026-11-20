<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
        ]);
        $term = trim($validated['q'] ?? '');

        $suggestions = $term === ''
            ? collect()
            : Product::query()
                ->where('name', 'like', $term.'%')
                ->select('name')
                ->distinct()
                ->orderBy('name')
                ->limit(6)
                ->pluck('name');

        $categories = Product::query()
            ->whereNotNull('category')
            ->select('category')
            ->selectRaw('count(*) as listings_count')
            ->distinct()
            ->groupBy('category')
            ->orderByDesc('listings_count')
            ->limit(6)
            ->pluck('category');

        return view('products.search', compact('term', 'suggestions', 'categories'));
    }
}
