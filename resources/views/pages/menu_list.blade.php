@extends('layouts.app')

@section('nd')

<?php
    use App\Category;
    use App\Banner;
    use App\Section;
    $sections = Section::sections();
    $categoriesM = Category::categories();
    $bannersM = Banner::banners('menu-list');
?>

<div class="breadcrumb-area pt-205 breadcrumb-padding pb-210" style="background-image: url({{$bannersM}})">
    <div class="container-fluid">
        <div class="breadcrumb-content text-center">
            <h2>Menu list</h2>
            <ul>
                <li><a href="{{route('page.index')}}">trang chủ</a></li>
                <li><a href="{{route('page.menu_list')}}">danh mục</a></li>
                @if(Request::is('danh-muc/*'))
                <li class="active">{{$categoryDetails[0]->name}}</li>
                @endif
            </ul>
        </div>
    </div>
</div>
<div class="shop-page-wrapper shop-page-padding ptb-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3  d-none d-lg-block">
                <div class="shop-sidebar mr-50">
                    <div class="sidebar-widget mb-50">
                        <h3 class="sidebar-title">Search Products</h3>
                        <div class="sidebar-search">
                            <form method="post">
                                @csrf
                                <input id="searchCategory" name="category_id" type="hidden" value="{{$categoryDetails[0]->id}}">
                                <input id="searchProduct" name="search" placeholder="Search Products..." type="text">
                                <button type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="sidebar-widget mb-45">
                        <h3 class="sidebar-title">Categories</h3>
                        <ul>
                            @foreach($sections as $section)
                                @if(count($section['category'])>0 )
                                <li class="pb-3">
                                    <a href="#" class="parent_a_dropdown">{{$section['name']}}</a>
                                    @foreach($section['category'] as $category)
                                    <ul class="child-menu-list-dropdown">
                                        <li><a href="{{route('page.menu_listen',$category['slug'])}}" autofocus>{{$category['name']}}</a>   </li>
                                    </ul>
                                    @endforeach
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
            <div class="col-lg-9 col-md-12">
                <div class="shop-product-wrapper res-xl">
                    <div class="shop-bar-area">
                        <div class="shop-bar pb-60">
                            <div class="shop-found-selector">
                                @if($categoryDetails[0])
                                <?php $urlSort = $categoryDetails[0]->slug?>
                                <form>
                                    <input type="hidden" name="url" id="url" value="{{$urlSort}}">
                                    <div class="shop-selector">
                                        <label>Sắp xếp theo: </label>
                                        <select name="sort" class="pl-3" style=" width: 150px;" id="sort" >
                                            <option value="">Mặc định</option>
                                            <option value="name_a_z" @if(isset($_GET['sort']) && $_GET['sort'] == 'name_a_z') selected @endif>A to Z</option>
                                            <option value="name_z_a" @if(isset($_GET['sort']) && $_GET['sort'] == 'name_z_a') selected @endif> Z to A</option>
                                            <option value="name_new" @if(isset($_GET['sort']) && $_GET['sort'] == 'name_new') selected @endif>Sản phẩm mới</option>
                                            <option value="name_old" @if(isset($_GET['sort']) && $_GET['sort'] == 'name_old') selected @endif>Sản phẩm cũ</option>
                                            <option value="tien_tang" @if(isset($_GET['sort']) && $_GET['sort'] == 'tien_tang') selected @endif> Giá tiền ↑</option>
                                            <option value="tien_giam"@if(isset($_GET['sort']) && $_GET['sort'] == 'tien_giam') selected @endif > Giá tiền ↓</option>
                                        </select>
                                    </div>
                                </form>
                                @endif
                            </div>
                            <div class="shop-filter-tab">
                                <div class="shop-tab nav" role=tablist>
                                    <a class="active" href="#grid-sidebar3" data-toggle="tab" role="tab" aria-selected="false">
                                        <i class="ti-layout-grid4-alt"></i>
                                    </a>
                                     <a href="#grid-sidebar4" class="d-none d-md-block" data-toggle="tab" role="tab" aria-selected="true">
                                        <i class="ti-menu"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="shop-product-content tab-content " id="filter_products">
                            @include('layouts.ajax_product');
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@stop

@push('script')
    <script src="{{asset('frontend/assets/js/pages/menu_list.js')}}"> </script>
@endpush
