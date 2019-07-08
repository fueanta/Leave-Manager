<?php require APPROOT . '/views/_shared/header.php'; ?>

  <div class="row">
    <div class="col">
      <div class="col-md-7 mx-auto">

        <!-- pre-processing data -->
        <?php
          // pre-processing data
          $application_id = $data_array['application']->id;
          $employee_id = $data_array['application']->employee_id;
          // $application_status = $data_array['application']->{'Application Status'};
          // $supervisor_id = $data_array['application']->{'Supervisor Id'};
          // $delegate_id = $data_array['application']->{'Delegate Id'};
          // $declined_by = $data_array['application']->declined_by;
          $reason = $data_array['application']->{'Reason of Leave'};

          $application_date = $data_array['application']->Date;
          $from = $data_array['application']->From;
          $to = $data_array['application']->To;
          
          $date_diff = strtotime($to) - strtotime($from);
          $date_diff = round($date_diff / (60 * 60 * 24)) + 1; // holds the value of leave duration

          unset($data_array['application']->id);
          unset($data_array['application']->employee_id);
          unset($data_array['application']->{'Application Status'});
          unset($data_array['application']->{'Supervisor Id'});
          unset($data_array['application']->{'Delegate Id'});
          unset($data_array['application']->Date);
          unset($data_array['application']->declined_by);
          unset($data_array['application']->{'Reason of Leave'});

          $date_in_str = substr($data_array['application']->{'Date of Join'}, 0, 10);
          $data_array['application']->{'Date of Join'} = date('d-M-Y', strtotime($date_in_str));

          $date_in_str = substr($from, 0, 10);
          $data_array['application']->From = date('d-M-Y', strtotime($date_in_str));
          
          $date_in_str = substr($to, 0, 10);
          $data_array['application']->To = date('d-M-Y', strtotime($date_in_str));

          // RECLAIM PART -----------------------------------------------------------------------------||||||||||||

          $date_in_str = substr($data_array['reclaim']->from_date, 0, 10);
          $reclaim_from = date('d-M-Y', strtotime($date_in_str));

          $date_in_str = substr($data_array['reclaim']->to_date, 0, 10);
          $reclaim_to = date('d-M-Y', strtotime($date_in_str));

          $reclaiming_days = strtotime($data_array['reclaim']->to_date) - strtotime($data_array['reclaim']->from_date);
          $reclaiming_days = round($reclaiming_days / (60 * 60 * 24)) + 1; // holds the value of reclaiming days

          $reclaim_id = $data_array['reclaim']->id;
          $reclaim_status = $data_array['reclaim']->status;
          $supervisor_id = $data_array['reclaim']->supervisor_id;
        ?>

        <div class="table-responsive">
          <table class="table table-borderless border-left border-right border-bottom border-top">

            <thead class="thead-light border-bottom">
              <tr>
                <th scope="col" class="pb-2" style="width:50%;">
                  <h5>Reclaim Application</h5>
                </th>
                <th scope="col" class="pb-3">
                  <?php 
                    $date_in_str = substr($data_array['reclaim']->created_at, 0, 10);
                    echo 'Date: ' . date('d-M-Y', strtotime($date_in_str));
                  ?>
                </th>
              </tr>
            </thead>

            <tbody>

              <tr>
                <td>
                  <strong>From:</strong>
                </td>
                <td>
                  <?php echo $reclaim_from; ?>
                </td>
              </tr>

              <tr>
                <td>
                  <strong>To:</strong>
                </td>
                <td>
                  <?php echo $reclaim_to; ?>
                </td>
              </tr>

              <tr>
                <td>
                  <strong>Reclaimed:</strong>
                </td>
                <td>
                  <?php echo $reclaiming_days . ($reclaiming_days == 1 ? ' day' : ' days'); ?>
                </td>
              </tr>
            
            </tbody>

          </table>

        </div>

        <div class="table-responsive">
          <table class="table table-borderless border-left border-right border-bottom border-top">

            <thead class="thead-light border-bottom">
              <tr>
                <th scope="col" class="pb-2" style="width:50%;">
                  <h5>Leave Application</h5>
                </th>
                <th scope="col" class="pb-3">
                  <?php 
                    $date_in_str = substr($application_date, 0, 10);
                    echo 'Date: ' . date('d-M-Y', strtotime($date_in_str));
                  ?>
                </th>
              </tr>
            </thead>

            <tbody>

              <?php
                foreach ($data_array['application'] as $key => $value) {
                  echo '<tr ' . ($key == "Supervisor" ? 'class="border-bottom"' : '') . '><td><strong>' . $key . ':</strong></td><td>' . $value . '</td></tr>';
                }
              ?>

              <tr>
                <td>
                  <strong>Total:</strong>
                </td>
                <td>
                  <?php echo $date_diff . ($date_diff == 1 ? ' day' : ' days'); ?>
                  <?php if ($reclaim_status == "Accepted") { echo '(after reclaim)'; } ?>
                </td>
              </tr>

              <tr class="border-top border-bottom thead-light">
                <th colspan="2" scope="col" class="text-center">
                  <h5>Reason of Leave</h5>
                </th>
              </tr>
              <tr>
                <td colspan="2" class="text-center">
                  <?php echo $reason; ?>
                </td>
              </tr>
            
            </tbody>

          </table>

        </div>

        <!-- status -->

        <?php if ($reclaim_status == "Pending") : ?>
          
          <?php if ($employee_id == $_SESSION['user_id']) : ?>
            <div class="table-responsive">

              <table class="table table-borderless border-left border-right border-bottom border-top">
                <tr class="thead-light">
                  <th colspan="2" class="text-center border-bottom">
                    <h5>Update Reclaim Days</h5>
                  </th>
                </tr>
                <tr class="border-bottom">
                  <th class="text-center" scope="col"><label for="from">Reclaim From</label></th>
                  <th class="text-center" scope="col"><label for="days">Day(s)</label></th>
                </tr>
                <tr class="border-bottom">
                  <td class="text-center border-right pt-4" style="min-width:50%" scope="col">
                    <div class="form-group">
                      <select class="form-control" id="from" required="required">
                        <option value="" disabled selected>Select Deduction Point</option>
                        <option value="beginning" <?php echo (($from == $data_array['reclaim']->from_date) ? 'selected' : ''); ?> >From Beginning</option>
                        <option value="end" <?php echo (($to == $data_array['reclaim']->to_date) ? 'selected' : ''); ?> >From End</option>
                      </select>
                    </div>
                  </td>
                  <td class="text-center pt-4" scope="col">
                    <div class="form-group">
                      <input type="number" min="1" max="<?php echo $date_diff; ?>" value="<?php echo $reclaiming_days; ?>" class="form-control" id="days">
                    </div>
                  </td>
                </tr>
              </table>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <form action="<?php echo URLROOT; ?>/index.php?url=reclaims/modify_reclaim/" method="post">
                    <input type="hidden" name="reclaim_id" value="<?php echo $reclaim_id; ?>">
                    <input type="hidden" name="application_id" value="<?php echo $application_id; ?>">
                    <input type="hidden" name="supervisor_id" value="<?php echo $supervisor_id; ?>">
                    <input type="hidden" name="fromdate" value="<?php echo $from; ?>">
                    <input type="hidden" name="todate" value="<?php echo $to; ?>">
                    <input type="hidden" name="duration" value="<?php echo $date_diff; ?>">

                    <input type="hidden" id="hidden_from" name="from" value="">
                    <input type="hidden" id="hidden_days" name="days" value="">

                    <button type="submit" name="update_reclaim" class="btn btn-primary btn-block" onclick="confirmAction(this)">Update</button>
                  </form>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <form action="<?php echo URLROOT; ?>/index.php?url=reclaims/delete_reclaim/" method="post">
                    <input type="hidden" name="reclaim_id" value="<?php echo $reclaim_id; ?>">
                    <button type="submit" name="delete_reclaim" class="btn btn-danger btn-block" onclick="confirmDelete(this, 'reclaim application')">Delete</button>
                  </form>
                </div>
              </div>
            </div>
          <?php elseif ($supervisor_id == $_SESSION['user_id']) : ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <form action="<?php echo URLROOT; ?>/index.php?url=reclaims/process/" method="post">
                    <input type="hidden" name="reclaim_id" value="<?php echo $reclaim_id ?>">
                    <input type="hidden" name="application_id" value="<?php echo $application_id ?>">
                    <input type="hidden" name="application_from" value="<?php echo $from ?>">
                    <input type="hidden" name="application_to" value="<?php echo $to ?>">
                    <input type="hidden" name="reclaim_from" value="<?php echo $data_array['reclaim']->from_date ?>">
                    <input type="hidden" name="reclaim_to" value="<?php echo $data_array['reclaim']->to_date ?>">
                    <input type="hidden" name="application_days" value="<?php echo $date_diff ?>">
                    <input type="hidden" name="reclaim_days" value="<?php echo $reclaiming_days ?>">
                    <input type="hidden" name="accepted">
                    <button type="submit" class="btn btn-success btn-block" onclick="confirmAction(this, 'the applicant');">Accept</button>
                  </form>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <form action="<?php echo URLROOT; ?>/index.php?url=reclaims/process/" method="post">
                    <input type="hidden" name="reclaim_id" value="<?php echo $reclaim_id ?>">
                    <input type="hidden" name="application_id" value="<?php echo $application_id ?>">
                    <input type="hidden" name="declined">
                    <button type="submit" class="btn btn-danger btn-block" onclick="confirmAction(this, 'the applicant');">Decline</button>
                  </form>
                </div>
              </div>
            </div>
          <?php endif; ?>

        <?php elseif ($reclaim_status == "Declined") : ?>
          <div class="table-responsive">
            <table class="table table-borderless border-left border-right border-bottom border-top">
              <tr class="thead-light">
                <th colspan="4" class="text-center border-bottom">
                  <h5>Reclaim Status</h5>
                </th>
              </tr>
              <tr class="border-bottom">
                <td colspan="4" class="text-center">
                  <strong class="text-danger">This application has already been declined.</strong>
                </td>
              </tr>
            </table>
          </div>
        <?php elseif ($reclaim_status == "Accepted") : ?>
          <div class="table-responsive">
            <table class="table table-borderless border-bottom border-top border-left border-right">
              <tr class="thead-light">
                <th colspan="4" class="text-center border-bottom">
                  <h5>Reclaim Status</h5>
                </th>
              </tr>
              <tr>
                <td colspan="4" class="text-center">
                  <strong class="text-success">This application has already been accepted.</strong>
                </td>
              </td>
            </table>
          </div>
        <?php endif; ?>

      </div>
    </div>
    
  </div>

    <?php require APPROOT . '/views/_shared/references.php'; ?>

  <?php require APPROOT . '/views/reclaims/reclaim_form_script.php'; ?>

<?php require APPROOT . '/views/_shared/footer.php'; ?>