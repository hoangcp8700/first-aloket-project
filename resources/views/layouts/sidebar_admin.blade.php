<aside>
    <div id="sidebar" class="nav-collapse ">
      <!-- sidebar menu start-->
      <ul class="sidebar-menu" id="nav-accordion">
        <p class="centered"><a href="profile.html"><img src="{{Auth::guard('admin')->user()->image ? asset('/storage/'.Auth::guard('admin')->user()->image) : 'https://dummyimage.com/80x80/d6d6d6/001f5e.png&text=no+image'}}" id="loadAvatar" class="img-circle" width="80"></a></p>
        <h5 class="centered" id="loadName">{{Auth::guard('admin')->user()->name}}</h5>
        <li class="mt sub-menu">
          <a class="{{ Route::is('dashboard.index') ? 'active' : '' }}" href="{{route('dashboard.index')}}">
            <i class="fa fa-dashboard"></i>
            <span>Dashboard</span>
            </a>
        </li>
        <li class="sub-menu">
            <a href="javascript:;" class="{{ Route::is('profile.index') ? 'active' : '' }}" >
              <i class="far fa-user ml-05"></i>
              <span>Tài khoản</span>
              </a>
            <ul class="sub">
              <li><a class="{{ Request::url() == url('/admin/profile') ? 'active' : '' }}" href="{{route('profile.index','profile')}}">Thông tin cá nhân</a></li>
              <li><a class="{{ Request::url() == url('/admin/change_password') ? 'active' : '' }}" href="{{route('profile.index','change_password')}}">Đổi mật khẩu</a></li>

            </ul>
        </li>
        <li class="sub-menu">
            <a class="{{ Route::is('section.index') ? 'active' : '' }}" href="{{route('section.index')}}">
              <i class="fa fa-desktop"></i>
              <span>Quản lí lĩnh vực</span>
            </a>
          </li>
        <li class="sub-menu">
          <a class="{{ Route::is('category.index') ? 'active' : '' }}" href="{{route('category.index')}}">
            <i class="fa fa-desktop"></i>
            <span>Quản lí danh mục</span>
          </a>
        </li>
        <li class="sub-menu">
            <a class="{{ Route::is('product.index') || Route::is('attr_product.show') ? 'active' : '' }}" href="{{route('product.index')}}">
              <i class="fa fa-desktop"></i>
              <span>Quản lí sản phẩm</span>
            </a>
        </li>
        <li class="sub-menu">
            <a class="{{ Route::is('banner.index') ? 'active' : '' }}" href="{{route('banner.index')}}">
              <i class="fa fa-desktop"></i>
              <span>Quản lí banner</span>
            </a>
        </li>
        <li class="sub-menu">
            <a class="{{ Route::is('member.index') ? 'active' : '' }}" href="{{route('member.index')}}">
              <i class="fa fa-desktop"></i>
              <span>Quản lí member</span>
            </a>
        </li>
        <li class="sub-menu">
            <a class="{{ Route::is('order.index') ? 'active' : '' }}" href="{{route('order.index')}}">
              <i class="fa fa-desktop"></i>
              <span>Quản lí đơn hàng</span>
            </a>
        </li>
        <li class="sub-menu">
            <a class="{{ Route::is('coupon.index') ? 'active' : '' }}" href="{{route('coupon.index')}}">
              <i class="fa fa-desktop"></i>
              <span>Quản lí coupon</span>
            </a>
        </li>
      </ul>
      <!-- sidebar menu end-->
    </div>
  </aside>
