<?php require APPROOT . '/views/_shared/header.php'; ?>

  <div class="row">
    <div class="col">
      <?php flash('posted_reclaim'); ?>
      <?php flash('updated_reclaim'); ?>
      <?php flash('deleted_reclaim'); ?>

      <?php flash('processed_reclaim'); ?>
      <?php flash('unauthorized_application_access'); ?>

      <div class="card card-body mt-4">
        <h3 class="card-title">Your Reclaims</h3>
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

      <div class="card card-body mt-4 mb-5">
        <h3 class="card-title">Supervisor | Inbox</h3>
        <hr>

        <table id="supervisor_inbox" class="table table-bordered dt-responsive nowrap" style="width:100%">
          
          <thead class="thead-light">
            <tr>
              <th scope="col">#ref:</th>
              <th scope="col">Type of Leave:</th>
              <th scope="col">Applicant:</th>
              <th scope="col">From:</th>
              <th scope="col">To:</th>
              <th scope="col">Status:</th>
              <!-- <th scope="col">Applied On:</th> -->
              <th scope="col" style="max-width: 8%;"></th>
            </tr>
          </thead>

        </table>
        
        <hr>

      </div>

    </div>
  </div>

  <?php require APPROOT . '/views/_shared/references.php'; ?>

<!-- scripts for data tables -->
<?php require APPROOT . '/views/reclaims/applied_reclaims.php'; ?>
<?php require APPROOT . '/views/reclaims/supervisor_inbox.php'; ?>

<?php require APPROOT . '/views/_shared/footer.php'; ?>