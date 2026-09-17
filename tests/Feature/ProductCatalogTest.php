<?php

use App\Livewire\Admin\CashCollectionManager;
use App\Livewire\Admin\ProductManager;
use App\Livewire\ProductCatalog;
use App\Models\CashCollection;
use App\Models\Product;
use App\Models\User;
use Livewire\Livewire;

test('example', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('the homepage shows only products that are in stock', function () {
    Product::factory()->create([
        'name' => 'Kiti cha Kupumzika',
        'category' => 'Viti',
        'in_stock' => true,
    ]);
    Product::factory()->create([
        'name' => 'Bidhaa Iliyofichwa',
        'category' => 'Meza',
        'in_stock' => false,
    ]);

    $this->get('/')
        ->assertOk()
        ->assertSee('Kiti cha Kupumzika')
        ->assertDontSee('Bidhaa Iliyofichwa');
});

test('customers can search and filter available products', function () {
    $chair = Product::factory()->create([
        'name' => 'Kiti cha Mapumziko',
        'category' => 'Viti',
        'in_stock' => true,
    ]);
    Product::factory()->create([
        'name' => 'Meza ya Familia',
        'category' => 'Meza',
        'in_stock' => true,
    ]);

    Livewire::test(ProductCatalog::class)
        ->set('search', 'Mapumziko')
        ->assertSee($chair->name)
        ->assertDontSee('Meza ya Familia')
        ->set('search', '')
        ->set('category', 'Meza')
        ->assertSee('Meza ya Familia')
        ->assertDontSee($chair->name);
});

test('product whatsapp links use the product name and category', function () {
    $product = Product::factory()->create([
        'name' => 'Meza ya Familia',
        'category' => 'Meza',
    ]);

    expect($product->whatsappLink())
        ->toContain('255696410268')
        ->toContain('Meza+ya+Familia')
        ->toContain('Meza');
});

test('product whatsapp links create an order message with price and image', function () {
    $product = Product::factory()->create([
        'name' => 'Meza ya Kusomea',
        'category' => 'Meza',
        'price' => 250000,
        'image_path' => 'https://example.com/meza-ya-kusomea.jpg',
    ]);

    $message = urldecode(parse_url($product->whatsappLink(), PHP_URL_QUERY));

    expect($message)
        ->toContain('ningependa kuagiza Meza ya Kusomea (Meza)')
        ->toContain('TZS 250,000')
        ->toContain('https://example.com/meza-ya-kusomea.jpg')
        ->toContain('maelezo ya upatikanaji na usafirishaji');
});

test('guests cannot access the product manager', function () {
    $this->get('/admin/products')->assertRedirect('/login');
});

test('guests cannot access product reports', function () {
    $this->get('/admin/reports/products')->assertRedirect('/login');
});

test('guests cannot access cash collections', function () {
    $this->get('/admin/cash-collections')->assertRedirect('/login');
});

test('authenticated users can access the product manager', function () {
    $this->actingAs(User::factory()->create())
        ->get('/admin/products')
        ->assertOk()
        ->assertSee('Usimamizi wa bidhaa')
        ->assertSee('Overview')
        ->assertSee('Products');
});

test('authenticated users can view the product report', function () {
    Product::factory()->create([
        'name' => 'Meza ya Report',
        'category' => 'Meza',
        'price' => 250000,
        'in_stock' => true,
    ]);

    $this->actingAs(User::factory()->create())
        ->get('/admin/reports/products')
        ->assertOk()
        ->assertSee('Ripoti ya bidhaa')
        ->assertSee('Meza ya Report')
        ->assertSee('Thamani ya bei')
        ->assertSee('Reports');
});

test('authenticated managers can record cash on delivery collections', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(CashCollectionManager::class)
        ->set('customer_name', 'Amina Juma')
        ->set('amount', '250000')
        ->set('received_at', '2026-09-17')
        ->set('notes', 'Malipo yamepokelewa wakati wa delivery.')
        ->call('save')
        ->assertHasNoErrors()
        ->assertSee('Malipo ya COD yamehifadhiwa.');

    expect(CashCollection::query()->where('customer_name', 'Amina Juma')->first())
        ->amount->toBe('250000.00');
});

test('an authenticated manager can create a product', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(ProductManager::class)
        ->set('name', 'Kabati la Vitabu')
        ->set('category', 'Makabati')
        ->set('price', '175000')
        ->set('description', 'Kabati la vitabu lenye nafasi na ujenzi imara.')
        ->call('save')
        ->assertHasNoErrors()
        ->assertSee('Bidhaa imehifadhiwa kikamilifu.');

    expect(Product::where('name', 'Kabati la Vitabu')->exists())->toBeTrue();
});

test('the product manager can search and filter products', function () {
    $visibleProduct = Product::factory()->create([
        'name' => 'Meza ya Mikutano',
        'in_stock' => true,
    ]);
    Product::factory()->create([
        'name' => 'Kiti cha Mapumziko',
        'in_stock' => false,
    ]);

    Livewire::test(ProductManager::class)
        ->set('search', 'Mikutano')
        ->assertSee($visibleProduct->name)
        ->assertDontSee('Kiti cha Mapumziko')
        ->set('search', '')
        ->set('stockFilter', 'out_of_stock')
        ->assertSee('Kiti cha Mapumziko')
        ->assertDontSee($visibleProduct->name);
});

test('deleting a product requires confirmation', function () {
    $product = Product::factory()->create();

    Livewire::test(ProductManager::class)
        ->call('delete', $product->id)
        ->assertSet('confirmingDeleteId', $product->id);

    expect(Product::find($product->id))->not->toBeNull();

    Livewire::test(ProductManager::class)
        ->call('confirmDelete', $product->id)
        ->call('deleteConfirmed')
        ->assertSet('confirmingDeleteId', null);

    expect(Product::find($product->id))->toBeNull();
});
