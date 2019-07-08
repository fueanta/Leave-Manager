<?php require APPROOT . '/views/_shared/header.php'; ?>

  <div class="jumbotron jumbotron-fluid text-center">
    <div class="container">
      <h4 class="display-4"><?php echo $data_array['title']; ?></h4>
      <p class="lead"><?php echo $data_array['description']; ?></p>
    </div>
  </div>

  <?php require APPROOT . '/views/_shared/references.php'; ?>

<?php require APPROOT . '/views/_shared/footer.php'; ?>