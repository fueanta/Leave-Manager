<?php require APPROOT . '/views/_shared/header.php'; ?>

  <div class="row">
    <div class="col-md-6 mx-auto">
      <div class="card card-body bg-light mt-5">
        
        <h3 class="card-title">Department Details</h3>
        <small class="text-muted mb-3">Please fill out the form as mentioned.</small>

        <div class="mt-2"></div>
        
        <form action="<?php echo URLROOT; ?>/index.php?url=items/department_submit/" method="post">

          <input type="hidden" name="id" value="<?php echo $data_array['id'] ?>">

          <div class="row">
            <div class="col-md-12 col-xs-12">
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" required id="name" value="<?php echo $data_array['name'] ?>">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 col-xs-12">
              <div class="form-group">
                <label for="description">Short Description</label>
                <textarea id="description" name="description" class="form-control"><?php echo $data_array['description'] ?></textarea>              
              </div>
            </div>
          </div>

          <div class="row justify-content-center mt-3">
            <div class="col-md-5 col-xs-12">
                <div class="form-group">
                  <button type="submit" class="btn btn-success btn-block mt-2" tabindex="7">Submit</button>
                </div>
              </div>
          </div>

        </form>

      </div>
    </div>
  </div>

  <?php require APPROOT . '/views/_shared/references.php'; ?>

<?php require APPROOT . '/views/_shared/footer.php'; ?>