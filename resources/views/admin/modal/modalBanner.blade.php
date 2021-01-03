
<div class="modal fade" id="formModalBanner" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
            <div class="form-panel">
              <div class="form">
                <form class="cmxform form-horizontal style-form" id="bannerForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        {{-- <button type="button"  class="close" data-dismiss="modal">&times;</button> --}}
                    </div>

                    <span id="form_output"></span>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="banner_id" value="">

                        <div class="form-group ">
                            <label for="cemail" class="control-label col-lg-2">Tiêu đề</label>
                            <div class="col-lg-10">
                            <input class="form-control" name="title" id="bannerTitle" type="text"/>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="curl" class="control-label col-lg-2">ALT</label>
                            <div class="col-lg-10">
                            <input class="form-control"name="alt" id="bannerALT" type="text" placeholder="VD: Banner áo" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="curl" class="control-label col-lg-2">URL</label>
                            <div class="col-lg-10">
                            {{-- <input class="form-control"  name="url" id="bannerURL" type="text" placeholder="VD: trang-chu" /> --}}
                            <select class="form-control" name="url" id="bannerURL">
                                <option value="">Chọn URL của trang</option>
                                @foreach($urlBanners as $key => $urlBanner)
                                    <option value="{{$key}}" class="item_banner" > {{$urlBanner}} </option>
                                @endforeach
                            </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">Ảnh</label>
                            <div class="col-lg-10">
                              <input type="file" name="image" id="bannerImage" class="default" />
                              <div id="valueImage"></div>
                              <p><small>(Kích thước tiêu chuẩn: 1903X500)</small></p>
                            </div>
                            <div id="bannerImageOld"></div>
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


