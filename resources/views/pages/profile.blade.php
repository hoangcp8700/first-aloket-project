@extends('layouts.app')

@section('style')
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="{{asset('frontend/assets/css/profile.css')}}">

@stop

@section('nd')

<div class="container emp-profile ">
    <form method="post">
        <div class="row">
            <div class="col-md-4">
                <div class="profile-img">
                    @if(!Auth::user()->image)
                        <img src="https://dummyimage.com/248x165/d6d6d6/001f5e.png&text=No+image"  alt="Avatar" id="loadAvatarProfile">
                    @else
                        <img src="/storage/{{Auth::user()->image}}"  alt="Avatar" id="loadAvatarProfile">
                    @endif
                    <form method="post" id="profileUploadForm">
                        @csrf
                        <div class="file btn btn-lg btn-primary pb-4" >
                            Thay đổi
                            <input type="file" name="image" id="profileUpload" onchange="submitUpload(this.form)" />
                        </div>

                    </form>

                </div>
            </div>
            <div class="col-md-8">
                <div class="profile-head">
                            <h5 id="loadNameProfile">
                                {{Auth::user()->name ?? 'No Name'}}
                            </h5>
                            <h6>
                                Khách hàng
                            </h6>
                    <ul class="nav nav-tabs mt-4" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Thông tin cá nhân</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Đổi mật khẩu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="profile" aria-selected="false">Đơn hàng</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            {{-- <div class="col-md-4 d-none d-md-block">
                <div class="profile-work">
                    <p>WORK LINK</p>
                    <a href="">Website Link</a><br/>
                    <a href="">Bootsnipp Profile</a><br/>
                    <a href="">Bootply Profile</a>
                    <p>SKILLS</p>
                    <a href="">Web Designer</a><br/>
                    <a href="">Web Developer</a><br/>
                    <a href="">WordPress</a><br/>
                    <a href="">WooCommerce</a><br/>
                    <a href="">PHP, .Net</a><br/>
                </div>
            </div> --}}
            <div class="offset-lg-4  col-md-12 col-lg-8">
                <div class="tab-content profile-tab" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <form method="post" id="formProfile">
                            @csrf
                            <div class="col-md-12 col-lg-10 p-0 ">
                                <div class="card mb-3">
                                    <div class="card-body card-pl">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Họ tên</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <input type="text" class="input-custom" name="name" value="{{Auth::user()->name}}">
                                            </div>
                                        </div>

                                        <div class="row align-items-center mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Email</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <input type="text" class="input-custom" readonly name="email" value="{{Auth::user()->email}}">
                                            </div>
                                        </div>

                                        <div class="row align-items-center mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Số điện thoại</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <input type="text" class="input-custom" name="phone" value="{{Auth::user()->phone}}">
                                            </div>
                                        </div>

                                        <div class="row align-items-center mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Địa chỉ</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <input type="text" class="input-custom" name="address" value="{{Auth::user()->address}}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-9 offset-3">
                                                <button class="btn btn-info submitProfile" type="submit">Thay đổi</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <form method="post" id="formPassword">
                            @csrf
                            <div class="col-md-12 col-lg-10 p-0">
                                <div class="card mb-3">
                                    <div class="card-body card-pl">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Mật khẩu hiện tại</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <input type="password" class="input-custom" name="password_current" >
                                            </div>
                                        </div>

                                        <div class="row align-items-center mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Mật khẩu mới</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <input type="password" class="input-custom" name="password" >
                                            </div>
                                        </div>

                                        <div class="row align-items-center mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Nhập lại mật khẩu</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <input type="password" class="input-custom" name="password_confirmation" >
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-9 offset-3">
                                                <button class="btn btn-info submitProfile" type="submit">Thay đổi</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="col-md-12 col-lg-10 p-0">
                            <div class="card mb-3">
                                <div class="card-body card-pl">
                                    <div class="table-responsive">
                                        <table class="table table-bordered order-table"  width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Ngày tạo đơn</th>
                                                    <th>Tổng tiền</th>
                                                    <th>Trạng thái</th>
                                                    <th>#</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php use App\Order; $total = 0; $boom = 0; $complete = 0; $no = 0;?>
                                                @foreach($orders as $order)
                                                <tr>
                                                    <td> {{date('d-m-Y', strtotime($order['created_at']))}} </td>
                                                    <td> {{number_format($order['discount'])}}đ </td>
                                                    <td> {!!Order::checkStatus($order['status'])!!} </td>
                                                    <td>
                                                        <a class="btn btn-success showOrderProfile" data-id={{$order['id']}}
                                                            data-toggle="modal" href="javascript:void(0)" data-target="#modalOrderProfile">
                                                            <i class="far fa-eye"></i>
                                                        </a>
                                                     </td>
                                                </tr>
                                                <?php
                                                    if($order['status'] == 3){
                                                        $boom += $order['discount'];
                                                    }else if($order['status'] == 1){
                                                        $complete += $order['discount'];
                                                    }else{
                                                        $no += $order['discount'];
                                                    }

                                                    $total += $order['discount'];

                                                ?>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <Td>Tổng hóa đơn:</Td>
                                                    <td colspan="3"><i><b>{{number_format($total)}} đ</b></i></td>
                                                </tr>
                                                <tr>
                                                    <Td>Sắp thanh toán:</Td>
                                                    <td colspan="3"><i>{{number_format($no)}} đ</i></td>
                                                </tr>
                                                <tr>
                                                    <Td>Đã thanh toán:</Td>
                                                    <td colspan="3"><i>{{number_format($complete)}} đ</i></td>
                                                </tr>
                                                <tr style="color:red">
                                                    <Td>Đã hủy:</Td>
                                                    <td colspan="3"><i>{{number_format($boom)}} đ</i></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div id="loader"></div>
</div>

<div class="modal fade bd-example-modal-lg" id="modalOrderProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span class="pe-7s-close" aria-hidden="true"></span>
    </button>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-panel">
                    <form class="cmxform form-horizontal style-form">
                        <div class="form">
                            <div class="form-group d-flex">
                                <label for="cname" class="control-label col-lg-4 lbp">Mã đơn hàng</label>
                                <label class="control-label col-lg-8" id="showCodeOF">
                                </label>
                            </div>
                            <div class="form-group d-flex">
                                <label for="cname" class="control-label col-lg-4 lbp">Tên khách hàng</label>
                                <label class="control-label col-lg-8" id="showNameOF">
                                </label>
                            </div>
                            <div class="form-group d-flex">
                                <label for="cname" class="control-label col-lg-4 lbp">Email</label>
                                <label class="control-label col-lg-8" id="showEmailOF">
                                </label>
                            </div>
                            <div class="form-group d-flex">
                                <label for="cname" class="control-label col-lg-4 lbp">Số điện thoại</label>
                                <label class="control-label col-lg-8" id="showPhoneOF">
                                </label>
                            </div>
                            <div class="form-group d-flex">
                                <label for="cname" class="control-label col-lg-4 lbp">Địa chỉ</label>
                                <label class="control-label col-lg-8" id="showAddressOF">
                                </label>
                            </div>
                            <div class="form-group d-flex">
                                <label for="cname" class="control-label col-lg-4 lbp">Hóa đơn gốc</label>
                                <label class="v col-lg-8" id="showTotalOF">
                                </label>
                            </div>
                            <div class="form-group d-flex">
                                <label for="cname" class="control-label col-lg-4 lbp">Hóa đơn giảm </label>
                                <label class="v col-lg-8" id="showDiscountOF">
                                </label>
                            </div>
                            <div class="form-group d-flex">
                                <label for="cname" class="control-label col-lg-4 lbp">Ngày tạo hóa đơn</label>
                                <label class="v col-lg-8" id="showCreated_atOF">
                                </label>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered"  width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Tên sản phẩm</th>
                                            <th>Giá</th>
                                            <th>Số lượng</th>
                                            <th>Size</th>
                                            <th>Tổng</th>
                                        </tr>
                                    </thead>
                                    <tbody id="showProfileOrderTable">

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@push('script')
<script src="{{asset('frontend/assets/js/pages/profile.js')}}"> </script>
@endpush
