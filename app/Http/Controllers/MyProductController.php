<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class MyProductController extends Controller
{
    private const MAX_PHOTOS = 5;

    public function index(Request $request): View
    {
        $products = $request->user()
            ->products()
            ->latest()
            ->paginate(10);

        return view('products.mine', compact('products'));
    }

    public function create(): View
    {
        return view('products.form', ['product' => new Product]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->productRules());
        $attributes = Arr::except($validated, 'images');
        $attributes['price'] = $attributes['offer_type'] === 'dijual' ? ($attributes['price'] ?? null) : null;
        $photos = $this->storePhotos($request, $validated['images'] ?? []);

        $attributes['images'] = $photos ?: null;
        $attributes['image_path'] = $photos[0] ?? null;
        $request->user()->products()->create($attributes);

        return redirect()->route('products.mine')->with('success', 'Penawaran barang berhasil ditambahkan.');
    }

    public function edit(Request $request, Product $product): View
    {
        $this->ensureOwner($request, $product);

        return view('products.form', compact('product'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->ensureOwner($request, $product);

        $validated = $request->validate($this->productRules($product));
        $removedPhotos = $validated['remove_images'] ?? [];
        $newUploads = $validated['images'] ?? [];
        $remainingPhotos = array_values(array_diff($product->photos, $removedPhotos));

        if (count($remainingPhotos) + count($newUploads) > self::MAX_PHOTOS) {
            throw ValidationException::withMessages([
                'images' => 'Maksimal '.self::MAX_PHOTOS.' foto dapat disimpan untuk satu barang.',
            ]);
        }

        $attributes = Arr::except($validated, ['images', 'remove_images']);
        $attributes['price'] = $attributes['offer_type'] === 'dijual' ? ($attributes['price'] ?? null) : null;
        $photos = array_merge($remainingPhotos, $this->storePhotos($request, $newUploads));
        $attributes['images'] = $photos ?: null;
        $attributes['image_path'] = $photos[0] ?? null;

        $product->update($attributes);

        if ($removedPhotos) {
            Storage::disk('public')->delete($removedPhotos);
        }

        return redirect()->route('products.mine')->with('success', 'Penawaran barang berhasil diperbarui.');
    }

    public function updateStatus(Request $request, Product $product): RedirectResponse
    {
        $this->ensureOwner($request, $product);

        $validated = $request->validate([
            'status' => ['required', Rule::in(['tersedia', 'dipesan', 'selesai'])],
        ]);

        $product->update(['status' => $validated['status']]);

        return back()->with('success', 'Status ketersediaan barang berhasil diubah.');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $this->ensureOwner($request, $product);
        $photos = $product->photos;
        $product->delete();

        if ($photos) {
            Storage::disk('public')->delete($photos);
        }

        return redirect()->route('products.mine')->with('success', 'Penawaran barang berhasil dihapus.');
    }

    private function ensureOwner(Request $request, Product $product): void
    {
        abort_unless($product->user_id === $request->user()->id, 403);
    }

    private function productRules(?Product $product = null): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'offer_type' => ['required', Rule::in(['dijual', 'donasi'])],
            'price' => ['nullable', 'required_if:offer_type,dijual', 'numeric', 'min:0'],
            'condition' => ['required', Rule::in(['Baru', 'Sangat baik', 'Baik', 'Layak pakai'])],
            'category' => ['required', 'string', 'max:100'],
            'campus_location' => ['nullable', 'string', 'max:150'],
            'images' => ['nullable', 'array', 'max:'.self::MAX_PHOTOS],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];

        if ($product) {
            $rules['remove_images'] = ['nullable', 'array', 'max:'.self::MAX_PHOTOS];
            $rules['remove_images.*'] = ['string', Rule::in($product->photos)];
        }

        return $rules;
    }

    private function storePhotos(Request $request, array $uploads): array
    {
        return array_map(
            fn ($photo) => $photo->store('products/'.$request->user()->id, 'public'),
            $uploads
        );
    }
}
