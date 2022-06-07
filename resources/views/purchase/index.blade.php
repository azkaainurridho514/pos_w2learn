@extends('layouts.master')

@section('title', 'Purchase')

@section('breadcrumb')
	@parent
	<li class="breadcrumb-item active">Purchase</li>
@endsection

@section('content')

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <button onclick="addForm()" class="btn btn-success btn-xs btn-flat px-3"><i class="fa fa-plus-circle"></i> Add New Transaction</button>

                @empty(! session('purchase_id'))
                <a href="{{ route('purchases_detail.index') }}" class="btn btn-info btn-xs btn-flat px-3 text-light"><i class="fa fa-info"></i> Transaction Active</a>
                @endempty

              </div>

              <div class="card-body table-responsive">
               
               <form class="form-member">
                 <table class="table table-striped table-bordered purchases-table">
                   @csrf
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Date</th>
                        <th>Supplier</th>
                        <th>Total Items</th>
                        <th>Total Price</th>
                        <th>Discount</th>
                        <th>Total Payment</th>
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


@includeIf('purchase.supplier')
@includeIf('purchase.detail')
@endsection

@push('scripts')
  <script type="text/javascript">
    
    let table, tableDetail;

    $(function(){
      table = $('.purchases-table').DataTable({
        processing: true,
        autoWidth: false,
        ajax: {
          url: "{{ route('purchases.data') }}"
        },
        columns: [
          {data: 'DT_RowIndex', searchable: false, sortable: false},
          {data: 'date'},
          {data: 'supplier'},
          {data: 'total_item'},
          {data: 'total_price'},
          {data: 'discount'},
          {data: 'pay'},
          {data: 'action', searchable: false, sortable: false}
        ]
      });

          $('.supplier-table').DataTable();

           tableDetail = $('.detail-table').DataTable({
            processing: true,
            bSort: false,
            dom: "Brt",
              columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'code'},
                {data: 'product_name'},
                {data: 'purchase_price'},
                {data: 'total'},
                {data: 'subtotal'}
              ]
           });

    });


    function showProduct(url)
    {
      $('#modal-detail').modal('show');

      tableDetail.ajax.url(url);
      tableDetail.ajax.reload();
    }

    function addForm(){
      $('#modal-supplier').modal('show');
    }


    function deleteProduct(url){
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