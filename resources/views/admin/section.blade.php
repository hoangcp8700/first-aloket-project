@extends('layouts.app_admin')

@section('content')

    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
          <div class="card-header py-3 card-flex">
            <h3 class=" font-weight-bold text-primary text-center">TẤT CẢ LĨNH VỰC
            </h3>
            {{-- <a class="btnModal" id="btnCategory" href="#" data-toggle="modal" data-target="#formModalCategory">
                <i class="fas fa-plus"></i></a> --}}
          </div>
          <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="sectionTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                              <th>#</th>
                            <th>Danh mục</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                </table>
            </div>
          </div>
        </div>
    </div>
@stop

@section('scripts')
<script>
$(function() {
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	var sectionTable = $('#sectionTable').DataTable({
		dom: 'Pfrtip',
        language: {
             emptyTable: "Chưa có lĩnh vực nào!",
             info: 'Tổng : _TOTAL_'
	    },
        ajax: "{{ route('section.index') }}",

        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex'},
            { data: 'name', name: 'name' }, 
            { data: 'status', name: 'status'},
        ],
        pageLength: 6,

        oLanguage: {
	      oPaginate: {
	        sNext: 'Next <i class="fas fa-angle-double-right"></i>',
	        sPrevious: '<i class="fas fa-angle-double-left"></i> Previous'
	      }
	    },
    });

    //update status
    $('body').on('click', '.updateStatus', function (e) {
    	e.preventDefault();
        var status = $(this).data('id');
        $.get("{{ route('section.index') }}" + '/' + status +'/status', function(data) {
            sectionTable.ajax.reload();
            swal({
                icon: data.statuscode,
                title: data.status
            });
        })

    });
});
</script>
@stop
