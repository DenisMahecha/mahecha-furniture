<?php

use App\Models\CashCollection;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::view('/', 'welcome')->name('home');

Route::get('dashboard', function () {
    $products = Product::query()->latest()->get();
    $collections = CashCollection::query()->latest('received_at')->latest()->get();
    $totalProducts = $products->count();
    $availableProducts = $products->where('in_stock', true)->count();

    return view('dashboard', [
        'totalProducts' => $totalProducts,
        'availableProducts' => $availableProducts,
        'unavailableProducts' => $products->where('in_stock', false)->count(),
        'categoryCount' => $products->pluck('category')->unique()->count(),
        'stockRate' => $totalProducts > 0 ? (int) round(($availableProducts / $totalProducts) * 100) : 0,
        'missingPriceCount' => $products->whereNull('price')->count(),
        'categoryBreakdown' => $products->groupBy('category')->map->count()->sortDesc(),
        'recentProducts' => $products->take(5),
        'totalCollected' => $collections->sum('amount'),
        'todayCollected' => $collections->where('received_at', today())->sum('amount'),
        'recentCollections' => $collections->take(5),
    ]);
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::view('admin/products', 'admin.products')->name('admin.products');
    Route::view('admin/cash-collections', 'admin.cash-collections')->name('admin.cash-collections');

    Route::get('admin/reports/products', function () {
        $products = Product::query()->latest()->get();

        return view('admin.reports.products', [
            'products' => $products,
            'categoryBreakdown' => $products->groupBy('category')->map->count()->sortDesc(),
            'totalValue' => $products->whereNotNull('price')->sum('price'),
            'pricedProducts' => $products->whereNotNull('price')->count(),
            'missingImageCount' => $products->where(fn (Product $product): bool => blank($product->image_path))->count(),
        ]);
    })->name('admin.reports.products');

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
});

require __DIR__.'/auth.php';
