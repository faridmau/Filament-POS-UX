<?php

namespace App\Filament\AdminPanel\Pages; // TODO : change to your own namespace

use Filament\Pages\Page;

class PosScreen extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.admin-panel.pages.pos-screen';
    public string $currency = 'Rp.';
    public array $products = [];
    public array $categories = [
        ['id' => 1, 'name' => 'Food'],
        ['id' => 2, 'name' => 'Cold Drinks'],
        ['id' => 3, 'name' => 'Hot Drinks'],
        ['id' => 4, 'name' => 'Snacks'],
    ];

    public function mount()
    {
        $this->products = cache()->remember('products', 60, function () {
            return $this->getProducts();
        });
    }

    protected function getProducts(): array
    {
        $products = [
            // Food
            ['id' => 1, 'name' => 'Burger', 'price' => 5.99, 'thumbnail' => 'https://placehold.co/100x100', 'category_id' => 1],
            ['id' => 2, 'name' => 'Pizza', 'price' => 8.99, 'thumbnail' => 'https://placehold.co/100x100', 'category_id' => 1],
            ['id' => 3, 'name' => 'Hot Dog', 'price' => 3.99, 'thumbnail' => 'https://placehold.co/100x100', 'category_id' => 1],
            ['id' => 4, 'name' => 'Pasta', 'price' => 7.49, 'thumbnail' => 'https://placehold.co/100x100', 'category_id' => 1],
            ['id' => 5, 'name' => 'Salad', 'price' => 4.99, 'thumbnail' => 'https://placehold.co/100x100', 'category_id' => 1],

            // Cold Drinks
            ['id' => 6, 'name' => 'Coca Cola', 'price' => 1.49, 'thumbnail' => 'https://placehold.co/100x100', 'category_id' => 2],
            ['id' => 7, 'name' => 'Pepsi', 'price' => 1.49, 'thumbnail' => 'https://placehold.co/100x100', 'category_id' => 2],
            ['id' => 8, 'name' => 'Sprite', 'price' => 1.49, 'thumbnail' => 'https://placehold.co/100x100', 'category_id' => 2],
            ['id' => 9, 'name' => 'Fanta', 'price' => 1.49, 'thumbnail' => 'https://placehold.co/100x100', 'category_id' => 2],
            ['id' => 10, 'name' => 'Iced Tea', 'price' => 2.49, 'thumbnail' => 'https://placehold.co/100x100', 'category_id' => 2],

            // Hot Drinks
            ['id' => 11, 'name' => 'Coffee', 'price' => 2.99, 'thumbnail' => 'https://placehold.co/100x100', 'category_id' => 3],
            ['id' => 12, 'name' => 'Tea', 'price' => 1.99, 'thumbnail' => 'https://placehold.co/100x100', 'category_id' => 3],
            ['id' => 13, 'name' => 'Hot Chocolate', 'price' => 3.49, 'thumbnail' => 'https://placehold.co/100x100', 'category_id' => 3],
            ['id' => 14, 'name' => 'Latte', 'price' => 3.99, 'thumbnail' => 'https://placehold.co/100x100', 'category_id' => 3],
            ['id' => 15, 'name' => 'Espresso', 'price' => 2.49, 'thumbnail' => 'https://placehold.co/100x100', 'category_id' => 3],

            // Snacks
            ['id' => 16, 'name' => 'Chips', 'price' => 1.99, 'thumbnail' => 'https://placehold.co/100x100', 'category_id' => 4],
            ['id' => 17, 'name' => 'Cookies', 'price' => 2.49, 'thumbnail' => 'https://placehold.co/100x100', 'category_id' => 4],
            ['id' => 18, 'name' => 'Popcorn', 'price' => 1.99, 'thumbnail' => 'https://placehold.co/100x100', 'category_id' => 4],
            ['id' => 19, 'name' => 'Pretzels', 'price' => 2.99, 'thumbnail' => 'https://placehold.co/100x100', 'category_id' => 4],
            ['id' => 20, 'name' => 'Nuts', 'price' => 3.49, 'thumbnail' => 'https://placehold.co/100x100', 'category_id' => 4],
        ];
        return $products;
    }
}
