<!-- Modal -->
<div class="modal fade" id="brands" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add new Brands</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
           <div class="modal-body">
        <form id="brand_form" onsubmit="return false">
          <div class="form-group">
            <label for="brand_name">Brand Name</label>
            <input type="text" class="form-control" id="brand_name" name="brand_name" placeholder="Enter Brand name">
            <small id="brand_error" class="form-text text-muted"></small>
          </div>
          <button type="submit" class="btn btn-primary">Add</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </form>
      </div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>