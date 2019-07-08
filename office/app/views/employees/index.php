<?php require APPROOT . '/views/_shared/header.php'; ?>

<div class="row">
    <div class="col">

      <?php flash('posted_employee'); ?>
      <?php flash('updated_employee'); ?>

      <div class="card card-body bg-light mt-4 mb-4">

        <h3 class="card-title mb-4">Employees</h3>
        <table id="employee" class="table table-bordered dt-responsive nowrap" style="width:100%">
          <thead class="thead-light">
            <tr>
              <th scope="col">ID:</th>
              <th scope="col">Name:</th>
              <th scope="col">Gender:</th>
              <th scope="col">Contact:</th>
              <th scope="col">Email:</th>
              <th scope="col">Emergency Contact:</th>
              <th scope="col">Blood Group:</th>
              <th scope="col">Company:</th>
              <th scope="col">Department:</th>
              <th scope="col">Designation:</th>
              <th scope="col">Supervisor:</th>
              <th scope="col">Type:</th>
              <th scope="col">Joining Date:</th>
              <th scope="col">Staus:</th>
              <th scope="col"></th>
            </tr>
          </thead>
        </table>
        
        <hr>

      </div>
    </div>
  </div>

<?php require APPROOT . '/views/_shared/references.php'; ?>

<!-- script for data table -->
<?php require APPROOT . '/views/employees/employees.php'; ?>

<?php require APPROOT . '/views/_shared/footer.php'; ?>