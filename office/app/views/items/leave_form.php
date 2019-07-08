<?php require APPROOT . '/views/_shared/header.php'; ?>

  <div class="row">
    <div class="col-md-6 mx-auto">
      <div class="card card-body bg-light mt-3 mb-5">
        
        <h3 class="card-title">Leave Details</h3>
        <small class="text-muted mb-3">Please fill out the form as mentioned.</small>

        <div class="mt-2"></div>
        
        <form action="<?php echo URLROOT; ?>/index.php?url=items/leave_submit/" method="post">

          <input type="hidden" name="id" value="<?php echo $data_array['id'] ?>">

          <div class="row">
            <div class="col-md-12 col-xs-12">
              <div class="form-group">
                <label for="name">Name: <sup class="text-danger">*</sup></label>
                <input type="text" name="name" class="form-control" required="required" id="name" value="<?php echo $data_array['name'] ?>">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 col-xs-12">
              <div class="form-group">
                <label for="description">Type: <sup class="text-danger">*</sup></label>
                <select class="form-control" name="description" id="description" required="required">
                  <option value="" disabled <?php if (empty($data_array['description'])) { echo 'selected'; } ?>>Select Type</option>
                  <option value="Pre" <?php if ($data_array['description'] == "Pre") { echo 'selected'; } ?>>Pre Leave</option>
                  <option value="Post" <?php if ($data_array['description'] == "Post") { echo 'selected'; } ?>>Post Leave</option>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 col-xs-12">
              <div class="form-group">
                <label for="eligible_after">Eligible After: <sup class="text-danger">*</sup></label>
                <div class="input-group mb-3">
                  <input type="number" min="0" max="12" name="eligible_after" class="form-control" required="required" id="eligible_after" value="<?php echo $data_array['eligible_after'] ?>">
                  <div class="input-group-append">
                    <span class="input-group-text">month(s)</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 col-xs-12">
              <div class="form-group">
                <label for="document_required_after">Document(s) Required After: <sup class="text-danger">*</sup></label>
                <div class="input-group mb-3">
                  <input type="number" min="0" name="document_required_after" class="form-control" required="required" id="document_required_after" value="<?php echo $data_array['document_required_after'] ?>">
                  <div class="input-group-append">
                  <span class="input-group-text pl-4 pr-4">day(s)</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 col-xs-12">
              <div class="form-group">
                <label for="annual_balance">Total Balance: <sup class="text-danger">*</sup></label>
                <div class="input-group mb-3">
                <input type="number" min="0" name="annual_balance" class="form-control" required="required" id="annual_balance" value="<?php echo $data_array['annual_balance'] ?>">
                  <div class="input-group-append">
                    <span class="input-group-text pl-4 pr-4">day(s)</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 col-xs-12">
              <div class="form-group">
                <label for="annual_balance">Renewal Period: <sup class="text-danger">*</sup></label>
                <select class="form-control" name="renewal_period" id="renewal_period" required="required">

                <?php if (empty($data_array['renewal_period'])) : ?>
                  <option value="" disabled selected>Select Renewal Period</option>
                  <?php foreach ($data_array['renewal_periods'] as $renewal_period) : ?>
                    <option value="<?php echo $renewal_period; ?>"><?php echo $renewal_period; ?></option>
                  <?php endforeach; ?>

                <?php else : ?>
                  <option value="" disabled>Select Renewal Period</option>
                  <?php foreach ($data_array['renewal_periods'] as $renewal_period) : ?>
                    <option value="<?php echo $renewal_period; ?>" <?php if ($data_array['renewal_period'] == $renewal_period) echo 'selected'; ?> ><?php echo $renewal_period; ?></option>
                  <?php endforeach; ?>

                <?php endif; ?>

                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 col-xs-12">
              <div class="form-group">
                <label for="gender_dependency">Gender Dependency: <sup class="text-danger">*</sup></label>
                <select class="form-control" name="gender_dependency" id="gender_dependency" required="required">

                <?php if (empty($data_array['gender_dependency'])) : ?>
                  <option value="" disabled selected>Select Gender Dependency</option>
                  <?php foreach ($data_array['gender_dependencies'] as $gender_dependency) : ?>
                    <option value="<?php echo $gender_dependency; ?>"><?php echo $gender_dependency; ?></option>
                  <?php endforeach; ?>

                <?php else : ?>
                  <option value="" disabled>Select Gender Dependency</option>
                  <?php foreach ($data_array['gender_dependencies'] as $gender_dependency) : ?>
                    <option value="<?php echo $gender_dependency; ?>" <?php if ($data_array['gender_dependency'] == $gender_dependency) echo 'selected'; ?> ><?php echo $gender_dependency ?></option>
                  <?php endforeach; ?>

                <?php endif; ?>

                </select>
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