<div class="modal fade" id="modal-supplier" tabindex="-1" aria-labelledby="modal-form" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Supplier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <table class="table table-striped table-bordered supplier-table">
          <thead>
            <th>No</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Address</th>
            <th><i class="fa fa-cog"></i></th>
          </thead>
          <tbody>
            @foreach($supplier as $key => $item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->phone }}</td>
                <td>{{ $item->address }}</td>
                <td>
                  <a href="{{ route('purchases.create', $item->supplier_id) }}" class="btn btn-primary btn-xs btn-flat"><i class="fa fa-check-circle"></i> Select</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>