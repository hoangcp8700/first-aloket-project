
<div class="modal fade" id="formModalReply" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
            <div class="row mt">
                <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading wht-bg">
                    <h4 class="gen-case">
                        Phản hồi liên hệ này
                        </h4>
                    </header>
                    <div class="panel-body">
                        <div class="compose-mail">
                            <form role="form-horizontal" method="post" id="replyForm" onSubmit="buttonSend()">
                                @csrf
                                <input type="hidden" name="id" id="contactID">
                                <div class="form-group">
                                    <label class="">To:</label>
                                    <input type="text" readonly class="form-control" name="email" id="contactEmail">
                                </div>
                                <div class="form-group">
                                    <label for="subject" class="">Subject:</label>
                                    <input type="text" class="form-control" name="subject" id="contactSubject">
                                </div>
                                <div class="compose-editor">
                                    <textarea name="content" class="reply-ckeditor form-control" rows="9" id="contactContent"></textarea>
                                </div>
                                <div class="compose-btn">
                                    <button class="btn btn-info btn-lg" type="submit"><i class="fa fa-check"></i> Send</button>
                                    <button class="btn btn-lg btn-seen" id="btn-seen"><i class="far fa-eye"></i> Đã xem</button>
                                    <button class="btn btn-lg btn-skip" type="button" data-dismiss="modal">Bỏ qua</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
                </div>
            </div>
		</div>
	</div>
</div>

