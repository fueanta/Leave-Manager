<?php require APPROOT . '/views/_shared/header.php'; ?>

  <div class="row">
    <div class="col mt-3 mb-3">
      <div class="col-md-6 mx-auto">
        <!-- flash messages -->
        <?php flash('personal_data_update'); ?>
        <?php flash('password_changed'); ?>

        <div class="table-responsive">
          <table class="table table-borderless border-left border-right border-bottom border-top">

            <thead class="thead-light border-bottom">
              <tr>
                <th scope="col" class="" style="width:50%;">
                  <h5>Account Information</h5>
                </th>
                <th scope="col">
                  <a class="btn btn-info btn-block" href="<?php echo URLROOT; ?>/index.php?url=users/update_form/<?php echo $data_array['Id'] ?>"><i class="far fa-edit"></i> Edit Information</a>
                </th>
              </tr>
            </thead>

            <tbody>

              <?php 
                unset($data_array['Id']);
                foreach ($data_array as $key => $value) {
                  echo '<tr><td><strong>' . $key . ':</strong></td><td>' . $value . '</td></tr>';
                }
              ?>
            
            </tbody>

          </table>
        </div>

      </div>
    </div>
  </div>

<?php require APPROOT . '/views/_shared/references.php'; ?>

<?php require APPROOT . '/views/_shared/footer.php'; ?>