<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Product;
use Livewire\WithPagination;
use App\Models\Brand;
use App\Models\Category;
use Livewire\Attributes\URL;



#[Title('Products - Ecommerce')]

class ProductsPage extends Component
{
    use WithPagination;

    #[URL]
    public $selected_categories = [];

    #[URL]
    public $selected_brands = [];

    #[URL]
    public $featured;

    #[URL]
    public $on_sale;

    #[URL]
    public $price_range = 5000;

    public function render()
    {
        $productQuery = Product::query()->where('is_active', 1);

         if(!empty($this->selected_categories)) {
            $productQuery->whereIn('category_id', $this->selected_categories);
        }

        if(!empty($this->selected_brands)) {
            $productQuery->whereIn('brand_id', $this->selected_brands);
        }

        if($this->featured) {
            $productQuery->where('is_featured', 1);
        }

        if($this->on_sale) {
            $productQuery->where('on_sale', 1);
        }

        if($this->price_range) {
            $productQuery->whereBetween('price', [0, $this->price_range]);
        }

        
        return view('livewire.products-page', [
            'products' => $productQuery->paginate(9),
            'brands' => Brand::where('is_active', 1)->get(['id', 'name', 'slug']),
            'categories' => Category::where('is_active', 1)->get(['id', 'name', 'slug']),
        ]);
    }
}
