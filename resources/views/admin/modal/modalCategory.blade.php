<div class="modal fade" id="formModalCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
            <div class="form-panel">
              <div class="form">
                <form class="cmxform form-horizontal style-form" id="categoryForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        {{-- <button type="button"  class="close" data-dismiss="modal">&times;</button> --}}
                    </div>
                    <input type="hidden" name="id" id="category_id" value="">
                    <span id="form_output"></span>
                    <div class="modal-body">
                        <div class="form-group ">
                            <label for="cname" class="control-label col-lg-2">Lĩnh vực</label>
                            <div class="col-lg-10">
                                <select class="form-control" name="section_id">
                                    <option value="">Chọn lĩnh vực</option>
                                    @foreach($sections as $section)
                                        <option value=" {{$section->id}} " class="item_section" > {{$section->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="cname" class="control-label col-lg-2">Tên danh mục</label>
                            <div class="col-lg-10">
                            <input onkeyup="ChangeToSlug();" class=" form-control categoryName" name="name" id="categoryName" type="text" placeholder="Nhập tên danh mục" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="cemail" class="control-label col-lg-2">Mô tả</label>
                            <div class="col-lg-10">
                            <input class="form-control " name="description" id="categoryDescription" type="text" placeholder="..." />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="curl" class="control-label col-lg-2">URL</label>
                            <div class="col-lg-10">
                            <input class="form-control categorySlug" readonly="" name="slug" id="categorySlug" type="text"  />
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
