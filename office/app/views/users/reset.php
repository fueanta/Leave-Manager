<?php require APPROOT . '/views/_shared/header.php'; ?>

  <div class="row">
    <div class="col-md-5 mx-auto">

      <div class="card card-body bg-light mt-2">
        
        <!-- flash messages -->
        <?php flash('email_sent'); ?>

        <h4 class="card-title">Reset Password</h4>
        <small class="text-muted mb-3">Please, provide your registered email address to reset your password.</small>
        
        <form method="post" action="<?php echo URLROOT; ?>/index.php?url=users/reset" onsubmit="sendingMail('you');">
          
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label for="email">Email: <sup class = "text-danger">*</sup></label>
                <input required="required" type="email" id="email" name="email" value="<?php echo $data_array['email'] ?>" placeholder="Enter your email" class="form-control form-control-lg <?php echo empty($data_array['email_err']) ? '' : 'is-invalid'; ?> ">
                <span class="invalid-feedback"><?php echo $data_array['email_err'] ?></span>
              </div>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col">
              <div class="form-group">
                <input type="submit" value="Send" class="btn btn-success btn-block">
              </div>
            </div>
          </div>

        </form>

      </div>
    </div>
  </div>

  <?php require APPROOT . '/views/_shared/references.php'; ?>

<?php require APPROOT . '/views/_shared/footer.php'; ?>