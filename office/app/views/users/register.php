<?php require APPROOT . '/views/_shared/header.php'; ?>

  <div class="row">
    <div class="col-md-6 mx-auto">
      <div class="card card-body bg-light mt-2 mb-4">
        
        <h3 class="card-title">Create an Account</h3>
        <small class="text-muted mb-4">Please fill out this form to register.</small>
        
        <form method="post" action="<?php echo URLROOT; ?>/index.php?url=users/register">
          
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label for="name">Name: <sup class = "text-danger">*</sup></label>
                <input type="text" id="name" name="name" value="<?php echo $data_array['name'] ?>" placeholder="Enter your name" class="form-control form-control-lg <?php echo empty($data_array['name_err']) ? '' : 'is-invalid'; ?>">
                <span class="invalid-feedback"><?php echo $data_array['name_err'] ?></span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <div class="form-group">
                <label for="email">Email: <sup class = "text-danger">*</sup></label>
                <input type="email" id="email" name="email" value="<?php echo $data_array['email'] ?>" placeholder="Enter your email" class="form-control form-control-lg <?php echo empty($data_array['email_err']) ? '' : 'is-invalid'; ?> ">
                <span class="invalid-feedback"><?php echo $data_array['email_err'] ?></span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <div class="form-group">
                <label for="password">Password: <sup class = "text-danger">*</sup></label>
                <input type="password" id="password" name="password" value="<?php echo $data_array['password'] ?>" placeholder="Enter your password" class="form-control form-control-lg <?php echo empty($data_array['password_err']) ? '' : 'is-invalid'; ?> ">
                <span class="invalid-feedback"><?php echo $data_array['password_err'] ?></span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <div class="form-group">
                <label for="confirm_password">Confirm Password: <sup class = "text-danger">*</sup></label>
                <input type="password" id="confirm_password" name="confirm_password" value="<?php echo $data_array['confirm_password'] ?>" placeholder="Re-enter your password" class="form-control form-control-lg <?php echo empty($data_array['confirm_password_err']) ? '' : 'is-invalid'; ?> ">
                <span class="invalid-feedback"><?php echo $data_array['confirm_password_err'] ?></span>
              </div>
            </div>
          </div>

          <div class="row mt-3">
            <div class="col">
              <div class="form-group">
                <input type="submit" value="Register" class="btn btn-success btn-block">
              </div>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col text-center">
              <div class="form-group">
                <label for="">Already have an account?</label>
                <a href="<?php echo URLROOT;?>/index.php?url=users/login" class="">Log In</a>
              </div>
            </div>
          </div>

        </form>

      </div>
    </div>
  </div>

<?php require APPROOT . '/views/_shared/references.php'; ?>

<?php require APPROOT . '/views/_shared/footer.php'; ?>