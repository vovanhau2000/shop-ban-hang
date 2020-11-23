<?php

namespace App\Http\Controllers;
use App\Models\Slide;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Cart;
use Session;
use App\Models\Customer;
use App\Models\Bill;
use App\Models\BillDetail;

use Illuminate\Http\Request;



class PageController extends Controller
{
    public function getIndex(){
        $slide = Slide::all();
        $new_product = Product::where('new',1)->paginate(4);
        $sanpham_khuyenmai = Product::where('promotion_price','<>', 0)->paginate(8);
        return view('page.trangchu', compact('slide','new_product','sanpham_khuyenmai'));
    }

    public function getLoaiSp($type){
        $sp_theoloai = Product::where('id_type', $type)->get();
        $sp_khac = Product::where('id_type','<>',$type)->paginate(3);
        $loai = ProductType::all();
        $loai_sp = ProductType::where('id',$type)->first();
        return view('page.loai_sanpham', compact('sp_theoloai','sp_khac', 'loai','loai_sp'));
    }

    public function getChitiet(Request $req){
        //lấy sản phẩm theo id nên tạp biến sanpham, mỗi sản phẩm chỉ có 1 id nên trỏ đén phương thức first 
        $sanpham = Product::where('id',$req->id)->first(); //truyền biến sanpham qua view
        $sp_tuongtu = Product::where('id_type', $sanpham->id_type)->paginate(6);
        return view('page.chitiet_sanpham', compact('sanpham', 'sp_tuongtu'));
    }

    public function getLienHe(){
        return view('page.lienhe');
    }

    public function getGioiThieu(){
        return view('page.gioithieu');
    }

    public function getAddtoCart(Request $req,$id){

       $product = Product::find($id); //tạo để kiểm tra xem có SP đó hay không, SP tương ứng với id
       $oldCart = Session('cart')?Session::get('cart'):null; //tạo dể kiểm tra xem hiện tại trong session mình có sesion cart hay chưa, nếu chưa thì null, nếu có thì lấy seeion cart đó để gán cho biến oldCart  
       $cart = new Cart($oldCart); 
       $cart->add($product, $id); //để thêm một phần tử vào giỏ hàng, mình dùng phương thức add
       $req->session()->put('cart',$cart);
       return redirect()->back();//sau khi thêm vào thành công thì trở về trang chủ

    }

    public function getDelItemCart($id){
        $oldCart = Session::has('cart')?Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if(count($cart->items)>0){
            Session::put('cart',$cart);
        }
        else{
            Session::forget('cart');
        }

        
        return redirect()->back();
    }

    //truyền vào cái id sản phẩm mà mình muốn xoá
    // tạo biến oldCart để kiểm tra xem trong giỏ hàng hiện tại có giỏ hàng hay không, nếu có thì dùng session get giỏ hàng đó về, nếu không có thì null
    // tạo biến cart, truyền vào biến oldCart 
    //tạo biến cart để trỏ đến phương thức xoá
    //tạo session để put lại giỏ hàng lại thành giở hàng mới
    // return để quay về trang chủ


    public function getCheckout(){
        return view('page.dat_hang');
    }

    public function postCheckout(Request $req){
        $cart = Session::get('cart');
        
        


        $customer = new Customer;
        $customer->name = $req->name;  //$req->name, gender,email là những giá trị của thuộc tính có tên là "name" trong form của trang dat_hang
        $customer->gender = $req->gender;
        $customer->email = $req->email;
        $customer->address = $req->address;
        $customer->phone_number = $req->phone;
        $customer->note = $req->notes; 
        $customer->save();

        $bill = new Bill;
        $bill->id_customer = $customer->id;
        $bill->date_order  = date('Y-m-d');
        $bill->total = $cart->totalPrice;
        $bill->payment = $req->payment_method;
        $bill->delivery = $req->delivery_method;
        $bill->note = $req->notes;
        $bill->save();

        foreach ($cart->items as $key => $value){
            $bill_detail = new BillDetail;
            $bill_detail->id_bill = $bill->id;
            $bill_detail->id_product = $key;
            $bill_detail->quantity = $value['qty'];
            $bill_detail->final_price = ($value['final_price']/$value['qty']);
            $bill_detail->save();

          

        }
        Session::forget('cart');
        return redirect()->back()->with('thongbao', 'Đặt hàng thành công');
        
  



    }


    public function getSearch(Request $req){
        $product = Product::where('name', 'like', '%'.$req->key.'%')
                            ->orWhere('unit_price',$req->key)
                            ->get();
        return view('page.search',compact('product'));                    
      }


}
