<?php
  session_start();

  // Flash message helper
  // Example - flash('register_success', 'You are now registered', 'alert alert-success')
  // Display in View - <?php echo flash('register_success');

  function flash($name = '', $message = '', $class = 'alert alert-success') {
    if (!empty($name)) {
      
      if (!empty($message) && empty($_SESSION[$name])) {
        
        if (!empty($_SESSION[$name])) {
          unset($_SESSION[$name]);
        }

        if (!empty($_SESSION[$name . '_class'])) {
          unset($_SESSION[$name . '_class']);
        }

        $_SESSION[$name] = $message;
        $_SESSION[$name . '_class'] = $class;
      }
      else if (empty($message) && !empty($_SESSION[$name])) {
        
        $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
        echo '<div class="text-center ' . $class . '" id="msg-flash">' . $_SESSION[$name] . '</div>';

        unset($_SESSION[$name]);
        unset($_SESSION[$name . '_class']);
      }
    }
  }

  // check if any user is logged in
  function isLoggedIn() {
    if (isset($_SESSION['user_id'])) {
      return true;
    }
    return false;
  }

  // check if any user is logged in
  function getUserType() {
    return $_SESSION['user_type'];
  }

  // hr authority

  function giveHrAuthority() {
    if (!isLoggedIn()) {
      flash('unauthorized_access', 'Unauthorized Access!', 'alert alert-danger');
      redirect('users/login');
    }
    else {
      if (getUserType() != "HR") {
        flash('unauthorized_access', 'Unauthorized Access!', 'alert alert-danger');
        redirect('users/login');
      }
    }
  }

  // employee authority

  function giveEmployeeAuthority() {
    if (!isLoggedIn()) {
      flash('unauthorized_access', 'Unauthorized Access!', 'alert alert-danger');
      redirect('users/login');
    }
    else {
      if (getUserType() != "Employee") {
        flash('unauthorized_access', 'Unauthorized Access!', 'alert alert-danger');
        redirect('users/logout');
      }
    }
  }

