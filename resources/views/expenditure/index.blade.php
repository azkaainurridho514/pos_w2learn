@extends('layouts.master')

@section('title', 'Expenditure')

@section('breadcrumb')
	@parent
	<li class="breadcrumb-item active">Expenditure</li>
@endsection

@section('content')

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <button onclick="addForm('{{ route('expenditures.store') }}')" class="btn btn-success btn-xs btn-flat px-3"><i class="fa fa-plus-circle"></i> Add</button>
              </div>

              <div class="card-body table-responsive">
               
               <form class="form-member">
                 <table class="table table-striped table-bordered">
                   @csrf
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Nominal</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                   
                 </table>
               </form>

              </div>

            </div>
          </div>
        </div>


@includeIf('expenditure.form')
@endsection

@push('scripts')
  <script type="text/javascript">
    
    let table;

    $(function(){
      table = $('.table').DataTable({
        processing: true,
        autoWidth: false,
        ajax: {
          url: "{{ route('expenditures.data') }}"
        },
        columns: [
          {data: 'DT_RowIndex', searchable: false, sortable: false},
          {data: 'created_at'},
          {data: 'description'},
          {data: 'nominal'},
          {data: 'action', searchable: false, sortable: false}
        ]
      });

      $('#modal-form').validator().on('submit', function(e){
        if(!e.preventDefault()){
          $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
          .done((res) => {
            $('#modal-form').modal('hide');
            table.ajax.reload();
          })
          .fail((error) => {
            alert('Tidak dapat menyimpan data');
          });
        }
      });

    });

    function addForm(url){
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Add supplier');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('post');
    }

    function editForm(url){
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Edit supplier');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('put');

      $.get(url)
        .done((response) => {
          $('#modal-form [name=description]').val(response.description);
          $('#modal-form [name=nominal]').val(response.nominal);
        })
        .fail((errors) => {
          alert('Something went wrong!');
          return;
        });
    }

     function deleteData(url){
      if(confirm('Yakin ingin menghapus data terpilih?'))
      {
        $.post(url, {
        '_token' : $('[name=csrf-token]').attr('content'),
        '_method' : 'delete'
        })
            .done((res) => {
              $('#modal-form').modal('hide');
              table.ajax.reload();
            })
            .fail((error) => {
              alert('Tidak dapat menghapus data');
            });
      }
    }
  </script>
@endpush