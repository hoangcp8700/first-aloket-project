<?php

use Nexmo\Laravel\Facade\Nexmo;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PageController@index')->name('page.index');
Route::get('/thanh-toan','PageController@checkout')->name('page.checkout');
Route::get('/gio-hang','PageController@cart')->name('page.cart');

Route::get('/blog','PageController@blog')->name('page.blog');
Route::get('/lien-he','PageController@contact')->name('page.contact');
Route::get('/danh-muc','PageController@menu_list')->name('page.menu_list');
route::get('/danh-muc/{url}','PageController@menu_listen')->name('page.menu_listen');
route::post('/search','PageController@search');

// tra cuu don hang
route::post('/search-order-code','PageController@searchOrderCode');
route::post('/search-order','PageController@searchOrder');

//chi tiet don hang và load price
Route::get('/product-detail/{code}','PageController@productDetail')->name('page.productDetail');
Route::post('/product-detail/loadPrice','PageController@loadPrice');

// cart
route::post('/add-to-cart','PageController@addToCart')->name('page.addToCart');
route::post('/update-cart','PageController@updateCart');
route::post('/delete-cart','PageController@deleteCart');

route::post('/apply-coupon','PageController@applyCoupon');

route::post('/thanh-toan','PageController@storeCheckout')->name('page.checkout_store');
// vnzone
route::get('/district/{id}','VNZoneController@district');
route::get('/ward/{id}','VNZoneController@ward');





Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

/*---------------- socialite -----------*/

Route::get('/login/{provider}', 'SocialiteController@show')->name('provider.redirect');
Route::get('/oauth/{driver}', 'SocialiteController@redirectToProvider')->name('social.oauth');
Route::get('/oauth/{driver}/callback', 'SocialiteController@handleProviderCallback')->name('social.callback');


route::group(['middleware' => ['auth']], function(){
    route::get('/profile','ProfileController@index')->name('page.profile.index');
    route::post('/profile/upload','ProfileController@uploadProfile');
    route::post('/profile/store','ProfileController@store');
    route::post('/profile/password','ProfileController@password');
    route::get('/profile/order','ProfileController@show');

    // wishlist
    Route::get('/yeu-thich','PageController@wishlist')->name('page.wishlist');
    route::get('/add-wistlist/{product}/{auth}','PageController@addWishlist');
    route::post('/add-wistlist/{product}/{auth}','PageController@deleteWishlist');
});


/*------------ admin -------------*/
route::prefix('/admin')->namespace('Admin')->group(function(){

     //contact
    route::resource('/contact','ContactController')->except('create','update','edit');
    Route::post('/contact/reply','ContactController@reply')->name('contact.reply');

    route::get('/','AdminController@formlogin')->name('admin.login');
    route::post('/register','AdminController@register')->name('admin.register');
    route::post('/','AdminController@login')->name('admin.postLogin');
    route::post('/logout','AdminController@logout')->name('admin.logout');


    route::group(['middleware' => ['admin']],function(){
        route::get('/dashboard','AdminController@dashboard')->name('dashboard.index');

        ////danh muc
        route::resource('/category','CategoryController')->except('create','update','show');
        route::get('/category/{category}/status','CategoryController@updateStatus');

        //san pham
        route::resource('/product','ProductController')->except('create','update');
        route::get('/product/{product}/status','ProductController@updateStatus');
        route::delete('/product/{product}/delete','ProductController@deleteImage');

        route::resource('/attr_product','ProductAttrController')->except('create','update');
        route::get('/attr_product/{attr_product}/status','ProductAttrController@updateStatus');

        route::resource('/product_image','ProductImageController')->except('create','update');
        route::get('/product_image/{product_image}/status','ProductImageController@updateStatus');
        //banner
        route::resource('/banner','BannerController')->except('create','update','show');
        route::get('/banner/{banner}/status','BannerController@updateStatus');

        // order
        route::resource('/order','OrderController')->except('create','update');
        route::get('/order/{order}/status','OrderController@updateStatus');

        // coupons
        route::resource('/coupon','CouponController')->except('create','update');
        route::get('/coupon/{coupon}/status','CouponController@updateStatus');

        //admin
        route::resource('/member','AdminController')->except('create','update','show');


         // section
        route::get('/section','SectionController@index')->name('section.index');
        route::get('/section/{section}/status','SectionController@updateStatus');


        // profile admin
        route::get('/{page}','ProfileController@index')->name('profile.index');
        Route::post('/profile/change_password','ProfileController@changePassword')->name('profile.changePassword');
        route::post('/profile/update_profile','ProfileController@updateProfile')->name('profile.updateProfile');

        // route::resource('/user','UserController');


    });

});
