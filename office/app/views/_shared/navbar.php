<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-3">
  
  <div class="container">
    <a class="navbar-brand" href="<?php echo URLROOT; ?>"><?php echo SITENAME; ?></a>
    <?php if (!isLoggedIn()) : ?>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbaritems" aria-controls="navbaritems" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbaritems">
        
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link <?php global $active; echo ($active == "home" ? "active" : ""); ?> " id="nav-home" href="<?php echo URLROOT; ?>">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php global $active; echo ($active == "about" ? "active" : ""); ?> " href="<?php echo URLROOT; ?>/index.php?url=pages/about">About</a>
          </li>
        </ul>

        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link <?php global $active; echo ($active == "register" ? "active" : ""); ?> " href="<?php echo URLROOT; ?>/index.php?url=users/register">Register</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php global $active; echo ($active == "login" ? "active" : ""); ?> " href="<?php echo URLROOT; ?>/index.php?url=users/login">Log In</a>
          </li>
        </ul>

      </div>
    <?php else: ?>

      <!-- <div class="container"> -->
        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbaritems" aria-controls="navbaritems" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbaritems">

          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link <?php global $active; echo ($active == "dashboard" ? "active" : ""); ?> " href="<?php echo URLROOT; ?>/index.php?url=users/dashboard/">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php global $active; echo ($active == "applications" ? "active" : ""); ?> " href="<?php echo URLROOT; ?>/index.php?url=applications/">Applications</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php global $active; echo ($active == "reclaims" ? "active" : ""); ?> " href="<?php echo URLROOT; ?>/index.php?url=reclaims/">Reclaims</a>
            </li>

            <?php if (getUserType() == 'HR') : ?>
              <li class="nav-item">
                <b class="nav-link disabled text-center">-</b>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php global $active; echo ($active == "registrations" ? "active" : ""); ?> " href="<?php echo URLROOT; ?>/index.php?url=hr/registrations/">Registrations</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php global $active; echo ($active == "items" ? "active" : ""); ?> " href="<?php echo URLROOT; ?>/index.php?url=items/">Items</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php global $active; echo ($active == "employees" ? "active" : ""); ?> " href="<?php echo URLROOT; ?>/index.php?url=employees/">Employees</a>
              </li>
              <!-- <li class="nav-item">
                <b class="nav-link disabled text-center">-</b>
              </li> -->
            <?php endif; ?>
          </ul>

          <!-- <div class="container"> -->

          <ul class="navbar-nav ml-auto">
            <div class="dropdown">
              <button type="button" class="btn btn-sm btn-warning btn-block dropdown-toggle" data-toggle="dropdown">
                <?php echo $_SESSION['user_name']; ?>
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="<?php echo URLROOT; ?>/index.php?url=users/details/<?php echo $_SESSION['user_id']; ?>"><i class="fas fa-user"></i> Account Information</a>
                <a class="dropdown-item" href="<?php echo URLROOT; ?>/index.php?url=users/change_password/"><i class="fas fa-unlock-alt"></i> Change Password</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo URLROOT; ?>/index.php?url=users/logout"><i class="fas fa-sign-out-alt"></i> Log Out</a>
              </div>
            </div>
          </ul>

          <!-- </div> -->

        </div>
      <!-- </div> -->
    <?php endif; ?>
  </div>

</nav>