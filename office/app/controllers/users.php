<?php
  class users extends controller {

    public function __construct() {

      // defines minimum characters in a password
      $this->min_pass_length = 6;

      // loading user model from db
      $this->userModel = $this->model('user');

      // loading application model from db
      $this->applicationModel = $this->model('application');

    }

    public function dashboard() {
      if (!isLoggedIn()) {
        flash('login_required', 'You need to log in first.. 😒', 'alert alert-warning');
        redirect('users/login');
      }
      
      global $active;
      $active = "dashboard";

      $leave_status = $this->applicationModel->get_leave_status( $_SESSION['user_id'] );

      $from = date("Y-m-d");
      $to = date("Y-m-d");

      $absenceList = null;

      if ( isset( $_POST['search'] ) ) {
        $from = $_POST['fromdate'];
        $to = $_POST['todate'];
        $absenceList = $this->userModel->getEmployeesInLeave( $from, $to );
      }

      $data_array = [
        // list of data to be sent
        "leaveStatus" => $leave_status,
        "from" => $from,
        "to" => $to,
        "absenceList" => $absenceList
      ];

      $this->view_path(__FUNCTION__, $data_array);
    }

    public function register() {
      global $active;
      $active = "register";

      // checking for register form post
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // process registration form

        // Sanitizing POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data_array = [
          // list of data to be processed
          'name' => trim($_POST['name']),
          'email' => trim($_POST['email']),
          'password' => trim($_POST['password']),
          'confirm_password' => trim($_POST['confirm_password']),
          
          'name_err' => '',
          'email_err' => '',
          'password_err' => '',
          'confirm_password_err' => ''
        ];

        // validate
        $this->validate_register_form($data_array);
      }
      else {

        // logged in user can't access
        $this->authorize();
        
        // load form
        $data_array = [
          // list of data to be sent
          'name' => '',
          'email' => '',
          'password' => '',
          'confirm_password' => '',
          
          'name_err' => '',
          'email_err' => '',
          'password_err' => '',
          'confirm_password_err' => ''
        ];
  
        // show user empty register form
        $this->view_path(__FUNCTION__, $data_array);
      }
    }

    public function login() {
      global $active;
      $active = "login";

      // checking for login form post
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // process login form

        // Sanitizing POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data_array = [
          // list of data to be processed
          'email' => trim($_POST['email']),
          'password' => trim($_POST['password']),
          'email_err' => '',
          'password_err' => '',
        ];

        // validate
        $this->validate_login_form($data_array);
      }
      else {

        // logged in user can't access
        $this->authorize();

        // load form
        $data_array = [
          // list of data to be sent
          'email' => '',
          'password' => '',
          
          'email_err' => '',
          'password_err' => '',
        ];
        
        // show user empty login form
        $this->view_path(__FUNCTION__, $data_array);
      }
    }

    public function reset() {

      // checking for login form post
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // process login form

        // Sanitizing POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data_array = [
          // list of data to be processed
          'email' => trim($_POST['email']),
          'email_err' => ''
        ];

        // validate
        $this->validate_reset_form($data_array);
      }
      else {

        // load form
        $data_array = [
          // list of data to be sent
          'email' => '',
          'email_err' => ''
        ];
        
        // show user empty login form
        $this->view_path(__FUNCTION__, $data_array);
      }
    }

    public function reset_password( $ref_code ) {

      // checking for change_password form post
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // process change_password form

        // Sanitizing POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data_array = [
          // list of data to be processed
          'new_password' => trim($_POST['new_password']),
          'retyped_new_password' => trim($_POST['retyped_new_password']),
          'new_password_err' => '',
          'retyped_new_password_err' => '',
          'ref_code' => $ref_code
        ];

        // validate
        $this->validate_reset_password_form($data_array);
      }
      else {
        $temp_data = $this->userModel->get_user_email_from_ref_code( $ref_code );

        if ( !isset( $temp_data->email ) ) {
          redirect('users/login');
        }
        
        // load form
        $data_array = [
          // list of data to be sent
          'new_password' => '',
          'retyped_new_password' => '',
          'new_password_err' => '',
          'retyped_new_password_err' => '',
          'ref_code' => $ref_code
        ];
  
        // show user empty register form
        $this->view_path(__FUNCTION__, $data_array);
      }

    }

    public function details($id) {
      if (!isLoggedIn()) {
        flash('login_required', 'You need to log in first.. 😒', 'alert alert-warning');
        redirect('users/login');
      }
      
      if ($id != $_SESSION['user_id']) {
        $id = $_SESSION['user_id'];
        redirect('users/details/' . $id);
      }

      $my_self = $this->userModel->get_employee_by_id($id);

      $data_array = [
        // list of data to be sent
        'Id' => $my_self->id,
        'Employee Code' => $my_self->employeeCode,
        'Name' => $my_self->name,
        'Mobile' => $my_self->mobile,
        'Email' => $my_self->email,
        'Emergency Contact' => $my_self->emergencyContact,
        'Blood Group' => $my_self->bloodGroup,
        'Company' => $my_self->company,
        'Department' => $my_self->department,
        'Designation' => $my_self->designation,
        'Supervisor' => $my_self->supervisor,
        'Type' => $my_self->type,
        'Joining Date' => $my_self->joiningDate,
        'Status' => $my_self->status
      ];

      $this->view_path(__FUNCTION__, $data_array);
    }

    public function update_form( $id = -1 ) {

      if (!isLoggedIn()) {
        flash('login_required', 'You need to log in first.. 😒', 'alert alert-warning');
        redirect('users/login');
      }
      elseif ($id == $_SESSION['user_id']) {

        $my_self = $this->userModel->get_employee_by_id($id);

        $data_array = [
          // list of data to be sent
          'id' => $my_self->id,
          'name' => $my_self->name,
          'mobile' => $my_self->mobile,
          'email' => $my_self->email,
          'emergency_contact' => $my_self->emergencyContact,
          'blood_group' => $my_self->bloodGroup
        ];
  
        $this->view_path( __FUNCTION__, $data_array );

      }
      else {
        redirect( 'users/update_form/' . $_SESSION['user_id'] );
      }
    }

    // posting updated form for users details
    public function post_update_form() {
      
      if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Sanitizing POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data_array = [
          // list of data to be processed
          'id' => trim($_POST['id']),
          'name' => trim($_POST['name']),
          'email' => trim($_POST['email']),
          'mobile' => trim($_POST['mobile']),
          'emergency_contact' => trim($_POST['emergency_contact']),
          'blood_group' => trim($_POST['blood_group']),
          
          'name_err' => '',
          'email_err' => '',
          'mobile_err' => '',
          'emergency_contact_err' => '',
          'blood_group_err' => ''
        ];
        // validate
        $this->validate_update_form($data_array);
      }
    }

    // this function validates register form data
    private function validate_register_form($data_array) {
      
      // Validate Name
      if(empty($data_array['name'])) {
        $data_array['name_err'] = 'Please enter your name';
      }

      // Validate Email
      if(empty($data_array['email'])) {
        $data_array['email_err'] = 'Please enter your email';
      } else {
        // checking if email does exist
        if ($this->userModel->check_user_existance_from_email($data_array['email'])) {
          $data_array['email_err'] = 'Email is already taken';
        }
      }

      // Validate Password
      if(empty($data_array['password'])) {
        $data_array['password_err'] = 'Please enter a password';
      } elseif(strlen($data_array['password']) < $this->min_pass_length){
        $data_array['password_err'] = 'Password must be at least ' . $this->min_pass_length . ' characters long';
      }

      // Validate Confirm Password
      if(empty($data_array['confirm_password'])) {
        $data_array['confirm_password_err'] = 'Please confirm your password';
      } else {
        if($data_array['password'] != $data_array['confirm_password']) {
          $data_array['confirm_password_err'] = 'Passwords do not match';
        }
      }

      // Making sure errors are empty
      if(empty($data_array['email_err']) && empty($data_array['name_err']) && empty($data_array['password_err']) && empty($data_array['confirm_password_err'])) {
        // Validated
        
        // Hashing password
        $data_array[ 'password' ] = md5( $data_array[ 'password' ] );

        // save / register user
        if ($this->userModel->register($data_array)) {
          flash('registration_verification', 'Your registration is yet to be verified.. 😒');

          // send mail to all the HR
          $user_name = $data_array['name'];
          $link = URLROOT . '/index.php?url=hr/registrations/';

          $emails_of_hrs = $this->userModel->get_hr_emails();

          foreach ( $emails_of_hrs as $row ) {
            $email = $row->email;
            $sent = send_mail(
              $email,
              'Request for Registration.',
              prepare_html_message( $user_name . ' has requested to register.', $link )
            );
          }

          $this->view_path('login');
        } else {
          die('Could not be registered!');
        }

      } else {
        // Load view with errors
        $this->view_path('register', $data_array);
      }

    }

    // this function validates update form data
    private function validate_update_form($data_array) {
      
      // Validate Name
      if(empty($data_array['name'])) {
        $data_array['name_err'] = 'Please enter your name';
      }

      // Validate Email
      if(empty($data_array['email'])) {
        $data_array['email_err'] = 'Please enter your email';
      } else {
        // checking if email does exist
        if ($this->userModel->check_not_self_user_existance_from_email($data_array['email'], $_SESSION['user_id'])) {
          $data_array['email_err'] = 'Email is already taken';
        }
      }

      // Validate mobile
      if(empty($data_array['mobile'])) {
        $data_array['mobile_err'] = 'Please enter your mobile no.';
      }

      // Validate emergency contact
      if(empty($data_array['emergency_contact'])) {
        $data_array['emergency_contact_err'] = 'Please enter your emergency contact';
      }

      // Validate blood group
      if(empty($data_array['blood_group'])) {
        $data_array['blood_group_err'] = 'Please enter your blood group';
      }

      // Making sure errors are empty
      if(empty($data_array['email_err']) && empty($data_array['name_err']) && empty($data_array['mobile_err']) && empty($data_array['emergency_contact_err']) && empty($data_array['blood_group_err'])) {
        // Validated
        // save
        if ($this->userModel->update_personal_data($data_array)) {
          flash('personal_data_update', 'Updated successfully.. 😍');
          redirect('users/details/' . $_SESSION['user_id']);
        } else {
          die('Could not be registered!');
        }
        
      } else {
        // Not validated
        // Load with error
        $this->view_path('update_form', $data_array);
      }

    }

    // this function validates login form data
    private function validate_login_form($data_array) {

      // Validate Email
      if(empty($data_array['email'])) {
        $data_array['email_err'] = 'Please enter your email';
      }

      // Validate Password
      if(empty($data_array['password'])) {
        $data_array['password_err'] = 'Please enter your password';
      }

      // Making sure errors are empty
      if(empty($data_array['email_err']) && empty($data_array['password_err'])) {
        // Validated, now checking login credentials
        $loggedInUser = $this->userModel->login($data_array['email'], $data_array['password']);

        if ($loggedInUser === 'invalid credentials') {
          flash('invalid_credentials', 'Invalid email or password.. 😣', 'alert alert-danger');
          $this->view_path('login', $data_array);
        }
        elseif ($loggedInUser === 'not verified') {
          flash('not_verified', 'Your registration is yet to be verified! 😅', 'alert alert-warning');
          $this->view_path('login', $data_array);
        }
        else {
          // create session
          $this->createUserSession($loggedInUser);
        }

      } else {
        // Load view with errors
        $this->view_path('login', $data_array);
      }

    }

    // putting user values into session
    private function createUserSession($user) {
      $_SESSION['user_id'] = $user->id;
      $_SESSION['user_name'] = $user->name;
      $_SESSION['user_email'] = $user->email;
      $_SESSION['user_type'] = $user->type;

      if ( isset( $_SESSION['redirect'] ) ) {
        $link = $_SESSION['redirect'];
        header('location: ' . $link);
        exit;
      }
      
      redirect('users/dashboard');
    }

    // User log out processing
    public function logout() {

      //releasing sessions
      unset($_SESSION['user_id']);
      unset($_SESSION['user_name']);
      unset($_SESSION['user_email']);
      unset($_SESSION['user_type']);
      // session_destroy();

      // redirecting to login page of same controller
      redirect('users/login');
    }

    // this function validates reset password form data
    private function validate_reset_form($data_array) {

      // Validate Email
      if(empty($data_array['email'])) {
        $data_array['email_err'] = 'Please enter your email';
      }
      else if (!$this->userModel->check_user_existance_from_email($data_array['email'])) {
        $data_array['email_err'] = 'Email is not registered';
      }

      // Making sure errors are empty
      if( empty($data_array['email_err']) ) {
        // validated
        $email = $data_array['email'];
        $ref_type = 'Reset Password';
        $ref_code = md5( uniqid() );
        $this->userModel->insert_reference( $email, $ref_type, $ref_code );

        $link = URLROOT . '/index.php?url=users/reset_password/' . $ref_code ;

        $sent = send_mail(
          $email,
          'Reset your password.',
          prepare_html_message('You have requested to reset your password. Follow the link below to do so.', $link)
        );

        flash('email_sent', 'Please, check your email to reset your password.. 😅', 'alert alert-info');
        $data_array['email'] = '';
      }

      $this->view_path('reset', $data_array);
    }

    // this function validates change_password form data
    private function validate_reset_password_form($data_array) {

      // Validate New Password
      if(empty($data_array['new_password'])) {
        $data_array['new_password_err'] = 'Please enter a new password';
      } elseif(strlen($data_array['new_password']) < $this->min_pass_length){
        $data_array['new_password_err'] = 'Password must be at least ' . $this->min_pass_length . ' characters long';
      }

      // Validate Retyped New Password
      if(empty($data_array['retyped_new_password'])) {
        $data_array['retyped_new_password_err'] = 'Please confirm your password';
      } else {
        if($data_array['new_password'] != $data_array['retyped_new_password']) {
          $data_array['retyped_new_password_err'] = 'Passwords do not match';
        }
      }

      // Making sure errors are empty
      if( empty( $data_array[ 'new_password_err' ] ) && empty( $data_array[ 'retyped_new_password_err' ] ) ) {
        // Validated, now update existing password
        $temp_data = $this->userModel->get_user_email_from_ref_code( $data_array['ref_code'] );
        $email = $temp_data->email;
        $this->userModel->delete_temp_data( $data_array['ref_code'] );

        if ( $this->userModel->change_password_with_email( md5( $data_array[ 'new_password' ] ), $email ) ) {
          flash('password_updated', 'Your password has been updated successfully.. 😍');
          redirect('users/login');
        } else {
          die('Could not be updated!');
        }
      } else {
        // Load view with errors
        $this->view_path('reset_password', $data_array);
      }

    }

    // this function is responsible for changing user password
    public function change_password() {
      if( !isLoggedIn() ) {
        redirect( 'users/login' );
      }
      // checking for change_password form post
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // process change_password form

        // Sanitizing POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data_array = [
          // list of data to be processed
          'current_password' => trim($_POST['current_password']),
          'new_password' => trim($_POST['new_password']),
          'retyped_new_password' => trim($_POST['retyped_new_password']),
          
          'current_password_err' => '',
          'new_password_err' => '',
          'retyped_new_password_err' => '',
        ];

        // validate
        $this->validate_change_password_form($data_array);
      }
      else {        
        // load form
        $data_array = [
          // list of data to be sent
          'current_password' => '',
          'new_password' => '',
          'retyped_new_password' => '',
          
          'current_password_err' => '',
          'new_password_err' => '',
          'retyped_new_password_err' => '',
        ];
  
        // show user empty register form
        $this->view_path(__FUNCTION__, $data_array);
      }
    }

    // this function validates change_password form data
    private function validate_change_password_form($data_array) {

      // Validate current password
      if(empty($data_array['current_password'])) {
        $data_array['current_password_err'] = 'Please enter your current password';
      } else {
        // checking if this is the actual current password
        if ( !$this->userModel->check_current_password( md5( $data_array[ 'current_password' ] ), $_SESSION[ 'user_id' ] ) ) {
          $data_array['current_password_err'] = 'Incorrect password';
        }
      }

      // Validate New Password
      if(empty($data_array['new_password'])) {
        $data_array['new_password_err'] = 'Please enter a new password';
      } elseif(strlen($data_array['new_password']) < $this->min_pass_length){
        $data_array['new_password_err'] = 'Password must be at least ' . $this->min_pass_length . ' characters long';
      } elseif( $data_array['new_password'] === $data_array['current_password'] ){
        $data_array['new_password_err'] = 'Please do not use your current password';
      }

      // Validate Retyped New Password
      if(empty($data_array['retyped_new_password'])) {
        $data_array['retyped_new_password_err'] = 'Please confirm your password';
      } else {
        if($data_array['new_password'] != $data_array['retyped_new_password']) {
          $data_array['retyped_new_password_err'] = 'Passwords do not match';
        }
      }

      // Making sure errors are empty
      if( empty( $data_array[ 'current_password_err' ] ) && empty( $data_array[ 'new_password_err' ] ) && empty( $data_array[ 'retyped_new_password_err' ] ) ) {
        // Validated, now update existing password

        if ( $this->userModel->change_password( md5( $data_array[ 'new_password' ] ), $_SESSION[ 'user_id' ] ) ) {
          flash('password_changed', 'Your password has been updated successfully.. 😍');
          redirect('users/details/' . $_SESSION['user_id']);
        } else {
          die('Could not be updated!');
        }
        
      } else {
        // Load view with errors
        $this->view_path('change_password', $data_array);
      }

    }

    // this function dynamically loads the view resource
    private function view_path($method_name, $data_array = null) {
      $this->view(__CLASS__ . '/' . $method_name, $data_array);
    }

    // give authorization
    private function authorize() {
      if (isLoggedIn()) {
        redirect('users/dashboard');
      }
    }

  }
