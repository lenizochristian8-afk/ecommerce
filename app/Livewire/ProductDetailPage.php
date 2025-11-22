<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Product;
use App\Helpers\CartManagement;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use App\Livewire\Partials\Navbar;

#[Title('Product Detail - Ecommerce')]
class ProductDetailPage extends Component
{

    public $slug;
    public $quantity = 1;
 
    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function increaseQty(){
        $this->quantity++;
    }

    public function decreaseQty(){
        if($this->quantity > 1){
        $this->quantity--;
        }
    }

    // add product to cart method 
    public function addToCart($product_id){
        $total_count = CartManagement::addItemToCart($product_id);

        $this->dispatch('update_cart_count', $total_count)->to(Navbar::class);

         LivewireAlert::title('Product added to cart successfully!')
        ->success()
        ->position('bottom-end')
        ->toast()
        ->timer(3000)
        ->show();
    }

    public function render()
    {
        return view('livewire.product-detail-page',[
            'product' => Product::where('slug', $this->slug)->firstOrFail(),
        ]);
    }
}
