@extends('layouts.master')

@section('title', 'Products')

@section('breadcrumb')
	@parent
	<li class="breadcrumb-item active">Products</li>
@endsection

@section('content')
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <button onclick="addForm('{{ route('products.store') }}')" class="btn btn-success btn-xs btn-flat px-3"><i class="fa fa-plus-circle"></i> Add</button>
                <button onclick="deleteSelected('{{ route('products.delete_selected') }}')" class="btn btn-danger btn-xs btn-flat px-3"><i class="fa fa-trash"></i> Delete</button>
                <button onclick="cetakBarcode('{{ route('products.cetak_barcode') }}')" class="btn btn-info btn-xs btn-flat px-3"><i class="fa fa-barcode"></i> Cetak</button>
              </div>

              <div class="card-body table-responsive">
               
               <form class="form-product" method="post">
                @csrf
                 <table class="table table-striped table-bordered" id="table_satu">
                  <thead>
                    <tr>
                      <th>
                        <input type="checkbox" name="select_all" id="select_all">
                      </th>
                      <th width="5%">No</th>
                      <th>Code</th>
                      <th>Name</th>
                      <th>Category</th>
                      <th>Brand</th>
                      <th>Purchase Price</th>
                      <th>Selling Price</th>
                      <th>Discount</th>
                      <th>Stock</th>
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


@includeIf('product.form')
@endsection

@push('scripts')
  <script type="text/javascript">
    
    let table;

    $(function(){
      table = $('#table_satu').DataTable({
        processing: true,
        autoWidth: false,
        ajax: {
          url: "{{ route('products.data') }}"
        },
        columns: [
          {data: 'select_all'},
          {data: 'DT_RowIndex', searchable: false, sortable: true},
          {data: 'code'},
          {data: 'product_name'},
          {data: 'category_name'},
          {data: 'brand'},
          {data: 'purchase_price'},
          {data: 'selling_price'},
          {data: 'discount'},
          {data: 'stock'},
          {data: 'action', searchable: false, sortable: true}
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

      $('[name=select_all]').on('click', function(){
        $(':checkbox').prop('checked', this.checked);
      });

    });

    function addForm(url){
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Add Product');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('post');
      // $('#modal-form [name=nama]').focus();
    }

    function editForm(url){
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Edit Product');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('put');
      $('#modal-form [name=product_name]').focus();

      $.get(url)
        .done((response) => {
           $('#modal-form [name=product_name]').val(response.product_name);
           $('#modal-form [name=category_id]').val(response.category_id);
           $('#modal-form [name=brand]').val(response.brand);
           $('#modal-form [name=purchase_price]').val(response.purchase_price);
           $('#modal-form [name=selling_price]').val(response.selling_price);
           $('#modal-form [name=discount]').val(response.discount);
           $('#modal-form [name=stock]').val(response.stock);
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

    function deleteSelected(url){
        if($('input:checked').length > 1){
          if(confirm('Yakin hapus data terpilih?')){
            $.post(url, $('.form-product').serialize())
            .done((res) => {
              table.ajax.reload()
            })
            .fail((errors) => {
              alert('Tidak dapat menghapus data terpilih!!!');
            });
          }
        }else{
          alert('Pilihlah beberapa produk untuk di hapus!!!');
          return;
        }
    }

    function cetakBarcode(url){
      if($('input:checked').length < 1){
         alert('Pilih produk terlebih dahulu!!!');
         return;
      // }else if($('input:checked').length < 3){
      //   alert('Pilih minimal 3 produk!!!');
      //   return;
      }else{
        $('.form-product')
           .attr('target', '_blank')
           .attr('action', url)
           .submit();
      }
    }

  </script>
@endpush