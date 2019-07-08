<?php require APPROOT . '/views/_shared/header.php'; ?>

  <div class="row">
    <div class="col">

      <div class="jumbotron jumbotron-fluid text-center border-top border-bottom border-left border-right mt-3">
        <div class="container">
          <h4 class="display-4"><?php echo $data_array['employee']->name; ?></h4>
          <p class="lead"><?php echo $data_array['employee']->designation . ', ' . $data_array['employee']->company; ?></p>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-borderless border-top border-left border-right border-bottom">
          <tr class="thead-light border-bottom">
            <th colspan="4" class="text-center">
              <h5>Leave Status</h5>
            </th>
          </tr>
          <tr>
            <th class="text-center" scope="col">Leave Title</th>
            <th class="text-center" scope="col">Leave Days</th>
            <th class="text-center" scope="col">Spent Leaves</th>
            <th class="text-center" scope="col">Balance</th>
          </tr>

          <?php 
            foreach ($data_array['leaveStatus'] as $status) {
              echo '<tr><td class="text-center">' . $status->{'Leave Title'} . '</td><td class="text-center">' . $status->{'Leave Days'} . '</td><td class="text-center">' . $status->{'Spent Leave'} . '</td><td class="text-center">' . $status->{'Balance'} . '</td></tr>';
            }
          ?>
        </table>
      </div>

      <div class="card card-body mt-4">
        <h3 class="card-title">Applications</h3>
        <hr>

        <table id="applied_applications" class="table table-bordered dt-responsive nowrap" style="width:100%">
          
          <thead class="thead-light">
            <tr>
              <th scope="col">#ref:</th>
              <th scope="col">Type of Leave:</th>
              <th scope="col">From:</th>
              <th scope="col">To:</th>
              <th scope="col">Status:</th>
              <th scope="col">Delegate:</th>
              <th scope="col" style="max-width: 8%;"></th>
            </tr>
          </thead>

        </table>
        
        <hr>

      </div>

      <div class="card card-body mt-4 mb-5">
        <h3 class="card-title">Reclaims</h3>
        <hr>

        <table id="applied_reclaims" class="table table-bordered dt-responsive nowrap" style="width:100%">
          
          <thead class="thead-light">
            <tr>
              <th scope="col">#ref:</th>
              <th scope="col">Type of Leave:</th>
              <th scope="col">From:</th>
              <th scope="col">To:</th>
              <th scope="col">Status:</th>
              <th scope="col">Applied On:</th>
              <th scope="col" style="max-width: 8%;"></th>
            </tr>
          </thead>

        </table>
        
        <hr>

      </div>

    </div>
  </div>

  <?php require APPROOT . '/views/_shared/references.php'; ?>

<!-- script for data table -->
<?php require APPROOT . '/views/applications/applied_applications.php'; ?>
<?php require APPROOT . '/views/reclaims/applied_reclaims.php'; ?>

<?php require APPROOT . '/views/_shared/footer.php'; ?>