<!-- Modal -->
<div class="modal fade" id="update_prodects" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Prodects</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="update_prodect_form" onsubmit="return false">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="update_date">Date</label>
                <input type="text" class="form-control" id="update_date" name="update_date" value="<?php echo date("Y-m-d"); ?>"readonly>
              </div>
              <div class="form-group col-md-6">
                <label for="update_prodect_name">Prodect Name</label>
                <input type="text" class="form-control" id="update_prodect_name" name="update_prodect_name">
                <input type="hidden" class="form-control" id="pid" name="pid">
                <small id="update_prodect_error" class="form-text text-muted"></small>

              </div>
            </div>
            <div class="form-group">
              <label for="update_prodect_cat">Category</label>
              <select type="text" class="form-control" id="update_prodect_cat" name="update_prodect_cat" required>
              </select>
            </div>
            <div class="form-group">
              <label for="update_prodect_brand">Brand</label>
              <select type="text" class="form-control" id="update_prodect_brand" name="update_prodect_brand" required>


              </select>
            </div>
            <div class="form-group">
              <label for="update_prodect_price">Prodect Price</label>
              <input type="text" class="form-control" id="update_prodect_price" name="update_prodect_price">
            </div>
            <div class="form-group">
              <label for="update_prodect_qnty">Quantity</label>
              <input type="text" class="form-control" id="update_prodect_qnty" name="update_prodect_qnty">
            </div>
            <button type="submit" class="btn btn-success">Update Prodect</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </form>
      </div>
      
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>