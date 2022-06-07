<div class="modal fade" id="modal-product" tabindex="-1" aria-labelledby="modal-form" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <table class="table table-striped table-bordered product-table">
          <thead>
            <th width="5%">No</th>
            <th>Code</th>
            <th>Name</th>
            <th>Purchase Price</th>
            <th><i class="fa fa-cog"></i></th>
          </thead>
          <tbody>
            @foreach($product as $key => $item)
              <tr>
                <td width="5%">{{ $key+1 }}</td>
                <td><span class="btn btn-success btn-sm btn-flat">{{ $item->code }}</span></td>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->purchase_price }}</td>
                <td>
                  <a href="#" onclick="selectProduct('{{ $item->product_id }}', '{{ $item->code }}')" class="btn btn-primary btn-xs btn-flat"><i class="fa fa-check-circle"></i> Select</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>