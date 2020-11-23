<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use App\Models\ProductType;
use App\Models\Cart;
use Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
          view()->composer(['header', 'page.dat_hang'],   function($view){
                $loai_sp = ProductType::all();
               
                
                $view->with('loai_sp', $loai_sp);
          });

                
          view()->composer(['header', 'page.dat_hang'], function($view){
                if(Session('cart')){
                    $oldCart = Session::get('cart');
                    $cart = new Cart($oldCart);
                    $view->with(['cart'=>Session::get('cart'), 'product_cart'=>$cart->items, 'totalPrice'=>$cart->totalPrice, 'totalQty'=>$cart->totalQty ]);
                }
          });
          
                //đối với giỏ hàng thì dùng session, cho nên kiểm tra nếu có session là cart
                // tạo biến oldCart để kiểm tra trong giỏ hàng hiện tại có SP nào được mua hay chưa
                //  và sẽ lấy session của cart hiện tại để gán vào giỏ hàng cũ oldCart ,
                // nếu mua SP mới thì SP đó được thêm vào giỏ hàng
                //tạo một biến cart mới, truyền biến oldCart vào

        
    }
}
