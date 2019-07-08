<?php require APPROOT . '/views/_shared/header.php'; ?>

  <div class="row">
    <div class="col-md-9 mx-auto">
      <div class="card card-body bg-light mt-2 mb-4">

        <h4 class="card-title">Employee Information</h4>

        <?php if ($data_array['submit_type'] == 'POST') : ?>
          <small class="text-muted mb-3">Please fill out this form to verify employee registration.</small>
        <?php else : ?>
          <small class="text-muted mb-3">Please modify enabled field(s) only if required.</small>
        <?php endif; ?>
        
        <form action="<?php echo URLROOT; ?>/index.php?url=hr/entry/" method="post">

          <input type="hidden" name="id" value="<?php echo $data_array['id'] ?>">

          <div class="row">
            <div class="col-md-6 col-xs-12">
              <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" class="form-control" id="name" value="<?php echo $data_array['name'] ?>" disabled>
              </div>
            </div>

            <div class="col-md-6 col-xs-12">
              <div class="form-group">
                <label for="gender">Gender: <sup class="text-danger">*</sup></label>
                <select class="form-control" name="gender" id="gender" required="required">
                  <option value="" disabled <?php if (empty($data_array['gender'])) echo 'selected'; ?> >Select Gender</option>
                  <option value="Female" <?php if ($data_array['gender'] == "Female") echo 'selected'; ?> >Female</option>
                  <option value="Male" <?php if ($data_array['gender'] == "Male") echo 'selected'; ?> >Male</option>
                  <option value="Other" <?php if ($data_array['gender'] == "Other") echo 'selected'; ?> >Other</option>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 col-xs-12">
              <div class="form-group">
                <label for="mobile">Mobile No:</label>
                <input type="text" name="mobile" class="form-control" id="mobile" value="<?php echo $data_array['mobile'] ?>">
              </div>
            </div>

            <div class="col-md-6 col-xs-12">
              <div class="form-group">
                <label for="email">Email:</label>
                <input name="email" class="form-control" value="<?php echo $data_array['email'] ?>" disabled>
              </div>
            </div>
            
          </div>

          <div class="row">
            <div class="col-md-6 col-xs-12">
              <div class="form-group">
                <label for="emergency_contact">Emergency Contact:</label>
                <input type="text" name="emergency_contact" class="form-control" id="emergency_contact" value="<?php echo $data_array['emergency_contact'] ?>">
              </div>
            </div>
            
            <div class="col-md-6 col-xs-12">
              <div class="form-group">
                <label for="blood_group">Blood Group:</label>
                <input type="text" name="blood_group" class="form-control" id="blood_group" value="<?php echo $data_array['blood_group'] ?>">
              </div>
            </div>                
          </div>

          <div class="row">
            <div class="col-md-6 col-xs-12">
              <div class="form-group">
                <label for="company">Company: <sup class="text-danger">*</sup></label>
                <select class="form-control" name="company" id="company" required="required">

                <?php if (empty($data_array['company'])) : ?>
                  <option value="" disabled selected>Select Company</option>
                  <?php foreach ($data_array['companies'] as $company) : ?>
                    <option value="<?php echo $company->id ?>"><?php echo $company->name ?></option>
                  <?php endforeach; ?>

                <?php else : ?>
                  <option value="" disabled>Select Company</option>
                  <?php foreach ($data_array['companies'] as $company) : ?>
                    <option value="<?php echo $company->id ?>" <?php if ($data_array['company'] == $company->name) echo 'selected'; ?> ><?php echo $company->name ?></option>
                  <?php endforeach; ?>

                <?php endif; ?>

                </select>
              </div>
            </div>
            
            <div class="col-md-6 col-xs-12">
              <div class="form-group">
              <label for="dept">Department: <sup class="text-danger">*</sup></label>
                <select class="form-control" name="department" id="department" required="required">

                  <?php if (empty($data_array['department'])) : ?>
                    <option value="" disabled selected>Select Department</option>
                    <?php foreach ($data_array['departments'] as $department) : ?>
                      <option value="<?php echo $department->id ?>"><?php echo $department->name ?></option>
                    <?php endforeach; ?>

                  <?php else : ?>
                    <option value="" disabled>Select Department</option>
                    <?php foreach ($data_array['departments'] as $department) : ?>
                      <option value="<?php echo $department->id ?>" <?php if ($data_array['department'] == $department->name) echo 'selected'; ?> ><?php echo $department->name ?></option>
                    <?php endforeach; ?>

                  <?php endif; ?>

                </select>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6 col-xs-12">
              <div class="form-group">
                <label for="designation">Designation: <sup class="text-danger">*</sup></label>
                <input type="text" name="designation" class="form-control" id="designation" value="<?php echo $data_array['designation'] ?>" required="required">
              </div>
            </div>
            <div class="col-md-6 col-xs-12">
              <div class="form-group">
                <label for="supervisor">Supervisor: <sup class="text-danger">*</sup></label>
                <select class="form-control" name="supervisor" id="supervisor" required="required">

                  <?php if (empty($data_array['supervisor'])) : ?>
                    <option value="" disabled selected>Select Supervisor</option>
                    <?php foreach ($data_array['supervisors'] as $supervisor) : ?>
                      <option value="<?php echo $supervisor->id ?>"><?php echo $supervisor->name ?></option>
                    <?php endforeach; ?>

                  <?php else : ?>
                    <option value="" disabled>Select Supervisor</option>
                    <?php foreach ($data_array['supervisors'] as $supervisor) : ?>
                      <option value="<?php echo $supervisor->id ?>" <?php if ($data_array['supervisor'] == $supervisor->name) echo 'selected'; ?> ><?php echo $supervisor->name ?></option>
                    <?php endforeach; ?>

                  <?php endif; ?>

                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 col-xs-12">
              <div class="form-group">
                <label for="doj">Date of Join: <sup class="text-danger">*</sup></label>
                <input type="date" name="doj" class="form-control" value="<?php echo $data_array['joining_date'] ?>" id="doj" required="required">
              </div>
            </div>

            <div class="col-md-6 col-xs-12">
              <div class="form-group">
                <label for="employee_code">Employee Code: <sup class="text-danger">*</sup></label>
                <input type="text" name="employee_code" class="form-control" id="employee_code" value="<?php echo $data_array['employee_code'] ?>" required="required">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 col-xs-12">
              <div class="form-group">
                <label for="type">Account Type: <sup class="text-danger">*</sup></label>
                <select class="form-control" name="type" id="type" required="required">
                  <option value="" disabled <?php if (empty($data_array['type'])) echo 'selected'; ?> >Select Account Type</option>
                  <option value="HR" <?php if ($data_array['type'] == "HR") echo 'selected'; ?> >HR Employee</option>
                  <option value="Employee" <?php if ($data_array['type'] == "Employee") echo 'selected'; ?> >Regular Employee</option>
                </select>
              </div>
            </div>

            <div class="col-md-6 col-xs-12">
              <div class="form-group">
                <label for="status">Status: <sup class="text-danger">*</sup></label>
                <select class="form-control" name="status" id="status" required="required">
                  <option value="" disabled <?php if (empty($data_array['status'])) echo 'selected'; ?> >Select Status</option>
                  <option value="Active" <?php if ($data_array['status'] == "Active") echo 'selected'; ?> >Active</option>
                  <option value="Suspended" <?php if ($data_array['status'] == "Suspended") echo 'selected'; ?> >Suspended</option>
                  <option value="Terminated" <?php if ($data_array['status'] == "Terminated") echo 'selected'; ?> >Terminated</option>
                </select>
              </div>
            </div>
          </div>

          <input type="hidden" name="submit_type" value="<?php echo $data_array['submit_type'] ?>">

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