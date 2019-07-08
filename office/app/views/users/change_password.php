<?php require APPROOT . '/views/_shared/header.php'; ?>

  <div class="row">
    <div class="col-md-6 mx-auto">

      <div class="card card-body bg-light mt-3 mb-4">

        <h3 class="card-title">Change password</h3>
        <small class="text-muted mb-4">Please update your password on a regular basis.</small>
        
        <form method="post" action="<?php echo URLROOT; ?>/index.php?url=users/change_password">
          
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label for="current_password">Current Password: <sup class = "text-danger">*</sup></label>
                <input type="password" id="current_password" name="current_password" value="<?php echo $data_array['current_password'] ?>" placeholder="Enter your current password" class="form-control form-control-lg <?php echo empty($data_array['current_password_err']) ? '' : 'is-invalid'; ?> ">
                <span class="invalid-feedback"><?php echo $data_array['current_password_err'] ?></span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <div class="form-group">
                <label for="new_password">New Password: <sup class = "text-danger">*</sup></label>
                <input type="password" id="new_password" name="new_password" value="<?php echo $data_array['new_password'] ?>" placeholder="Enter your new password" class="form-control form-control-lg <?php echo empty($data_array['new_password_err']) ? '' : 'is-invalid'; ?> ">
                <span class="invalid-feedback"><?php echo $data_array['new_password_err'] ?></span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <div class="form-group">
                <label for="retyped_new_password">Confirm Password: <sup class = "text-danger">*</sup></label>
                <input type="password" id="retyped_new_password" name="retyped_new_password" value="<?php echo $data_array['retyped_new_password'] ?>" placeholder="Confirm your new password" class="form-control form-control-lg <?php echo empty($data_array['retyped_new_password_err']) ? '' : 'is-invalid'; ?> ">
                <span class="invalid-feedback"><?php echo $data_array['retyped_new_password_err'] ?></span>
              </div>
            </div>
          </div>

          <div class="row mt-3">
            <div class="col">
              <div class="form-group">
                <input type="submit" value="Change" class="btn btn-success btn-block">
              </div>
            </div>
          </div>

        </form>

      </div>
    </div>
  </div>
  
  <?php require APPROOT . '/views/_shared/references.php'; ?>

<?php require APPROOT . '/views/_shared/footer.php'; ?>