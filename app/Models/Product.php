<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'price',
        'description',
        'image_path',
        'in_stock',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'in_stock' => 'boolean',
        ];
    }

    public function whatsappLink(): string
    {
        $price = $this->price === null
            ? 'Bei haijawekwa kwenye tovuti.'
            : 'Bei iliyo kwenye tovuti: TZS '.number_format((float) $this->price);
        $message = "Habari Mahecha Furniture, ningependa kuagiza {$this->name} ({$this->category}). {$price}";

        if ($imageUrl = $this->imageUrl()) {
            $message .= " Picha ya bidhaa: {$imageUrl}.";
        }

        $message .= ' Naomba maelezo ya upatikanaji na usafirishaji.';

        return 'https://wa.me/'.config('services.mahecha.whatsapp_number').'?text='.urlencode($message);
    }

    public function imageUrl(): ?string
    {
        if (blank($this->image_path)) {
            return null;
        }

        return Str::startsWith($this->image_path, ['http://', 'https://'])
            ? $this->image_path
            : Storage::disk('public')->url($this->image_path);
    }
}
