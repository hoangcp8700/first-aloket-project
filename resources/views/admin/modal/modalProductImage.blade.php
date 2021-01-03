<div class="modal fade " id="formModalProductImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog ">
		<div class="modal-content">
            <div class="form-panel">
                <div class="form">
                    <form class="cmxform form-horizontal style-form" id="productImageForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title"></h4>
                        </div>

                        <span id="form_output"></span>
                        <div class="modal-body">

                            <input type="hidden" name="product_id" id="product_id" value="">
                            <input type="hidden" name="id" id="productImageID" value="">

                            <div id="productImageOld" style="display:none"></div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Upload Ảnh</label>
                                <div class="col-md-6">
                                  <input type="file" name="image" class="default" />
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

