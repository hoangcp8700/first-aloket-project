
<section class="panel mail">
    <header class="panel-heading wht-bg">
        <div class="row" style="padding-left:1em;">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="gen-case"> Thông tin chi tiết </h4>
                    </div>
                    <div class="col-sm-12 pt-3">
                        <strong> {{$contact['name']}} </strong>
                        <span>[{{$contact['email']}}] </span>
                    </div>
                    <div class="col-md-12">
                        <p class="date"> {{\App\Contact::date($contact['created_at'])}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="compose-btn pull-right">
                    <button onclick="buttonReply({{$contact['id']}})" type="button" data-toggle="modal" data-target="#formModalReply" class="btn btn-lg btn-info"><i class="fa fa-reply"></i> Reply</button>
                </div>
            </div>
        </div>
        <div class="mail-sender">
            <div class="row">
                <div class="col-3">
                    <h4 class="gen-case" >Tiêu đề:</h3>
                </div>
                <div class="col-9">
                    <h4 class="gen-case">{{$contact['subject']}}</h3>
                </div>
            </div>
        </div>
    </header>
    <div class="panel-body ">
      <div class="view-mail content">
        <p> {!! $contact['content'] !!} </p>
      </div>
    </div>
  </section>
  @include('admin.mail.reply')
