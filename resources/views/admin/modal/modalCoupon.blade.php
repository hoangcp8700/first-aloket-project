<div class="modal fade" id="formModalCoupon" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
            <div class="form-panel">
              <div class="form">
                <form class="cmxform form-horizontal style-form" id="couponForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        {{-- <button type="button"  class="close" data-dismiss="modal">&times;</button> --}}
                    </div>
                    <input type="hidden" name="id" id="coupon_id" value="">
                    <span id="form_output"></span>
                    <div class="modal-body">
                        <div class="form-group ">
                            <label for="cemail" class="control-label col-lg-2">Mã code</label>
                            <div class="col-lg-10">
                            <input class="form-control" readonly  name="code" id="couponCode" type="text" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="cname" class="control-label col-lg-2">Loại coupon</label>
                            <div class="col-lg-10">
                                <select class="form-control" name="type" id="changeValueCoupon">
                                    <option value="">Chọn loại</option>
                                    @foreach($typeCode as $key => $value)
                                        <option value="{{$key}}" class="item_coupon" > {{$value}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="cname" class="control-label col-lg-2">Giá trị</label>
                            <div class="col-lg-10">
                            <input class=" form-control " name="value" id="couponValue" type="text" placeholder="Nhập tên giá trị loại code" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="cemail" class="control-label col-lg-2">Số lượng</label>
                            <div class="col-lg-10">
                            <input class="form-control " name="quantity" id="couponQuantity" type="text" placeholder="Nhập số lượng" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="cemail" class="control-label col-lg-2">Ngày kết thúc</label>
                            <div class="col-lg-10">
                            <input class="form-control " name="outdate" id="couponOutdate" type="date"  />
                            </div>
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
