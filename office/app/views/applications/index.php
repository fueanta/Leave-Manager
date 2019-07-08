<?php require APPROOT . '/views/_shared/header.php'; ?>

  <div class="row">
    <div class="col">
      <?php flash('posted_application'); ?>
      <?php flash('deleted_application'); ?>
      <?php flash('updated_application'); ?>
      <?php flash('processed_application'); ?>
      <?php flash('unauthorized_application_access'); ?>
      <div class="card card-body mt-4">
        <h3 class="card-title">Your Applications</h3>
        <hr>
        <div class="row mt-2 mb-3">
          <div class="col">
            <a href="<?php echo URLROOT; ?>/index.php?url=applications/application_form/" class="btn btn-primary">Apply for a Leave</a>
          </div>
        </div>

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

      <div class="card card-body mt-4">
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
              <!-- <th scope="col">Delegate:</th> -->
              <th scope="col" style="max-width: 8%;"></th>
            </tr>
          </thead>

        </table>
        
        <hr>

      </div>

      <div class="card card-body mt-4 mb-5">
        <h3 class="card-title">Delegate | Inbox</h3>
        <hr>

        <table id="delegate_inbox" class="table table-bordered dt-responsive nowrap" style="width:100%">
          
          <thead class="thead-light">
            <tr>
              <th scope="col">#ref:</th>
              <th scope="col">Type of Leave:</th>
              <th scope="col">Applicant:</th>
              <th scope="col">From:</th>
              <th scope="col">To:</th>
              <th scope="col">Status:</th>
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
<?php require APPROOT . '/views/applications/supervisor_inbox.php'; ?>
<?php require APPROOT . '/views/applications/delegate_inbox.php'; ?>

<?php require APPROOT . '/views/_shared/footer.php'; ?>