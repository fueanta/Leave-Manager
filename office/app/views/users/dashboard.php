<?php require APPROOT . '/views/_shared/header.php'; ?>

  <div class="row">
    <div class="col-md-8 mx-auto">
      <div class="table-responsive">
      
        <?php flash('unauthorized_access'); ?>
        <?php flash('page_not_found'); ?>

        <table class="table table-borderless border-top border-left border-right border-bottom mt-4">
          <tr class="bg-light text-dark border-bottom">
            <th colspan="4" class="text-center">
              <h5>Your Leave Status</h5>
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

      <form action="<?php echo URLROOT; ?>/index.php?url=users/dashboard" method="post">
        <div class="table-responsive">

          <table class="table table-borderless border-top border-left border-right border-bottom mt-4">
            <tr class="bg-light text-dark border-bottom">
              <th colspan="2" class="text-center">
                <h5>Search for Employees in Leave</h5>
              </th>
            </tr>
            <tr class="border-bottom">
              <th class="text-center" scope="col"><label for="fromdate">From</label></th>
              <th class="text-center" scope="col"><label for="todate">To</label></th>
            </tr>
            <tr class="border-bottom">
              <td class="text-center border-right pt-4" style="min-width:50%" scope="col">
                <div class="form-group">
                  <input type="date" name="fromdate" class="form-control" value="<?php echo $data_array['from'] ?>" id="fromdate">
                </div>
              </td>
              <td class="text-center pt-4" scope="col">
                <div class="form-group">
                  <input type="date" name="todate" class="form-control" value="<?php echo $data_array['to'] ?>" id="todate">
                </div>
              </td>
            </tr>
          </table>
        </div>

        <div class="row justify-content-center">

          <input type="hidden" name="submit_type" value="post">

          <div class="col-md-4">
            <div class="form-group">
              <button type="submit" name="search" class="btn btn-success btn-block">Search</button>
            </div>
          </div>
        </div>
      </form>

      <?php
        if( isset( $data_array['absenceList'] ) ):
       ?>

        <table id="employee-list" class="table table-borderless border-top border-left border-right border-bottom mt-3 mb-5">

      <?php
          if ( count( $data_array['absenceList'] ) > 0 ):
       ?>

          <tr class="border-bottom">
            <th class="text-center" scope="col">ID</th>
            <th class="text-center" scope="col">Name</th>
            <th class="text-center" scope="col">From</th>
            <th class="text-center" scope="col">To</th>
          </tr>

          <?php
            foreach ($data_array['absenceList'] as $record) {
              echo '<tr><td class="text-center">' . $record->employee_code . '</td><td class="text-center">' . $record->name . '</td><td class="text-center">' . $record->from_date . '</td><td class="text-center">' . $record->to_date . '</td></tr>';
            }
          ?>

      <?php
          else:
       ?>

          <tr>
            <th colspan="4" class="text-center">No data has been found 😥</th>
          </tr>

        <?php
          endif;
        ?>

        </table>

        <script>
          window.scrollTo(0,document.body.scrollHeight);
        </script>

      <?php
        endif;
      ?>

    </div>
  </div>
  
  <?php require APPROOT . '/views/_shared/references.php'; ?>

<?php require APPROOT . '/views/_shared/footer.php'; ?>