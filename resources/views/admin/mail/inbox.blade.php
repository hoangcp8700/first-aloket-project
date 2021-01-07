@extends('layouts.app_admin')

@section('style')
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

@stop


@section('content')
<div class="row mt position-relative">
    <div class="col-md-12 col-lg-7">
      <section class="panel">
        <header class="panel-heading wht-bg">
          <h4 class="gen-case">
              Inbox ({{count($contacts)}})
            </h4>
        </header>
        <div class="panel-body minimal">
          <div class="mail-option">
            <div class="chk-all">
              <div class="pull-left mail-checkbox d-flex align-items-center">
                <input type="checkbox" class="">
                <select class="pl-2 ml-2" id="">
                    <option>Tất cả</option>
                    <option>Đã xem</option>
                    <option>Chưa xem</option>
                    <option>Dã xóa</option>
                  </select>
              </div>
            </div>

          </div>
          <div class="table-inbox-wrap ">
            <table class="table table-inbox ">
              <tbody id="inboxView">
                    @include('admin.mail.inbox_view')
              </tbody>
            </table>
          </div>
        </div>
      </section>
    </div>
    <div class="col-lg-5 d-none d-lg-block" id="loadMailBox">
        @include('admin.mail.mail_view')
    </div>
</div>
<div id="loader"></div>
@stop

@section('scripts')

<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function showMessage(id){
        event.preventDefault();
        var contact_id = id;
        $.get("{{ route('contact.index') }}" + '/' + contact_id, function(data) {
            $('#loadMailBox').html(data.view);
        })

    }

    function buttonReply(id){
        event.preventDefault();
        $.get("{{ route('contact.index') }}" + '/' + id, function(data) {
            CKEDITOR.replace( 'contactContent',{
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

            $('#contactID').val(data.contact.id);
            $('#contactEmail').val(data.contact.email);

        })
    }

    function hideModal() {
        $("#formModalReply").removeClass("show in");
        $(".modal-backdrop").remove();
        $("#formModalReply").hide();

    }

    function buttonSend(){
        event.preventDefault();
        document.querySelector('#loader').style.display = 'block';

        for ( instance in CKEDITOR.instances ){
            CKEDITOR.instances["contactContent"].updateElement();
        }
        var form = $('#replyForm').serialize();
        $.ajax({
            url: '{{route('contact.reply')}}',
            data: form,
            type: 'post',
            success: function(data){
                setTimeout(function() {
                    document.querySelector('#loader').style.display = 'none';
                    swal({
                        icon: data.statuscode,
                        title: data.status
                    });
                    $('#inboxView').html(data.view);
                }, 3000);
                if(data.statuscode == 'success'){
                    hideModal();
                }
            },error: function(){
                alert('error');
            }
        })
    }

    function btnSeen(){
        event.preventDefault();
        document.querySelector('#loader').style.display = 'block';

        let contact_id = $('#contactID').val();

        $.ajax({
            url: '{{route('contact.reply')}}',
            type: 'post',
            data: { "_token": "{{ csrf_token() }}", id: contact_id, reply:true},
            success: function(data){
                setTimeout(function() {
                    document.querySelector('#loader').style.display = 'none';
                    swal({
                        icon: data.statuscode,
                        title: data.status
                    });
                    $('#inboxView').html(data.view);
                }, 3000);

                if(data.statuscode == 'success'){
                    hideModal();
                }
            },error: function(){
                alert('error');
            }
        })
    }

    function buttonDelete(id){
        event.preventDefault();

        swal({
            title: "Bạn đã chắc chắc muốn xóa phản hồi này?",
            text: "Khi bạn đã xóa nó đi thì sẽ không bao giờ khôi phục lại được.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            document.querySelector('#loader').style.display = 'block';
            if (willDelete) {
                $.ajax({
                    url: "{{ route('contact.store') }}"+'/'+id,
                    type: 'delete',
                    data: { "_token": "{{ csrf_token() }}","id": id },
                    success: function(data){
                        setTimeout(function() {
                            document.querySelector('#loader').style.display = 'none';
                            swal({
                                icon: data.statuscode,
                                title: data.status
                            });
                            $('#inboxView').html(data.view);
                        }, 3000);
                    },error: function(){
                        alert('error');
                    }
                })
            } else {
                document.querySelector('#loader').style.display = 'none';
                swal("Phản hồi vẫn còn nguyên vẹn");
            }
        });

    }
</script>

@stop
