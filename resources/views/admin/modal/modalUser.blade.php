
<div class="modal fade" id="formModalUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
            <div class="form-panel">
              <div class="form">
                <form class="cmxform form-horizontal style-form" id="userForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        {{-- <button type="button"  class="close" data-dismiss="modal">&times;</button> --}}
                    </div>

                    <span id="form_output"></span>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="userID" value="">

                        <div class="form-group ">
                            <label for="cemail" class="control-label col-lg-2">Tên thành viên</label>
                            <div class="col-lg-10">
                            <input class="form-control" name="name" id="userName" type="text"/>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="cemail" class="control-label col-lg-2">Email</label>
                            <div class="col-lg-10">
                            <input class="form-control" name="email" id="userEmail" type="text"/>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="cemail" class="control-label col-lg-2">Quyền</label>
                            <div class="col-lg-10">
                                <select  name="role_id" id=userRoles >
                                    @foreach($roles as $role)
                                        @if($role->id == 4)
                                            @continue
                                        @endif
                                        <option value="{{$role->id}}" class="role_user">{{($role->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="cemail" class="control-label col-lg-2">Trạng thái</label>
                            <div class="col-lg-10">
                                <select  name="status" id=userStatus >
                                    <option value="0" class="status_user">Chưa xử lý</option>
                                    <option value="1" class="status_user">Đang hoạt động</option>
                                    <option value="2" class="status_user">Khóa</option>
                                </select>
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


