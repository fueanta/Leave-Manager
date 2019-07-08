<?php require APPROOT . '/views/_shared/header.php'; ?>

  <div class="row">
    <div class="col-md-5 mx-auto">

      <div class="card card-body bg-light mt-2 mb-4">
        
        <!-- flash messages -->
        <?php flash('registration_verification'); ?>
        <?php flash('invalid_credentials'); ?>
        <?php flash('not_verified'); ?>
        <?php flash('unauthorized_access'); ?>
        <?php flash('login_required'); ?>
        <?php flash('password_updated'); ?>
        <?php flash('page_not_found'); ?>

        <h3 class="card-title">Log In</h3>
        <small class="text-muted mb-3">Please fill in your credentials to log in.</small>
        
        <form method="post" action="<?php echo URLROOT; ?>/index.php?url=users/login">
          
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

          <div class="row mt-3">
            <div class="col">
              <div class="form-group">
                <input type="submit" value="Log In" class="btn btn-success btn-block">
              </div>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col text-center">
              <div class="form-group">
                <label for="">Forgot your password?</label>
                <a href="<?php echo URLROOT;?>/index.php?url=users/reset" class="">Reset</a>
              </div>
            </div>
          </div>

        </form>

      </div>
    </div>
  </div>

<?php require APPROOT . '/views/_shared/references.php'; ?>

<?php require APPROOT . '/views/_shared/footer.php'; ?>