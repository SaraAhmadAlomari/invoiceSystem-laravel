<!-- Modal -->
<div class="modal fade" id="prodects" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add new prodect</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="prodect_form" onsubmit="return false">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="added_date">Date</label>
                <input type="text" class="form-control" id="added_date" name="added_date" value="<?php echo date("Y-m-d"); ?>"readonly>
              </div>
              <div class="form-group col-md-6">
                <label for="p_name">Prodect Name</label>
                <input type="text" class="form-control" id="p_name" name="p_name" placeholder="Enter Prodect Name">
                <small id="prodect_error" class="form-text text-muted"></small>

              </div>
            </div>
            <div class="form-group">
              <label for="select_cat">Category</label>
              <select type="text" class="form-control" id="select_cat" name="select_cat" required>


              </select>
            </div>
            <div class="form-group">
              <label for="select_brand">Brand</label>
              <select type="text" class="form-control" id="select_brand" name="select_brand" required>


              </select>
            </div>
            <div class="form-group">
              <label for="p_price">Prodect Price</label>
              <input type="text" class="form-control" id="p_price" name="p_price" placeholder="Enter Prodect Price">
            </div>
            <div class="form-group">
              <label for="qnty">Quantity</label>
              <input type="text" class="form-control" id="qnty" name="qnty" placeholder="Enter Prodect Quantity">
            </div>
            <button type="submit" class="btn btn-success">Add Prodect</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </form>
      </div>
      
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>