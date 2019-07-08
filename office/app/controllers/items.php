<?php
  class items extends controller {

    public function __construct() {

      global $active;
      $active = "items";

      if (! isLoggedIn()) {
        flash('login_required', 'You need to log in first.. 😒', 'alert alert-warning');
        redirect('users/login');
      }
      if (getUserType() != "HR") {
        flash('unauthorized_access', "You do not have an access to this! 😑", 'alert alert-danger');
        redirect('users/login');
      }

      // loading company model from db
      $this->companyModel = $this->model('company');
      $this->departmentModel = $this->model('department');
      $this->leaveModel = $this->model('leave');
    }

    public function index() {
      $data_array = [
        // list of data to be sent
        'companies' => $this->companyModel->get_companies(),
        'departments' => $this->departmentModel->get_departments(),
        'leaves' => $this->leaveModel->get_leaves()
      ];

      $this->view_path(__FUNCTION__, $data_array);
    }

    // load form
    public function company_form() {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // submitted data
        $data_array = [
          // list of data to be processed
          'id' => $_POST['id'],
          'name' => $_POST['name'],
          'description' => $_POST['description']
        ];

        // show loaded entry form
        $this->view_path(__FUNCTION__, $data_array);

      }
      else {
        
        // load form
        $data_array = [
          // list of data to be sent
          'id' => '',
          'name' => '',
          'description' => ''
        ];
  
        // show empty entry form
        $this->view_path(__FUNCTION__, $data_array);

      }

    }

    // load form
    public function department_form() {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // submitted data
        $data_array = [
          // list of data to be processed
          'id' => $_POST['id'],
          'name' => $_POST['name'],
          'description' => $_POST['description']
        ];

        // show loaded entry form
        $this->view_path(__FUNCTION__, $data_array);

      }
      else {
        
        // load form
        $data_array = [
          // list of data to be sent
          'id' => '',
          'name' => '',
          'description' => ''
        ];
  
        // show empty entry form
        $this->view_path(__FUNCTION__, $data_array);

      }

    }

    // load form
    public function leave_form() {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // submitted data
        $data_array = [
          // list of data to be processed
          'id' => $_POST['id'],
          'name' => $_POST['name'],
          'description' => $_POST['description'],
          'eligible_after' => $_POST['eligible_after'],
          'document_required_after' => $_POST['document_required_after'],
          'annual_balance' => $_POST['annual_balance'],
          'renewal_period' => $_POST['renewal_period'],
          'gender_dependency' => $_POST['gender_dependency'],
          'renewal_periods' => ['Yearly', 'Never'],
          'gender_dependencies' => ['Not Applicable', 'Male', 'Female', 'Other']
        ];

        // show loaded entry form
        $this->view_path(__FUNCTION__, $data_array);

      }
      else {
        
        // load form
        $data_array = [
          // list of data to be sent
          'id' => '',
          'name' => '',
          'description' => '',
          'eligible_after' => '0',
          'document_required_after' => '0',
          'annual_balance' => '0',
          'renewal_period' => '',
          'gender_dependency' => '',
          'renewal_periods' => ['Yearly', 'Never'],
          'gender_dependencies' => ['Not Applicable', 'Male', 'Female', 'Other']
        ];
  
        // show empty entry form
        $this->view_path(__FUNCTION__, $data_array);

      }

    }

    // submit form
    public function company_submit() {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // submitted data
        $company = (object) array (
          // list of data to be processed
          'id' => $_POST['id'],
          'name' => $_POST['name'],
          'description' => $_POST['description']
        );

        // posted for creation
        if (empty($company->id)) {
          $this->companyModel->post_company($company);
        }
        else { // posted for update operation
          $this->companyModel->put_company($company);
        }

        redirect('items/');

      }
    }

    // submit form
    public function department_submit() {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // submitted data
        $department = (object) array (
          // list of data to be processed
          'id' => $_POST['id'],
          'name' => $_POST['name'],
          'description' => $_POST['description']
        );

        // posted for creation
        if (empty($department->id)) {
          $this->departmentModel->post_department($department);
        }
        else { // posted for update operation
          $this->departmentModel->put_department($department);
        }

        redirect('items/');

      }
    }

    // submit form
    public function leave_submit() {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // submitted data
        $leave = (object) array (
          // list of data to be processed
          'id' => $_POST['id'],
          'name' => $_POST['name'],
          'description' => $_POST['description'],
          'eligible_after' => $_POST['eligible_after'],
          'document_required_after' => $_POST['document_required_after'],
          'annual_balance' => $_POST['annual_balance'],
          'renewal_period' => $_POST['renewal_period'],
          'gender_dependency' => $_POST['gender_dependency']
        );

        // posted for creation
        if (empty($leave->id)) {
          $this->leaveModel->post_leave($leave);
        }
        else { // posted for update operation
          $this->leaveModel->put_leave($leave);
        }

        redirect('items/');

      }
    }

    // delete company
    public function company_delete() {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // id
        $id = $_POST['id'];

        // deleting record
        $this->companyModel->delete_company($id);

        redirect('items/');

      }
    }

    public function department_delete() {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // id
        $id = $_POST['id'];

        // deleting record
        $this->departmentModel->delete_department($id);

        redirect('items/');

      }
    }

    public function leave_delete() {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // id
        $id = $_POST['id'];

        // deleting record
        $this->leaveModel->delete_leave($id);

        redirect('items/');

      }
    }

    // this function dynamically loads the view resource
    private function view_path($method_name, $data_array = null) {
      $this->view(__CLASS__ . '/' . $method_name, $data_array);
    }

  }