<div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="modal-form" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="" method="post" class="form-horizontal">
      @csrf
      @method('post')
      <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="form-group row">
          <label for="product_name" class="col-md-2 col-md-offset-1 control-lable">Product Name</label>
          <div class="col-md-9">
            <input type="text" name="product_name" id="product_name" class="form-control" autofocus required>
          </div>
        </div>

        <div class="form-group row">
          <label for="" class="col-md-2 col-md-offset-1 control-lable">Category</label>
          <div class="col-md-9">
            <select class="form-control" id="category_id" name="category_id" required>
              <option>Select Category</option>
              @foreach($category as $key => $item)
                  <option value="{{ $key }}">{{ $item }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-group row">
          <label for="brand" class="col-md-2 col-md-offset-1 control-lable">Brand</label>
          <div class="col-md-9">
            <input type="text" name="brand" id="brand" class="form-control">
          </div>
        </div>

        <div class="form-group row">
          <label for="purchase_price" class="col-md-2 col-md-offset-1 control-lable">Purchase Price</label>
          <div class="col-md-9">
            <input type="number" name="purchase_price" id="purchase_price" class="form-control">
          </div>
        </div>

        <div class="form-group row">
          <label for="selling_price" class="col-md-2 col-md-offset-1 control-lable">Selling Price</label>
          <div class="col-md-9">
            <input type="number" name="selling_price" id="selling_price" class="form-control" required>
          </div>
        </div>

        <div class="form-group row">
          <label for="discount" class="col-md-2 col-md-offset-1 control-lable">Discount</label>
          <div class="col-md-9">
            <input type="number" name="discount" id="discount" class="form-control" value="0">
          </div>
        </div>

        <div class="form-group row">
          <label for="stock" class="col-md-2 col-md-offset-1 control-lable">Stock</label>
          <div class="col-md-9">
            <input type="number" name="stock" id="stock" class="form-control" required value="0">
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button class="btn btn-sm btn-flat btn-primary">Simpan</button>
        <button type="button" class="btn btn-sm btn-flat btn-secondary" data-dismiss="modal">Batal</button>
      </div>
    </div>
    </form>
  </div>
</div>