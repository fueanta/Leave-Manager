<?php require APPROOT . '/views/_shared/header.php'; ?>

  <div class="row">
    <div class="col-md-6 mx-auto">
      <div class="table-responsive">
        <div class="card card-body bg-light mt-2 mb-4">
          <h3 class="card-title">Application Form</h3>
          <small class="text-muted mb-4">Please fill out this form to apply for a leave.</small>

          <form action="<?php echo URLROOT; ?>/index.php?url=applications/post_application_form/" method="post" enctype="multipart/form-data" onsubmit="return validate_application_form();">
            <div class="col">
              <div class="form-group">
                <label for="leave">Type of Leave: <sup class="text-danger">*</sup></label>
                <select class="form-control" name="leave" id="leave" required="required">

                  <?php if (empty($data_array['leave'])) : ?>
                    <option value="" disabled selected>Select leave</option>
                    <?php foreach ($data_array['leaves'] as $leave) : ?>
                      <option data-document_required_after="<?php echo $leave->document_required_after; ?>" value="<?php echo $leave->id ?>"><?php echo $leave->name ?></option>
                    <?php endforeach; ?>

                  <?php else : ?>
                    <option value="" disabled>Select leave</option>
                    <?php foreach ($data_array['leaves'] as $leave) : ?>
                      <option data-document_required_after="<?php echo $leave->document_required_after; ?>" value="<?php echo $leave->id ?>" <?php if ($data_array['leave'] == $leave->name) echo 'selected'; ?> ><?php echo $leave->name ?></option>
                    <?php endforeach; ?>

                  <?php endif; ?>

                </select>
              </div>
            </div>

            <div class="row pl-3 pr-3">
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label for="fromdate">From: <sup class="text-danger">*</sup></label>
                  <input type="date" name="fromdate" class="form-control" value="<?php echo $data_array['from'] ?>" id="fromdate" required="required">
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label for="todate">To: <sup class="text-danger">*</sup></label>
                  <input type="date" name="todate" class="form-control" value="<?php echo $data_array['to'] ?>" id="todate" required="required">
                </div>
              </div>
            </div>

            <div class="col">
              <div class="form-group">
                <label for="reason">Reason: <sup class="text-danger">*</sup></label>
                <textarea class="form-control" rows="3" id="reason" name="reason" required="required"><?php echo $data_array['reason']; ?></textarea>
              </div>
            </div>

            <div class="col">
              <div class="form-group">
                <label for="delegate">Delegate: <sup class="text-danger">*</sup></label>
                <select class="form-control" name="delegate" id="delegate" required="required">

                  <?php if (empty($data_array['delegate'])) : ?>
                    <option value="" disabled selected>Select delegate</option>
                    <?php foreach ($data_array['delegates'] as $delegate) : ?>
                      <option value="<?php echo $delegate->id ?>"><?php echo $delegate->name ?></option>
                    <?php endforeach; ?>

                  <?php else : ?>
                    <option value="" disabled>Select delegate</option>
                    <?php foreach ($data_array['delegates'] as $delegate) : ?>
                      <option value="<?php echo $delegate->id ?>" <?php if ($data_array['delegate'] == $delegate->name) echo 'selected'; ?> ><?php echo $delegate->name ?></option>
                    <?php endforeach; ?>

                  <?php endif; ?>

                </select>
              </div>
            </div>

            <input type="hidden" id="document_required_after" name="document_required_after" value="">
            <input id="submit_type" type="hidden" name="submit_type" value="<?php echo $data_array['submit_type']; ?>">
            <input type="hidden" name="id" value="<?php echo $data_array['id']; ?>">

            <div class="row justify-content-center mt-3">
              <div class="col-md-5 col-xs-12">
                <div class="form-group">
                  <button type="submit" class="btn btn-success btn-block mt-2" tabindex="7">Submit</button>
                </div>
              </div>
              <div class="col-md-5 col-xs-12 upload-btn-container">
              <div class="form-group">
                <label class="btn btn-info btn-block upload-btn mt-2" for="files"><i class="fas fa-upload"></i><span data-upload-nature="<?php $upload_count = count( $data_array['documents'] ); echo $upload_count > 0 ? 'update' : 'upload'; ?>" id="upload-msg" class="ml-2"><?php echo $upload_count > 0 ? 'Update' : 'Upload'; ?></span></label>
                <input type="file" multiple="multiple" id="files" name="files[]">
              </div>
            </div>
            </div>
          </form>
        </div>
      </div>

      <div class="table-responsive">

        <table class="table table-borderless border-left border-right border-bottom  mb-5">
          <tr class="thead-light">
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

      </div>

    </div>
  </div>
  
  <?php require APPROOT . '/views/_shared/references.php'; ?>

  <?php require APPROOT . '/views/applications/application_form_script.php'; ?>

<?php require APPROOT . '/views/_shared/footer.php'; ?>