

<div class="modal fade bd-example-modal-lg" id="formModalShowOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span class="pe-7s-close" aria-hidden="true"></span>
    </button>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-panel">
                    <form class="cmxform form-horizontal style-form">
                        <div class="form">
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-3 lbp">Tên khách hàng</label>
                                <label class="control-label col-lg-10" id="nameO">
                                </label>
                            </div>
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-3 lbp">Email</label>
                                <label class="control-label col-lg-10" id="emailO">
                                </label>
                            </div>
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-3 lbp">Số điện thoại</label>
                                <label class="control-label col-lg-10" id="phoneO">
                                </label>
                            </div>
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-3 lbp">Địa chỉ</label>
                                <label class="control-label col-lg-10" id="addressO">
                                </label>
                            </div>
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-3 lbp">Tổng tiền hóa đơn</label>
                                <label class="v col-lg-10" id="totalO">
                                </label>
                            </div>
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-3 lbp">Hóa đơn giảm còn </label>
                                <label class="v col-lg-10" id="discountO">
                                </label>
                            </div>
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-3 lbp">Ngày tạo hóa đơn</label>
                                <label class="v col-lg-10" id="created_atO">
                                </label>
                            </div>
                            <div class="     table-responsive">
                                <table class="table table-bordered" id="tableO" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Tên sản phẩm</th>
                                            <th>Giá</th>
                                            <th>Số lượng</th>
                                            <th>Size</th>
                                        </tr>
                                    </thead>
                                    <tbody id="valueOrderTable">

                                    </tbody>
                                </table>
                            </div>
                            {{-- <div class="form-group ">
                                <label for="cname" class="control-label col-lg-3 lbp">Tên sản phẩm </label>
                                <label class="v col-lg-10" class="productO">
                                </label>
                            </div>
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-3 lbp"> </label>
                                <label class="v col-lg-10" id="discountO">
                                </label>
                            </div>
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-3 lbp">Hóa đơn giảm còn </label>
                                <label class="v col-lg-10" id="discountO">
                                </label>
                            </div> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="formModalOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
            <div class="form-panel">
              <div class="form">
                <form class="cmxform form-horizontal style-form" id="orderForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        {{-- <button type="button"  class="close" data-dismiss="modal">&times;</button> --}}
                    </div>
                    <input type="hidden" name="id" id="order_id" value="">

                    <div class="modal-body">
                        <div class="form-group ">
                            <label for="cname" class="control-label col-lg-3">Trạng thái</label>
                            <div class="col-lg-10">
                                <select class="form-control" name="status">
                                    @foreach($status as $key => $value)
                                        <option value="{{$key}}" class="item_status" > {{$value}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    <div class="modal-footer">
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                            <button class="btn btn-theme" id="saveButton" type="submit"><i class="fas fa-plus"></i> Save</button>
                            <button class="btn btn-theme04" type="button" data-dismiss="modal"><i class="fas fa-backspace"></i> Cancel</button>
                            </div>
                        </div>
                    </div>

                </form>
              </div>
            </div>
		</div>
	</div>
</div>
