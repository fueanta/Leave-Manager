<?php require APPROOT . '/views/_shared/header.php'; ?>

  <!-- user requests -->
  <div class="row">
    <div class="col">
        <div class="card card-body bg-light mt-4">
          <h3 class="card-title">Registration Requests</h3>
          <hr>
          <?php if (count($data_array['requests']) > 0) : ?>

            <div class="table-responsive">
              <table class="table table-borderless border-left border-right border-bottom border-top">
                <thead class="thead-light border-bottom">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th colspan="2" scope="col" class="text-center">Actions</th>
                  </tr>
                </thead>

                <tbody>

                <?php foreach ($data_array['requests'] as $request): ?>

                  <tr>
                    <th class="pt-4" scope="row"><?php echo $request->id; ?></th>
                    <td class="pt-4"><?php echo $request->name; ?></td>
                    <td class="pt-4"><?php echo $request->email; ?></td>

                    <td>
                      <form action="<?php echo URLROOT ?>/index.php?url=hr/employee_form/" method="post">

                        <input type="hidden" name="id" value="<?php echo  $request->id; ?>" />
                        <input type="hidden" name="name" value="<?php echo  $request->name; ?>" />
                        <input type="hidden" name="email" value="<?php echo  $request->email; ?>" />
                        <input type="hidden" name="type" value="<?php echo  $request->type; ?>" />

                        <input class="btn btn-block btn-success mb-2" type="submit" value="Proceed">
                      </form>
                    </td>

                    <td>
                      <form action="<?php echo URLROOT ?>/index.php?url=hr/decline/" method="post">
                        <input type="hidden" name="id" value="<?php echo  $request->id; ?>" />

                        <input class="btn btn-block btn-danger" type="submit" value="Decline">
                      </form>
                    </td>

                  </tr>

                <?php endforeach; ?>

                </tbody>
              </table>
            </div>

          <?php else : ?>

            <p class="lead">No request is pending at this moment.</p>

          <?php endif; ?>
        </div>
    </div>
  </div>

  <?php require APPROOT . '/views/_shared/references.php'; ?>

<?php require APPROOT . '/views/_shared/footer.php'; ?>