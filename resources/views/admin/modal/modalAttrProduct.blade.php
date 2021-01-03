<div class="modal fade bd-example-modal-lg" id="formModalAttr" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
            <div class="form-panel">
                <div class="form">
                  <form class="cmxform form-horizontal style-form" id="attrForm" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="modal-header">
                          <h4 class="modal-title"></h4>
                      </div>
                      <input type="hidden" name="id" id="attrID" value="">
                      <span id="form_output"></span>
                      <div class="modal-body">
                        <div class="form-group ">
                              <label for="cname" class="control-label col-lg-2">Mã sản phẩm</label>
                              <div class="col-lg-10">
                              <input class=" form-control " readonly name="product_attr_code[]" id="attrCode" type="text" placeholder="Nhập tên danh mục" />
                              </div>
                        </div>
                        <div class="form-group ">
                            <label for="cname" class="control-label col-lg-2">Size</label>
                            <div class="col-lg-10">
                            <input class=" form-control " readonly name="size[]" id="attrSize" type="text" placeholder="Nhập tên danh mục" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="cname" class="control-label col-lg-2">Gía tiền</label>
                            <div class="col-lg-10">
                            <input class=" form-control " name="price[]" id="attrPrice" type="text" placeholder="Nhập tên danh mục" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="cname" class="control-label col-lg-2">Số lượng tồn kho</label>
                            <div class="col-lg-10">
                            <input class=" form-control " name="stock[]" id="attrStock" type="text" placeholder="Nhập tên danh mục" />
                            </div>
                        </div>

                      </div>
                      <div class="modal-footer">
                          <div class="form-group">
                              <div class="col-lg-offset-2 col-lg-10">
                                  {{-- id="saveButton" --}}
                              <button class="btn btn-theme"  type="submit"><i class="fas fa-plus"></i> Save</button>
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

