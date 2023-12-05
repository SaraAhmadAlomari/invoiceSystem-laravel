<!-- Modal -->
<div class="modal fade" id="category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="category_form" onsubmit="return false">
          <div class="form-group">
            <label for="cat_name">Category Name</label>
            <input type="text" class="form-control" id="cat_name" name="cat_name">
            <small id="cat_error" class="form-text text-muted"></small>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Parent Category</label>
          <select class="form-control" name="parent_cat" id="parent_cat">
  
          </select>
            <small id="cat_error" class="form-text text-muted"></small>
          </div>
          <button type="submit" class="btn btn-primary">Add</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

        </form>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>