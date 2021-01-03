

<div class="modal fade" id="formModalProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
            <div class="form-panel">
              <div class="form">
                <form class="cmxform form-horizontal style-form" id="productForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        {{-- <button type="button"  class="close" data-dismiss="modal">&times;</button> --}}
                    </div>

                    <span id="form_output"></span>
                    <div class="modal-body">
                        <div id="displayImage"></div>
                        <input type="hidden" name="id" id="product_id" value="">
                        <div class="form-group ">
                            <label for="cname" class="control-label col-lg-2">Lĩnh vực</label>
                            <div class="col-lg-10">
                                <select class="form-control" name="section_id">
                                    <option value="">Chọn lĩnh vực</option>
                                    @foreach($sections as $section)
                                        <option value="{{$section->id}}" class="item_section" > {{$section->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="cname" class="control-label col-lg-2">Danh mục</label>
                            <div class="col-lg-10">
                                <select class="form-control" name="category_id" >
                                    <option value="">Chọn danh mục</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" class="item_category" > {{$category->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="cemail" class="control-label col-lg-2">Tên sản phẩm</label>
                            <div class="col-lg-10">
                            <input onkeyup="productToSlug();" class="form-control productName" name="name" id="productName" type="text" placeholder="Nhập tên sản phấm"/>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="curl" class="control-label col-lg-2">Mã sản phẩm</label>
                            <div class="col-lg-10">
                            <input class="form-control" name="product_code" id="productCode" type="text"  readonly  />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="curl" class="control-label col-lg-2">Màu sắc</label>
                            <div class="col-lg-10">
                            <input class="form-control" name="color" id="productColor" type="text" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="curl" class="control-label col-lg-2">Giá tiền</label>
                            <div class="col-lg-10">
                            <input class="form-control " name="price" id="productPrice" type="text" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="curl" class="control-label col-lg-2">Giá khuyến mãi</label>
                            <div class="col-lg-10">
                            <input class="form-control " name="discount" id="productDiscount" type="text" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="curl" class="control-label col-lg-2">Từ khóa</label>
                            <div class="col-lg-10">
                            <input class="form-control " name="keyword" id="productKeyWord" type="text" placeholder="Hot, 20%, ..."/>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="curl" class="control-label col-lg-2">Số lượng</label>
                            <div class="col-lg-10">
                            <input class="form-control " name="stock" id="productStock" type="number" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="curl" class="control-label col-lg-2">Chất liệu</label>
                            <div class="col-lg-10">
                                <select class="form-control" name="fabric" id="productFabric" >
                                    <option value="">Chọn chất liệu</option>
                                    @foreach($fabrics as $fabric)
                                        <option value="{{$fabric}}" class="item_fabric" > {{$fabric}} </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="curl" class="control-label col-lg-2">Kiểu dáng</label>
                            <div class="col-lg-10">
                                <select class="form-control"  name="fit" id="productFit" >
                                    <option value="">Chọn kiểu dáng</option>
                                    @foreach($fits as $fit)
                                        <option value="{{$fit}}" class="item_fit" > {{$fit}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="curl" class="control-label col-lg-2">Mô tả</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" id="product-description-ckeditor" name="description"></textarea>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="curl" class="control-label col-lg-2">URL</label>
                            <div class="col-lg-10">
                                <input class="form-control productSlug" readonly="" name="slug" id="productSlug" type="text" />
                            </div>
                        </div>

                        <div id="productImageOld"></div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Ảnh chính</label>
                            <div class="col-md-6">
                              <input type="file" name="image"  class="default" />
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

<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'product-description-ckeditor',{
        toolbarGroups  : [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		'/',
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
        ], /* this does the magic */
        removeButtons : 'Save,NewPage,ExportPdf,Preview,Print,Cut,Copy,Paste,PasteText,PasteFromWord,Templates,Find,Replace,SelectAll,Scayt,Image,Flash,Maximize',
    });


</script>
