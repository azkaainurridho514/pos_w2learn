<div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="modal-form" aria-hidden="true">
  <div class="modal-dialog">
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
          <label for="description" class="col-md-2 col-md-offset-1 control-lable">Description</label>
          <div class="col-md-9">
            <input type="text" name="description" id="description" class="form-control" autofocus required>
          </div>
        </div>
        <div class="form-group row">
          <label for="nominal" class="col-md-2 col-md-offset-1 control-lable">Nominal</label>
          <div class="col-md-9">
            <input type="number" name="nominal" id="nominal" class="form-control">
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