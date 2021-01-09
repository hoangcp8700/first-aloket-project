<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use App\Banner;
use App\Coupon;
use App\Product;
use App\Category;
use App\Wishlist;
use App\Wistlist;
use Carbon\Carbon;
use App\OrderDetail;
use App\ProductAttr;
use App\Mail\OrderSend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function index()
    {
        $categories = Category::where('status',1)->orderBy('name','asc')->get();
        $products = Product::where('status',1)->whereNotNull('image')->orderBy('created_at','desc')->take(8)->get();
        $day = Carbon::now()->day; //ngày
        $month = Carbon::now()->month; //tháng
        $cartSession = Cart::orderby('created_at','desc')->whereNull('user_id')->where('created_at','<',Carbon::now()->subMinutes(10))->get();
        foreach($cartSession as $delete){
            $delete->delete();
        }
        return view('pages.index')

        ->with('day',$day)
        ->with('month',$month)
        ->with('products',$products)
        ->with('categories',$categories);
    }

    public function wishlist()
    {
        $categories = Category::where('status',1)->orderBy('name','desc')->get();
        $wishlists = Wishlist::with(['product' => function($query){
            $query->select('id','name','product_code','image','price','discount');
        }])->where('user_id',Auth::user()->id)->get()->toArray();

        return view('pages.wishlist')
        ->with('wishlists',$wishlists)
        ->with('categories',$categories);
    }

    public function addWishlist(Request $req,$product,$user)
    {

        $wishlist = Wishlist::where('user_id',$user)->where('product_id',$product)->get();
        if(count($wishlist) == 0 ){
            Wishlist::create([
                'product_id' => $product,
                'user_id' => $user,
            ]);
            return response()->json([
                'status' => 'Sản phẩm yêu thích thành công',
                'statuscode' => 'success',
                'active' => 1
            ]);
        }else{
            $wishlist[0]->delete();
            return response()->json([
                'status' => 'Đã hủy sản phẩm yêu thích',
                'statuscode' => 'success',
                'active' => 0
            ]);
        }
    }


    public function contact()
    {
        $categories = Category::where('status',1)->orderBy('name','desc')->get();

        return view('pages.contact')->with('categories',$categories);
    }

    public function menu_list()
    {
        $categories = Category::where('status',1)->inRandomOrder()->first()->toArray();
        return redirect()->route('page.menu_listen',$categories['slug']);
    }

    public static function menu_listen(Request $req, $url)
    {
        if(request()->ajax()){
            $data= $req->all();
            $category = Category::with('section')->where('slug',$url)->where('status',1)->count();
            if($category > 0){
                $categoryDetails =  Category::with(['section' => function($query){
                    $query->where('status',1);
                }])->where('slug',$url)->where('status',1)->get();
                $products = Product::with(['productAttr' => function($query){
                    $query->whereNotNull('size');
                }])->where('status',1)->where('category_id',$categoryDetails[0]->id);

                if(!empty($data['valueSort'])){
                    if($data['valueSort'] == 'name_a_z'){
                        $products->orderBy('name','asc');
                    }elseif($data['valueSort'] == 'name_a_z'){
                        $products->orderBy('name','desc');
                    }elseif($data['valueSort'] == 'name_new'){
                        $products->orderBy('created_at','desc');
                    }elseif($data['valueSort'] == 'name_old'){
                        $products->orderBy('created_at','asc');
                    }elseif($data['valueSort'] == 'tien_tang'){
                        $products->orderBy('price','asc');
                    }elseif($data['valueSort'] == 'tien_giam'){
                        $products->orderBy('price','desc');
                    }else{
                        $products->orderBy('id','desc');
                    }
                }
                $products = $products->paginate(6);

                return view('layouts.ajax_product',compact('products','categoryDetails'));
            }
        }else{
            $category = Category::with('section')->where('slug',$url)->where('status',1)->count();
            if($category > 0){
                $categoryDetails =  Category::with(['section' => function($query){
                    $query->where('status',1);
                }])->where('slug',$url)->where('status',1)->get();
                $products = Product::where('status',1)->where('category_id',$categoryDetails[0]->id);
                if(!empty($_GET['sort'])){
                    if($_GET['sort'] == 'name_a_z'){
                        $products->orderBy('name','asc');
                    }elseif($_GET['sort'] == 'name_a_z'){
                        $products->orderBy('name','desc');
                    }elseif($_GET['sort'] == 'name_new'){
                        $products->orderBy('created_at','desc');
                    }elseif($_GET['sort'] == 'name_old'){
                        $products->orderBy('created_at','asc');
                    }elseif($_GET['sort'] == 'tien_tang'){
                        $products->orderBy('price','asc');
                    }elseif($_GET['sort'] == 'tien_giam'){
                        $products->orderBy('price','desc');
                    }else{
                        $products->orderBy('id','desc');
                    }
                }
                $products = $products->paginate(6);

                return view('pages.menu_list',compact('products','categoryDetails'));
            }else{
                abort(404);

        }
    }
    }

    public function productDetail(Request $req, $code)
    {

        $categories = Category::where('status',1)->orderBy('name','desc')->get();
        $product = Product::with('category','section','productImage','productAttr')->where('product_code',$code)->first()->toArray();
            // dd($product);
        if(!$product)
        {
            return back();
        }
        $lqs= Product::where('category_id',$product['category_id'])->get();
        $banner = Banner::where('url','product-detail')->first();


        return view('pages.product_detail')
        ->with('lqs',$lqs)
        ->with('banner',$banner)
        ->with('product',$product)
        ->with('categories',$categories);
    }

    public function loadPrice(Request $req){
        if(request()->ajax()){
            $data = $req->all();
            $productAttr  = ProductAttr::where(['product_id' => $data['id'], 'size' => $data['size']])->get();
            echo $productAttr[0]->price;
        }
    }

    public function addToCart(Request $req)
    {
        $rules = [
            'size' => 'required',
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'Vui lòng chọn size!!',
                'statuscode' => 'error'
            ]);
        }else{
            $getProductStock = ProductAttr::where([
                'product_id' => $req->product_id,
                'size' => $req->size,
            ])->first()->toArray();
            // echo '<pre>'; print_r($getProductStock['stock']);die;
            if($getProductStock['stock'] < $req->quantity){
                return response()->json([
                    'status' => 'Xin lỗi quý khách vì số lượng hàng hiện tại không đủ đáp ứng!',
                    'statuscode' => 'error'
                ]);
            }

            /// check session if not exists
            $session_id = Session::get('session_id');
            if(empty($session_id)){
                $session_id = Session::getId();
                Session::put('session_id',$session_id);
            }
            //// check user if not exist
            if(Auth::check()){
                $countProduct = Cart::where([
                    'product_id' => $req->product_id,
                    'size' => $req->size,
                    'session_id' => Session::get('session_id'),
                    'user_id' => Auth::user()->id])->count();
                $auth = Auth::user()->id;
            }else{
                $countProduct = Cart::where([
                    'product_id' => $req->product_id,
                    'size' => $req->size,
                    'session_id' => Session::get('session_id')])->count();
                $auth = null;
            }
            if($countProduct > 0){
                return response()->json([
                    'status' => 'Sản phẩm đã có trong giỏ hàng!',
                    'statuscode' => 'error'
                ]);
            }
            $cart = new Cart;
            $cart->session_id = $session_id;
            $cart->product_id = $req->product_id;
            $cart->user_id = $auth;
            $cart->price = $req->price;
            $cart->size = $req->size;
            $cart->quantity = $req->quantity;
            $cart->save();

            $carts = Cart::cartItems();

            return response()->json([
                'status' => 'Sản phẩm đã có trong giỏ hàng!!',
                'statuscode' => 'success',
                'cart' => $carts
            ]);
        }
    }

    public function cart()
    {
        $cartItems = Cart::cartItems();

        $categories = Category::where('status',1)->orderBy('name','desc')->get();
        return view('pages.cart')
        ->with('cartItems',$cartItems)
        ->with('categories',$categories);
    }

    public function updateCart(Request $req)
    {
        if(request()->ajax()){
            $data = $req->all();
            $cartUpdate = Cart::find($data['cartID']);

            $availableStock = ProductAttr::select('stock')->where([
                'product_id' => $cartUpdate['product_id'],
                'size' => $cartUpdate['size'],
            ])->first()->toArray();
            if($data['quantity'] > $availableStock['stock']){
                $cartItems = Cart::cartItems();
                return response()->json([
                    'statuscode' => 'error',
                    'status' => 'Hiện tại cửa hàng không đủ sản phẩm để cung cấp!',
                    'view' => (String)View::make('layouts.ajax_cart')->with(compact('cartItems'))
                ]);
            }
            // echo 'quantity ' .$data['quantity'];
            // echo '<Br>';
            // echo 'available '.$availableStock['stock'];die;

            $cartUpdate->update(['quantity' => $data['quantity']]);
            $cartItems = Cart::cartItems();
            return response()->json(['view' => (String)View::make('layouts.ajax_cart')->with(compact('cartItems'))]);
        }
    }

    public function deleteCart(Request $req)
    {

        $cartUpdate = Cart::find($req->cartID)->delete();
        $cartItems = Cart::cartItems();
        if($req->loadCart == true){
            if($req->cartPage == false){
                return response()->json([
                    'status' => 'Xóa sản phẩm khỏi giỏ hàng thành công',
                    'statuscode' => 'success',
                    'cart' => $cartItems
                ]);
            }else{
                return response()->json([
                    'status' => 'Xóa sản phẩm khỏi giỏ hàng thành công',
                    'statuscode' => 'success',
                    'cart' => $cartItems,
                    'view' => (String)View::make('layouts.ajax_cart')->with(compact('cartItems'))
                ]);
            }
        }
        return response()->json(['view' => (String)View::make('layouts.ajax_cart')->with(compact('cartItems'))]);
    }

    public function checkout()
    {

        if(!Session::get('session_id') && !Auth::check()){

            return back();
        }else{
            $categories = Category::where('status',1)->orderBy('name','desc')->get();
            $provinces = DB::table('provinces')->orderBy('name','asc')->get();
            $cartItems = Cart::cartItems();
            // echo '<pre>';print_r($cartItems);die;
            return view('pages.checkout')
                    ->with('cartItems',$cartItems)
                    ->with('provinces',$provinces)
                    ->with('categories',$categories);
        }

    }

    public function storeCheckout(Request $req)
    {
        $rules = [
            'name' => 'required',
            'phone'=> 'required',
            'email'=> 'required | email',
            'address' => 'required',
            'province_id' => 'required',
            'district_id' => 'required',
            'ward_id' => 'required',
            'description' => 'max:255',
        ];

        $messages = [
            'name.required' => 'Yêu cầu nhập tên !!',
            'phone.required' => 'Yêu cầu nhập số điện thoại!!',
            'email.required' => 'Yêu cầu nhập email!!',
            'email.email' => 'Email không hợp lệ',
            'address.required' => 'Yêu cầu nhập địa chỉ!!',
            'province_id.required' => 'Yêu cầu chọn thành phố / tỉnh!!',
            'district_id.required' => 'Yêu cầu nhập quận / huyện!!',
            'ward_id.required' => 'Yêu cầu nhập tên phường / xã!!',
            'description.max' => 'Tối đa :max ký tự!!',
            'max' => 'Tối đa :max kí tự!!!',
        ];
        $validator = Validator::make($req->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'statuscode' => 'error',
                'status' => $validator->messages()->all()[0]
            ]);

        }
        if(Session::get('session_id') || Auth::user()){
            // dd(Session::get('session_id'));
            $data = $req->except(['_token','code']);


            ///// random code
            $data['order_code'] =  mt_rand(1000000, 9999999);

            $date = [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            /// kt có nhập
            if(empty($data['discount'])){
                $data['discount'] = $data['total'];
            }

            // kt order_code có trùng lặp
            $checkOrderCode = Order::where('order_code',$data['order_code'])->first();
            if(count((array)$checkOrderCode) > 0){
                $data['order_code'] = $data['order_code'] + rand(1,10);
            }


            $order = Order::insert(array_merge(
                $data,$date
            ));


             ///// trừ quantity coupon
             if($req->code){
                $decreament = Coupon::where('code',$req->code)->get();
                $quantity = $decreament[0]->quantity;
                if($decreament[0]){
                    $decreament[0]->update(array_merge(
                       ['quantity' => $quantity -1],
                       ['updated_at' => Carbon::now()],
                    ));
                }
             }
             /// get data order
             $orders =  Order::with('district','province','ward','orderDetail')->where('order_code',$data['order_code'])->first()->toArray();

             /// khi tạo xong order thì sẽ tạo orderDetail
            $cartItems = Cart::cartItems();
            foreach($cartItems as $cart){
                 //trừ quantity product
                $decreamentProduct = ProductAttr::where('product_id',$cart['product_id'])
                                ->where('size',$cart['size'])->get();
                $quantity = $decreamentProduct[0]['stock'];
                $decreamentProduct[0]->update([
                        'stock' => $quantity - $cart['quantity'],
                        'updated_at' => Carbon::now(),
                    ]);

                $getPrice = Cart::getPriceAttr($cart['product_id'],$cart['size']);
                $od  = new OrderDetail;
                $od->order_id = $orders['id'];
                $od->product_id = $cart['product_id'];
                $od->size = $cart['size'];
                $od->quantity = $cart['quantity'];
                $od->price = $getPrice;
                $od->save();

            }

            // GỬI MAIL
            $orderDetail = OrderDetail::with(['product' => function($query){
                $query->select('id','name','color');
            },'order' => function($query){
                $query->with(['district','ward','province']);
            }])->where('order_id',$orders['id'])->get()->toArray();


            \Mail::send(new OrderSend($orderDetail));

            // xoa cart trong db
            $cartDelete = Cart::where('session_id',Session::get('session_id'))->get();
            foreach($cartDelete as $delete){
                $delete->delete();
            }

            $req->session()->forget('session_id');
            return response()->json([
                'statuscode' => 'success',
                'status' => 'Xác nhận đơn hàng thành công ! Mã đơn hàng của bạn là: '.$data['order_code']
            ]);
        }else{
            return  back()->with('statucode','error')->with('status','Đã xảy ra lỗi! Vui lòng đăng nhập để thanh toán');
        }
    }

    public function applyCoupon(Request $req)
    {
        // dd($req->all());
        $data= $req->all();
        $checkCoupon = Coupon::where('code',$data['code'])->where('status',1)->get();
        if(count($checkCoupon) >0){
            if($checkCoupon[0]['outdate'] < Carbon::now()->toDateTimeString()){
                return response()->json(['error' => 'Coupon đã hết hạn dùng']);
            }
            if($checkCoupon[0]['quantity'] < 1){
                return response()->json(['error' => 'Không đủ số lượng coupon']);
            }


            return response()->json($checkCoupon);
        }else{
            return response()->json(['error' => 'Coupon không tìm thấy ']);
        }

    }

    public function search(Request $req){
        if(request()->ajax()){

            $search = $req->search;
            if($search){
                $products = Product::where(function($query) use ($search){
                    $query->where('name','LIKE',"%{$search}%")
                            ->orWhere('keyword','LIKE',"%{$search}%")
                            ->orWhere('price','LIKE',"%{$search}%");
                })->where('status',1)->where('category_id',$req->category_id)->paginate(6);
            }else{
                $products = Product::where('category_id',$req->category_id)->paginate(6);
            }
        }
        return view('layouts.ajax_product',compact('products'));
    }

    public function searchOrderCode(Request $req){
        if(request()->ajax()){
            $search= $req->search;
            if($search){
                $order = Order::where('order_code','=',"$search")->get();
                if(count($order)>0){
                    $order = $order->toArray();
                    return response()->json([
                        'data' => $order
                    ]);
                }else{
                    return response()->json([
                        'status' => 'Không tìm thấy!',
                        'statuscode' => 'error'
                    ]);
                }

            }else{
                return response()->json([
                    'status' => 'Vui lòng nhập thông tin cần tra cứu!',
                    'statuscode' => 'error'
                ]);
            }
        }
    }

    public function searchOrder(Request $req){
        if(request()->ajax()){
            $order = Order::with(['province','district','ward','orderDetail' => function($query){
                $query->with(['product' => function($query1){
                    $query1->select('id','name');
                }]);
            }])->find($req->order_id);

            if($order){
                $order = $order->toArray();
                    return response()->json($order);
            }
            return response()->json([
                'statuscode' => 'error',
                'status' => 'Đơn hàng của bạn đang trong quá trình xử lý!! Vui lòng chờ đợi'
            ]);

        }
    }
}
