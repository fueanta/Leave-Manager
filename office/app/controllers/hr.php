<?php
  class hr extends controller {

    public function __construct() {
      // load the model here and give user authority

      if (! isLoggedIn()) {
        flash('login_required', 'You need to log in first.. 😒', 'alert alert-warning');
        redirect('users/login');
      }
      if (getUserType() != "HR") {
        flash('unauthorized_access', "You do not have an access to this! 😑", 'alert alert-danger');
        redirect('users/login');
      }
         
      // loading hr model from db
      $this->hrModel = $this->model('hrmodel');

      $this->userModel = $this->model('user');
    }

    public function registrations() {

      if ( ! isLoggedIn() ) {
        $_SESSION['redirect'] = catchURL();
        redirect('users/login');
      }

      global $active;
      $active = "registrations";

      // fetching pending requests from db
      $requests = $this->hrModel->get_pending_requests();

      $data_array = [
        'requests' => $requests
      ];

      if ( isset( $_SESSION['redirect'] ) ) {
        unset( $_SESSION['redirect'] );
      }

      $this->view_path(__FUNCTION__, $data_array);
    }

    public function employee_form() {

      global $active;
      $active = "employees";

      // if POST Request
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (!isset($_POST['employee_code'])) {
          $data_array = [
            "id" => $_POST['id'],
            "name" => $_POST['name'],
            "email" => $_POST['email'],
            "type" => $_POST['type'],
            "employee_code" => '',
            "gender" => '',
            "designation" => '',
            "company" => '',
            "department" => '',
            "mobile" => '',
            "emergency_contact" => '',
            "blood_group" => '',
            "supervisor" => '',
            "joining_date" => date('Y-m-d'),
            "status" => '',

            "companies" => $this->hrModel->get_company_dropdown_items(),
            "departments" => $this->hrModel->get_department_dropdown_items(),
            "supervisors" => $this->hrModel->get_employee_dropdown_items($_POST['id']),

            "submit_type" => 'POST'
          ];
        }
        else {
          $data_array = [
            "id" => $_POST['id'],
            "name" => $_POST['name'],
            "email" => $_POST['email'],
            "employee_code" => $_POST['employee_code'],
            "gender" => $_POST['gender'],
            "designation" => $_POST['designation'],
            "company" => $_POST['company'],
            "department" => $_POST['department'],
            "mobile" => $_POST['mobile'],
            "emergency_contact" => $_POST['emergency_contact'],
            "blood_group" => $_POST['blood_group'],
            "supervisor" => $_POST['supervisor'],
            "joining_date" => $_POST['joining_date'],
            "status" => $_POST['status'],
            "type" => $_POST['type'],

            "companies" => $this->hrModel->get_company_dropdown_items(),
            "departments" => $this->hrModel->get_department_dropdown_items(),
            "supervisors" => $this->hrModel->get_employee_dropdown_items($_POST['id']),

            "submit_type" => 'PUT'
          ];
        }

        $this->view_path(__FUNCTION__, $data_array);

      }
      else {
        redirect('users/dashboard');
      }
      
    }

    public function decline() {

      // if POST Request
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // send mail to the user
        $employee_id = $_POST['id'];
        $employee_email = $this->userModel->get_email_by_id( $employee_id );
        $hr_id = $_SESSION['user_id'];
        $hr_name = $this->userModel->get_name_by_id( $hr_id );
        $link = URLROOT . '/index.php?url=users/register';

        // declining user by deleting record
        $hasDeclined = $this->hrModel->decline_request($_POST['id']);

        if ($hasDeclined) {
          $sent = send_mail(
            $employee_email,
            'Registration Request has been Declined.',
            prepare_html_message('Your registration request has been declined by an HR, ' . $hr_name . '.', $link)
          );

          redirect('hr/registrations');
        }
        else {
          die('Request could not be decliend!');
        }

      }
      else {
        redirect('users/dashboard');
      }

    }

    public function entry() {

      // if POST Request
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $data_array = [
          "id" => $_POST['id'],
          "employee_code" => $_POST['employee_code'],
          "gender" => $_POST['gender'],
          "designation" => $_POST['designation'],
          "company_id" => $_POST['company'],
          "department_id" => $_POST['department'],
          "mobile" => $_POST['mobile'],
          "emergency_contact" => $_POST['emergency_contact'],
          "blood_group" => $_POST['blood_group'],
          "supervisor_id" => $_POST['supervisor'],
          "status" => $_POST['status'],
          "type" => $_POST['type'],
          "created_at" => $_POST['doj']
        ];

        if ($_POST['submit_type'] == "POST") {
          $isVerified = $this->hrModel->verify_registration($data_array);

          if ($isVerified) {
            flash('posted_employee', 'New employee { Code: ' . $data_array['employee_code'] . ' } has been added.. 😀');

            // send mail to the user
            $employee_id = $_POST['id'];
            $employee_email = $this->userModel->get_email_by_id( $employee_id );

            $hr_id = $_SESSION['user_id'];
            $hr_name = $this->userModel->get_name_by_id( $hr_id );

            $link = URLROOT . '/index.php?url=users/login/';
            $sent = send_mail(
              $employee_email,
              'Registration Request has been Accepted.',
              prepare_html_message('Your registration request has been accepted by an HR, ' . $hr_name . '.', $link)
            );

            redirect('employees/');
          }
          else {
            die('User could not be verified!');
          }
        }
        elseif ($_POST['submit_type'] == "PUT") {
          $hasUpdated = $this->hrModel->update_information($data_array);

          if ($hasUpdated) {
            flash('updated_employee', 'Employee record { Code: ' . $data_array['employee_code'] . ' } has been updated.. 😀');
            redirect('employees/');
          }
          else {
            die('User data could not be updated!');
          }
        }

      }
      else {
        redirect('users/dashboard');
      }
      
    }

    // this function dynamically loads the view resource
    private function view_path($method_name, $data_array = null) {
      $this->view(__CLASS__ . '/' . $method_name, $data_array);
    }

  }
