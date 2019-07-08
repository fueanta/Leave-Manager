<?php
  class employees extends controller {

    public function __construct() {
      global $active;
      $active = "employees";

      // load the model here and provide authority
      if (! isLoggedIn()) {
        flash('login_required', 'You need to log in first.. 😒', 'alert alert-warning');
        redirect('users/login');
      }
      if (getUserType() != "HR") {
        flash('unauthorized_access', "You do not have an access to this! 😑", 'alert alert-danger');
        redirect('users/login');
      }
      
      // loading hr model from db
      $this->userModel = $this->model('user');
      $this->applicationModel = $this->model('application');
    }

    public function index() {
      $data_array = [
        // list of data to be sent
        'employees' => $this->userModel->get_employees()
      ];

      $this->view_path(__FUNCTION__, $data_array);
    }

    public function activities( $id ) {
      $leave_status = $this->applicationModel->get_leave_status( $id );
      $employee = $this->userModel->get_employee_by_id( $id );

      $data_array = [
        // list of data to be sent
        'id' => $id,
        'employee' => $employee,
        'leaveStatus' => $leave_status
      ];

      $this->view_path(__FUNCTION__, $data_array);
    }

    // this function dynamically loads the view resource
    private function view_path($method_name, $data_array = null) {
      $this->view(__CLASS__ . '/' . $method_name, $data_array);
    }

  }