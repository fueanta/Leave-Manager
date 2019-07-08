<?php require APPROOT . '/views/_shared/header.php'; ?>

  <div class="row">
    <div class="col-md-7 mx-auto">

      <div class="card card-body bg-light mt-2 mb-4">

        <div class="row">
        
        </div>
        <h3 class="card-title">Account Information</h3>
        <small class="text-muted mb-4">Please change your personal information only if required.</small>
        
        <form method="post" action="<?php echo URLROOT; ?>/index.php?url=users/post_update_form/">
          
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label for="name">Name: <sup class = "text-danger">*</sup></label>
                <input type="text" id="name" name="name" value="<?php echo $data_array['name'] ?>" placeholder="Enter your name" class="form-control form-control-lg <?php echo empty($data_array['name_err']) ? '' : 'is-invalid'; ?> ">
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
                <label for="mobile">Mobile: <sup class = "text-danger">*</sup></label>
                <input type="text" id="mobile" name="mobile" value="<?php echo $data_array['mobile'] ?>" placeholder="Enter your mobile no." class="form-control form-control-lg <?php echo empty($data_array['mobile_err']) ? '' : 'is-invalid'; ?> ">
                <span class="invalid-feedback"><?php echo $data_array['mobile_err'] ?></span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <div class="form-group">
                <label for="emergency_contact">Emergency Contact: <sup class = "text-danger">*</sup></label>
                <input type="text" id="emergency_contact" name="emergency_contact" value="<?php echo $data_array['emergency_contact'] ?>" placeholder="Enter your emergency contact" class="form-control form-control-lg <?php echo empty($data_array['emergency_contact_err']) ? '' : 'is-invalid'; ?> ">
                <span class="invalid-feedback"><?php echo $data_array['emergency_contact_err'] ?></span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <div class="form-group">
                <label for="blood_group">Blood Group: <sup class = "text-danger">*</sup></label>
                <input type="text" id="blood_group" name="blood_group" value="<?php echo $data_array['blood_group'] ?>" placeholder="Enter your blood group" class="form-control form-control-lg <?php echo empty($data_array['blood_group_err']) ? '' : 'is-invalid'; ?> ">
                <span class="invalid-feedback"><?php echo $data_array['blood_group_err'] ?></span>
              </div>
            </div>
          </div>

          <input type="hidden" name="id" value="<?php echo $data_array['id'] ?>">

          <div class="row mt-3">
            <div class="col">
              <div class="form-group">
                <!-- <input type="submit" value="Save" class="btn btn-success btn-block"> -->
                <button class="btn btn-success btn-block" type="submit">Save</button>
              </div>
            </div>
          </div>

        </form>

      </div>
    </div>
  </div>

<?php require APPROOT . '/views/_shared/references.php'; ?>

<?php require APPROOT . '/views/_shared/footer.php'; ?>