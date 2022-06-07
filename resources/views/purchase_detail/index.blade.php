@extends('layouts.master')

@section('title', 'Purchase Transaction')

@push('css')
  <style type="text/css">
    .show-pay{
      font-size: 3em;
      text-align: center;
      height: 90px;
      padding: 5px 0;
    }

    .show-say{
      padding: 10px;
      background: #ddd;
    }

    .purchase-table tbody tr:last-child{
      display: none;
    }

    @media(max-width: 760px){
      .show-pay{
        font-size: 3em;
        height: 70px;
        padding-top: 5px;
      }
    }
  </style>
@endpush

@section('breadcrumb')
	@parent
	<li class="breadcrumb-item active">Purchase Transaction</li>
@endsection

@section('content')

        <div class="row">
          <div class="col-md-12">
            <div class="card mb-5">
              <div class="card-header">
                <table class="">
                  <tr>
                    <td>Supplier</td>
                    <td>: {{ $supplier->name }}</td>
                  </tr>
                  <tr>
                    <td>Phone</td>
                    <td>: {{ $supplier->phone }}</td>
                  </tr>
                  <tr>
                    <td>Address</td>
                    <td>: {{ $supplier->address }}</td>
                  </tr>
                </table>
              </div>

              <div class="card-body">

                <div class="col-lg-4">
                    <form class="form-product">
                      @csrf
                      <div class="form-group">
                        <label for="code">Product Code :</label>
                        <div class="input-group">
                          <input type="hidden" name="product_id" id="product_id">
                          <input type="hidden" name="purchase_id" id="purchase_id" value="{{ $purchase_id }}">
                          <input type="text" class="form-control" name="code" id="code">
                          <div class="input-group-append">
                            <button class="btn btn-info btn-flat" onclick="showProduct()" type="button" id="button-addon2"><i class="fa fa-arrow-right"></i></button>
                          </div>
                        </div>
                      </div>
                    </form>
                </div>
               
                 <table class="table table-striped table-bordered purchase-table">
                   @csrf
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th width="15%">Total</th>
                        <th>Subtotal</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                   
                 </table>

                 <div class="row mt-3">
                   <div class="col-lg-8">
                     <div class="show-pay bg-primary"></div>
                     <div class="show-say"></div>
                   </div>
                   <div class="col-lg-4"> 
                    <form action="{{ route('purchases.store') }}" class="form-purchase" method="post">
                      @csrf
                      <input type="hidden" name="purchase_id" value="{{ $purchase_id }}">
                      <input type="hidden" name="total" id="total">
                      <input type="hidden" name="total_item" id="total_item">
                      <input type="hidden" name="pay" id="pay">
                      <div class="form-group row">
                        <label class="col-lg-4 control-label" for="totalrp">Total</label>
                          <input type="text" id="totalrp" class="form-control" value="" readonly>
                      </div>
                      <div class="form-group row">
                        <label class="col-lg-4 control-label" for="discount">Discount</label>
                          <input type="number" name="discount" id="discount" class="form-control">
                      </div>
                      <div class="form-group row">
                        <label class="col-lg-4 control-label" for="pay">Pay</label>
                          <input type="text" id="payrp" class="form-control">
                      </div>
                    </form>
                   </div>
                 </div>

              </div>
              <div class="card-footer">
                <button type="button" class="btn btn-primary btn-flat btn-sm float-right btn-save"><i class="fa fa-save"></i> Save Transaction</button>
              </div>
            </div>
          </div>
        </div>


@includeIf('purchase_detail.product')
@endsection

@push('scripts')
  <script type="text/javascript">
    
    let table;

    $(function(){
      table = $('.purchase-table').DataTable({
        processing: true,
        autoWidth: false,
        ajax: {
          url: "{{ route('purchases_detail.data', $purchase_id) }}"
        },
        columns: [
          {data: 'DT_RowIndex', searchable: false, sortable: false},
          {data: 'code'},
          {data: 'product_name'},
          {data: 'purchase_price'},
          {data: 'total'},
          {data: 'subtotal'},
          {data: 'action', searchable: false, sortable: false}
        ],
        dom: 'Brt',
        bSort: false
      })
      .on('draw.dt', function(){
        loadForm($('.discount').val());
      });



      $('.product-table').DataTable();

      $(document).on('input', '.quantity', function(){
          let id = $(this).data('id');
          let total = parseInt($(this).val());

          if(total > 10000){
            $(this).val(10000);
            alert('Stok tidak boleh lebih dari 10.000!');
            return;
          }else if(total < 1){
            $(this).val(1);
            alert('Stok tidak boleh kurang dari 1!');
            return;
          }

          $.post(`{{ url('purchases_detail') }}/${id}`, { 
              '_token' : $('[name=csrf-token]').attr('content'),
              '_method' : 'PUT',
              'total': total
            })
            .done(res => {
                $(this).on('mouseout', function(){
                  table.ajax.reload();
                });
            })
            .fail(err => {alert('Tidak dapat menyimpan data!'); return;});

            
      });

        if($('#discount').val() == ""){
          $('#discount').val(0).select();
        }else if($('#discount').val() > 100){
          $('#discount').val(0).select();
        }

      $(document).on('mouseout', '#discount', function(){
        loadForm($(this).val());
      });

      $('.btn-save').on('click', function(){
        $('.form-purchase').submit();
      });

    });

    function showProduct(){
      $('#modal-product').modal('show');
    }
    function hideProduct(){
      $('#modal-product').modal('hide');
    }

   function selectProduct(id, code)
   {
    $('#product_id').val(id);
    $('#code').val(code);
    hideProduct();
    addProduct();
   }

   function addProduct()
   {
    $.post('{{ route('purchases_detail.store') }}', $('.form-product').serialize())
    .done(res =>  {$('#code').focus(); table.ajax.reload(); })
    .fail(err =>  {alert('Tidak dapat menyimpan data!!!'); return;} );
   }

    // function deleteData(url){
    //   if(confirm('Yakin ingin menghapus data?'))
    //   {
    //     $.post(url, {
    //     '_token' : $('[name=csrf-token]').attr('content'),
    //     '_method' : 'delete'
    //     })
    //         .done((res) => {
    //           $('#modal-form').modal('hide');
    //           table.ajax.reload();
    //         })
    //         .fail((error) => {
    //           alert("Something went wrong!");
    //           return;
    //         });
    //   }
    // }

      function deleteData(url){
      if(confirm('Yakin ingin menghapus data?'))
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

    function loadForm(discount = 0)
    {
      $('#total').val($('.total').text());
      $('#total_item').val($('.total_item').text());

      $.get(`{{ url('/purchases_detail/loadform') }}/${discount}/${$('.total').text()}`)
       .done(res => {
        $('#totalrp').val('Rp. ' + res.totalrp);
        $('#pay').val(res.pay);
        $('#payrp').val('Rp. ' + res.payrp);
        $('.show-pay').text('Rp. ' + res.payrp + ';-');
        $('.show-say').text('Total : ' + res.terbilang);
       })
       .fail(err => {
        alert('Something went wrong!!!');
        return;
       });
    }
  </script>
@endpush