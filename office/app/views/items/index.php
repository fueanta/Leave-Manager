<?php require APPROOT . '/views/_shared/header.php'; ?>

  <!-- companies -->
  <div class="row">
    <div class="col">
        <div class="card card-body mt-4 mb-4">

          <h3 class="card-title">Companies</h3>

          <hr>

          <div class="row mt-2">
            <div class="col">
              <a href="<?php echo URLROOT; ?>/index.php?url=items/company_form/" class="btn btn-primary">Add New</a>
            </div>
          </div>

          <?php if (count($data_array['companies']) > 0) : ?>

            <div class="table-responsive">
              <table class="table table-borderless border-left border-right border-bottom border-top mt-3">
                <thead class="thead-light border-bottom">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Short Description</th>
                    <!-- <th scope="col">Time of Creation</th> -->
                    <th colspan="2" scope="col" class="text-center">Actions</th>
                  </tr>
                </thead>

                <tbody>

                <?php foreach ($data_array['companies'] as $company): ?>

                  <tr>
                    <th class="pt-4" scope="row"><?php echo $company->id; ?></th>
                    <td class="pt-4"><?php echo $company->name; ?></td>
                    <td class="pt-4"><?php echo $company->description; ?></td>
                    <!-- <td class="pt-3"><?php // echo $company->created_at; ?></td> -->

                    <td>
                      <form action="<?php echo URLROOT; ?>/index.php?url=items/company_form/" method="post">

                        <input type="hidden" name="id" value="<?php echo  $company->id; ?>" />
                        <input type="hidden" name="name" value="<?php echo  $company->name; ?>" />
                        <input type="hidden" name="description" value="<?php echo  $company->description; ?>" />
                        <input type="hidden" name="created_at" value="<?php echo  $company->created_at; ?>" />

                        <input class="btn btn-block btn-info mb-2" type="submit" value="Edit">
                      </form>
                    </td>

                    <td>
                      <form action="<?php echo URLROOT ?>/index.php?url=items/company_delete/" method="post">
                        <input type="hidden" name="id" value="<?php echo  $company->id; ?>" />

                        <input disabled class="btn btn-block btn-danger" type="submit" value="Delete">
                      </form>
                    </td>

                  </tr>

                <?php endforeach; ?>

                </tbody>
              </table>
            </div>

          <?php else : ?>

            <p class="lead mt-4">No company has been added yet.</p>

          <?php endif; ?>

        </div>
    </div>
  </div>

  <hr>

  <!-- departments -->
  <div class="row">
    <div class="col">
        <div class="card card-body mt-4 mb-4">
        
          <h3 class="card-title">Departments</h3>

          <hr>

          <div class="row mt-2">
            <div class="col">
              <a href="<?php echo URLROOT; ?>/index.php?url=items/department_form/" class="btn btn-primary">Add New</a>
            </div>
          </div>

          <?php if (count($data_array['departments']) > 0) : ?>

            <div class="table-responsive">
              <table class="table table-borderless border-left border-right border-bottom border-top mt-3">
                <thead class="thead-light border-bottom">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Short Description</th>
                    <!-- <th scope="col">Time of Creation</th> -->
                    <th colspan="2" scope="col" class="text-center">Actions</th>
                  </tr>
                </thead>

                <tbody>

                <?php foreach ($data_array['departments'] as $department): ?>

                  <tr>
                    <th class="pt-4" scope="row"><?php echo $department->id; ?></th>
                    <td class="pt-4"><?php echo $department->name; ?></td>
                    <td class="pt-4"><?php echo $department->description; ?></td>
                    <!-- <td class="pt-4"><?php // echo $department->created_at; ?></td> -->

                    <td>
                      <form action="<?php echo URLROOT; ?>/index.php?url=items/department_form/" method="post">

                        <input type="hidden" name="id" value="<?php echo  $department->id; ?>" />
                        <input type="hidden" name="name" value="<?php echo  $department->name; ?>" />
                        <input type="hidden" name="description" value="<?php echo  $department->description; ?>" />
                        <input type="hidden" name="created_at" value="<?php echo  $department->created_at; ?>" />

                        <!-- <input class="btn btn-block btn-info mb-2" type="submit" value="Edit"> -->
                        <button class="btn btn-block btn-info mb-2" type="submit">Edit</button>
                      </form>
                    </td>

                    <td>
                      <form action="<?php echo URLROOT ?>/index.php?url=items/department_delete/" method="post">
                        <input type="hidden" name="id" value="<?php echo  $department->id; ?>" />

                        <input disabled class="btn btn-block btn-danger" type="submit" value="Delete">
                      </form>
                    </td>

                  </tr>

                <?php endforeach; ?>

                </tbody>
              </table>
            </div>

          <?php else : ?>

            <p class="lead mt-4">No department has been added yet.</p>

          <?php endif; ?>

        </div>
    </div>
  </div>

  <hr>

  <!-- leaves -->
  <div class="row">
    <div class="col">
        <div class="card card-body mt-4 mb-5">

          <h3 class="card-title">Types of Leave</h3>

          <hr>

          <div class="row mt-2">
            <div class="col">
              <a href="<?php echo URLROOT; ?>/index.php?url=items/leave_form/" class="btn btn-primary">Add New</a>
            </div>
          </div>

          <?php if (count($data_array['leaves']) > 0) : ?>

            <div class="table-responsive">
              <table class="table table-borderless border-left border-right border-bottom border-top mt-3">
                <thead class="thead-light border-bottom">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Type</th>
                    <th scope="col" class="text-center">Eligibility</th>
                    <th scope="col" class="text-center">Documents</th>
                    <th scope="col" class="text-center">Balance</th>
                    <th scope="col" class="text-center">Renewal</th>
                    <th scope="col" class="text-center">Gender</th>
                    <th scope="col" class="text-center">Actions</th>
                  </tr>
                </thead>

                <tbody>

                <?php foreach ($data_array['leaves'] as $leave): ?>

                  <tr>
                    <th class="pt-4" scope="row"><?php echo $leave->id; ?></th>
                    <td class="pt-4"><?php echo $leave->name; ?></td>
                    <td class="pt-4"><?php echo $leave->description; ?></td>
                    <td class="pt-4 text-center"><?php echo $leave->eligible_after; ?><?php echo $leave->eligible_after > 1 ? " months" : " month"; ?></td>
                    <td class="pt-4 text-center"><?php echo $leave->document_required_after; ?><?php echo $leave->document_required_after > 1 ? " days" : " day"; ?></td>
                    <td class="pt-4 text-center"><?php echo $leave->annual_balance; ?> days</td>
                    <td class="pt-4 text-center"><?php echo $leave->renewal_period; ?></td>
                    <td class="pt-4 text-center"><?php echo $leave->gender_dependency; ?></td>

                    <td>
                      <form action="<?php echo URLROOT; ?>/index.php?url=items/leave_form/" method="post">

                        <input type="hidden" name="id" value="<?php echo  $leave->id; ?>" />
                        <input type="hidden" name="name" value="<?php echo  $leave->name; ?>" />
                        <input type="hidden" name="description" value="<?php echo  $leave->description; ?>" />
                        <input type="hidden" name="eligible_after" value="<?php echo  $leave->eligible_after; ?>" />
                        <input type="hidden" name="document_required_after" value="<?php echo  $leave->document_required_after; ?>" />
                        <input type="hidden" name="annual_balance" value="<?php echo  $leave->annual_balance; ?>" />
                        <input type="hidden" name="renewal_period" value="<?php echo  $leave->renewal_period; ?>" />
                        <input type="hidden" name="gender_dependency" value="<?php echo  $leave->gender_dependency; ?>" />

                        <input class="btn btn-block btn-info mb-2" type="submit" value="Edit">
                      </form>
                    </td>

                    <!-- <td>
                      <form action="<?php echo URLROOT ?>/index.php?url=items/leave_delete/" method="post">
                        <input type="hidden" name="id" value="<?php echo  $leave->id; ?>" />

                        <input class="btn btn-block btn-danger" type="submit" value="Delete" disabled>
                      </form>
                    </td> -->

                  </tr>

                <?php endforeach; ?>

                </tbody>
              </table>
            </div>

          <?php else : ?>

            <p class="lead mt-4">No leave has been added yet.</p>

          <?php endif; ?>

        </div>
    </div>
  </div>

  <?php require APPROOT . '/views/_shared/references.php'; ?>

<?php require APPROOT . '/views/_shared/footer.php'; ?>