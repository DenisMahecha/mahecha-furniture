<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'Kiti cha Sebule', 'category' => 'Viti', 'price' => 80000, 'description' => 'Kiti chenye starehe na ujenzi imara kwa sebule ya kisasa.'],
            ['name' => 'Meza ya Kulia', 'category' => 'Meza', 'price' => 150000, 'description' => 'Meza ya familia yenye muundo safi na mbao zinazodumu.'],
            ['name' => 'Kitanda cha Double', 'category' => 'Vitanda', 'price' => 250000, 'description' => 'Kitanda imara chenye umaliziaji mzuri kwa chumba chako.'],
            ['name' => 'Kabati la Nguo', 'category' => 'Makabati', 'price' => 200000, 'description' => 'Kabati lenye nafasi ya kutosha kwa mpangilio wa nyumba.'],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(['name' => $product['name']], $product);
        }
    }
}
