<?php require APPROOT . '/views/_shared/header.php'; ?>

  <div class="row">
    <div class="col">
      <div class="col-md-7 mx-auto">

        <!-- pre-processing data -->
        <?php
          // pre-processing data
          $application_id = $data_array['application']->id;
          $employee_id = $data_array['application']->employee_id;
          $application_status = $data_array['application']->{'Application Status'};
          $supervisor_id = $data_array['application']->{'Supervisor Id'};
          $delegate_id = $data_array['application']->{'Delegate Id'};
          $declined_by = $data_array['application']->declined_by;
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

          if ($data_array['reclaim'] != null) {
            $date_in_str = substr($data_array['reclaim']->from_date, 0, 10);
            $reclaim_from = date('d-M-Y', strtotime($date_in_str));

            $date_in_str = substr($data_array['reclaim']->to_date, 0, 10);
            $reclaim_to = date('d-M-Y', strtotime($date_in_str));

            $reclaiming_days = strtotime($data_array['reclaim']->to_date) - strtotime($data_array['reclaim']->from_date);
            $reclaiming_days = round($reclaiming_days / (60 * 60 * 24)) + 1; // holds the value of reclaiming days

            $reclaim_id = $data_array['reclaim']->id;
            $reclaim_status = $data_array['reclaim']->status;
            $supervisor_id = $data_array['reclaim']->supervisor_id;
          }
        ?>

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
                </td>
              </tr>

              <!-- Reason of Leave -->

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

        <!-- documents / attachments -->

        <div class="table-responsive">
          <table class="table table-borderless border-left border-right border-bottom border-top">
            <tr class="thead-light border-bottom">
              <th colspan="5" class="text-center">
                <h5>Supporting Documents</h5>
              </th>
            </tr>
            <tr class="border-bottom">
              <?php if( count( $data_array['documents'] ) == 0 ) : ?>
                <td colspan="5" class="text-center" scope="col">
                  <strong class="text-info">No supporting document is available.</strong>
                </td>
              <?php else : ?>
                <?php $i = 1; foreach( $data_array['documents'] as $document ) : ?>
                  <td class="text-center" scope="col">
                    <a style="text-decoration: none;" class="text-info" href="<?php echo URLROOT; ?>/app/_uploads/<?php echo $document->document_name; ?>" download>
                      <?php
                        // $fileNameParts = explode( '.', $document->document_name );
                        // $fileExt = strtolower( end( $fileNameParts ) );
                        echo 'Document - ' . $i++;
                       ?>
                    </a>
                  </td>
                <?php endforeach; ?>
              <?php endif; ?>
            </tr>
          </table>
        </div>

        <div class="table-responsive">

          <?php if ( ($supervisor_id == $_SESSION['user_id'] || $employee_id == $_SESSION['user_id']) && $application_status != 'Pending' ) : ?>
            <table class="table table-borderless border-left border-right border-bottom border-top">
              <tr class="thead-light border-bottom">
                <th colspan="4" class="text-center">
                  <h5>Leave Status</h5>
                </th>
              </tr>
              <tr class="border-bottom">
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
          <?php endif; ?>

        </div>

        <?php if ($application_status == 'Pending') : ?>

          <?php if ($delegate_id == $_SESSION['user_id']) : ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">

                  <form action="<?php echo URLROOT; ?>/index.php?url=applications/process/" method="post">
                    <input type="hidden" name="application_id" value="<?php echo $application_id ?>">
                    <input type="hidden" name="delegated" value="">
                    <button type="submit" class="btn btn-success btn-block" onclick="confirmAction(this, sendMailTo = 'the supervisor');">Accept</button>
                  </form>

                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">

                  <form action="<?php echo URLROOT; ?>/index.php?url=applications/process/" method="post">
                    <input type="hidden" name="application_id" value="<?php echo $application_id ?>">
                    <input type="hidden" name="declinedByDelegate" value="">
                    <button type="submit" class="btn btn-danger btn-block" onclick="confirmAction(this, sendMailTo = 'the applicant');">Decline</button>
                  </form>

                </div>
              </div>
            </div>
          
          <?php elseif ($employee_id == $_SESSION['user_id']) : ?>
            <div class="table-responsive">
              <table class="table table-borderless border-left border-right border-bottom border-top">
                <tr class="thead-light border-bottom">
                  <th colspan="4" class="text-center">
                    <h5>Application Status</h5>
                  </th>
                </tr>
                <tr class="border-bottom">
                  <td class="text-center" colspan="4">
                    <strong class="text-info">This application is yet to be verified by the delegate.</strong>
                  </td>
                </tr>
              </table>
            </div>

            <div class="row">
              <div class="col-md-6">
                <form action="<?php echo URLROOT; ?>/index.php?url=applications/application_form/" method="post">
                  <div class="form-group">
                    <input type="hidden" name="application_id" value="<?php echo $application_id ?>">
                    <button type="submit" name="modify" class="btn btn-primary btn-block">Modify</button>
                  </div>
                </form>
              </div>
              <div class="col-md-6">
                <form action="<?php echo URLROOT; ?>/index.php?url=applications/delete_application_form/" method="post">
                  <div class="form-group">
                    <input type="hidden" name="application_id" value="<?php echo $application_id ?>">
                    <button type="submit" name="delete" class="btn btn-danger btn-block" onclick="confirmDelete(this, 'application');">Delete</button>
                  </div>
                  </form>
              </div>
            </div>

          <?php else: ?>

            <div class="table-responsive">
              <table class="table table-borderless border-left border-right border-bottom border-top">
                <tr class="thead-light border-bottom">
                  <th colspan="4" class="text-center">
                    <h5>Application Status</h5>
                  </th>
                </tr>
                <tr class="border-bottom">
                  <td class="text-center" colspan="4">
                    <strong class="text-info">This application is yet to be verified by the delegate.</strong>
                  </td>
                </tr>
              </table>
            </div>

          <?php endif; ?>

        <?php elseif ($application_status == 'Delegated'): ?>
          <?php if ($supervisor_id == $_SESSION['user_id']) : ?>
            <div class="row">
              <input type="hidden" name="application_id" value="<?php echo $application_id ?>">
              <div class="col-md-6">
                <div class="form-group">

                  <form action="<?php echo URLROOT; ?>/index.php?url=applications/process/" method="post">
                    <input type="hidden" name="application_id" value="<?php echo $application_id ?>">
                    <input type="hidden" name="accepted" value="">
                    <button type="submit" class="btn btn-success btn-block" onclick="confirmAction(this, sendMailTo = 'the applicant');">Accept</button>
                  </form>

                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">

                  <form action="<?php echo URLROOT; ?>/index.php?url=applications/process/" method="post">
                    <input type="hidden" name="application_id" value="<?php echo $application_id ?>">
                    <input type="hidden" name="declinedBySupervisor" value="">
                    <button type="submit" class="btn btn-danger btn-block" onclick="confirmAction(this, sendMailTo = 'the applicant');">Decline</button>
                  </form>
                  
                </div>
              </div>
            </div>
          <?php else : ?>

            <div class="table-responsive">
              <table class="table table-borderless border-left border-right border-bottom border-top">
                <tr class="thead-light border-bottom">
                  <th colspan="4" class="text-center">
                    <h5>Application Status</h5>
                  </th>
                </tr>
                <tr class="border-bottom">
                  <td class="text-center" colspan="4">
                    <strong class="text-info">This application is yet to be verified by the supervisor.</strong>
                  </td>
                </tr>
              </table>
            </div>
          <?php endif; ?>
        <?php elseif ($application_status == 'Declined' && $declined_by == 'Supervisor'): ?>
          <div class="table-responsive">
            <table class="table table-borderless border-left border-right border-bottom border-top">
              <tr class="thead-light border-bottom">
                <th colspan="4" class="text-center">
                  <h5>Application Status</h5>
                </th>
              </tr>
              <tr class="border-bottom">
                <td class="text-center" colspan="4">
                  <strong class="text-danger">This application has already been declined by the supervisor.</strong>
                </td>
              </tr>
            </table>
          </div>
        <?php elseif ($application_status == 'Declined' && $declined_by == 'Delegate'): ?>
          <div class="table-responsive">
            <table class="table table-borderless border-left border-right border-bottom border-top">
              <tr class="thead-light border-bottom">
                <th colspan="4" class="text-center">
                  <h5>Application Status</h5>
                </th>
              </tr>
              <tr class="border-bottom">
                <td class="text-center" colspan="4">
                  <strong class="text-danger">This application has already been declined by the delegate.</strong>
                </td>
              </tr>
            </table>
          </div>
        <?php elseif ($application_status == 'Accepted'): ?>
          <div class="table-responsive">
            <table class="table table-borderless border-left border-right border-bottom border-top">
              <tr class="thead-light border-bottom">
                <th colspan="4" class="text-center">
                  <h5>Application Status</h5>
                </th>
              </tr>
              <tr class="border-bottom">
                <td class="text-center" colspan="4">
                  <strong class="text-success">This application has already been accepted.</strong>
                </td>
              </tr>
            </table>
          </div>

          <?php if ($employee_id == $_SESSION['user_id']) : ?>

            <?php if ($data_array['reclaim'] <> null) : ?>
              
              <div class="row justify-content-center">
                <div>
                  <strong class="text-info">*** A reclaim application is pending to be verified corresponding to this application.</strong>
                </div>
              </div>
              <div class="row justify-content-center">
                <div class="mb-3">
                  <a href="<?php echo URLROOT; ?>/index.php?url=reclaims/details/<?php echo $reclaim_id; ?>"> See details</a>
                </div>
              </div>

            <?php else : ?>
              <form action="<?php echo URLROOT; ?>/index.php?url=reclaims/submit_reclaim/" onsubmit="return validate_reclaim_form(this);" method="post">
                <div class="table-responsive">

                  <table class="table table-borderless border-left border-right border-bottom">
                    <tr class="thead-light">
                      <th colspan="2" class="text-center">
                        <h5>Reclaim Days</h5>
                      </th>
                    </tr>
                    <tr class="border-bottom">
                      <th class="text-center" scope="col"><label for="from">Reclaim From</label></th>
                      <th class="text-center" scope="col"><label for="days">Day(s)</label></th>
                    </tr>
                    <tr class="border-bottom">
                      <td class="text-center border-right pt-4" style="min-width:50%" scope="col">
                        <div class="form-group">
                          <select class="form-control" name="from" id="from" required="required">
                            <option value="" disabled selected>Select Deduction Point</option>
                            <option value="beginning">From Beginning</option>
                            <option value="end">From End</option>
                          </select>
                        </div>
                      </td>
                      <td class="text-center pt-4" scope="col">
                        <div class="form-group">
                          <input type="number" min="1" max="<?php echo $date_diff; ?>" value="1" name="days" class="form-control" id="days">
                        </div>
                      </td>
                    </tr>
                  </table>
                </div>

                <div class="row justify-content-center">
                  <input type="hidden" name="application_id" value="<?php echo $application_id; ?>">
                  <input type="hidden" name="supervisor_id" value="<?php echo $supervisor_id; ?>">
                  <input type="hidden" name="fromdate" value="<?php echo $from; ?>">
                  <input type="hidden" name="todate" value="<?php echo $to; ?>">
                  <input type="hidden" name="duration" value="<?php echo $date_diff; ?>">

                  <input type="hidden" name="submit_type" value="post">

                  <div class="col-md-5">
                    <div class="form-group">
                      <button type="submit" name="reclaim" class="btn btn-primary btn-block">Reclaim Days</button>
                    </div>
                  </div>
                </div>
              </form>
            <?php endif; ?>

          <?php endif; ?>

        <?php elseif ($application_status == 'Reclaimed'): ?>
          <div class="table-responsive">
            <table class="table table-borderless border-left border-right border-bottom border-top">
              <tr class="thead-light border-bottom">
                <th colspan="4" class="text-center">
                  <h5>Application Status</h5>
                </th>
              </tr>
              <tr class="border-bottom">
                <td class="text-center" colspan="4">
                  <strong class="text-secondary">This application has already been reclaimed.</strong>
                </td>
              </tr>
            </table>
          </div>
        <?php endif; ?>

      </div>
    </div>
    
  </div>

    <?php require APPROOT . '/views/_shared/references.php'; ?>

  <?php require APPROOT . '/views/reclaims/reclaim_form_script.php'; ?>

<?php require APPROOT . '/views/_shared/footer.php'; ?>