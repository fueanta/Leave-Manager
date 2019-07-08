<?php
  class api extends controller {

    public function __construct() {
      // if ( ! isLoggedIn() ) {
      //   redirect('users/login');
      // }

      // header
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/json');
      header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

      // loading company model from db
      $this->companyModel = $this->model('company');

      // loading user model from db
      $this->userModel = $this->model('user');

      // loading application model from db
      $this->applicationModel = $this->model('application');

      // loading reclaim model from db
      $this->reclaimModel = $this->model('reclaim');

    }

    // Application API ------------------------------------------------------------------------------>class
    // get: /api/get_applications/
    public function get_applications( $id ) {

      if ( ! ( getUserType() == "HR" || ( $_SESSION['user_id'] == $id ) ) ) {
        flash('unauthorized_access', "You do not have an access to this! 😑", 'alert alert-danger');
        redirect('users/login');
      }

      // header - get
      header('Access-Control-Allow-Methods: GET');
            
      // List of applications
      $applications = $this->applicationModel->get_self_applications( $id );

      // application array
      $application_arr = array();

      foreach ( $applications as $application ) {
        
        // build json obj
        $application_obj = array (
          'id' => $application->id,
          'leaveType' => $application->leaveType,
          'fromDate' => $application->fromDate,
          'toDate' => $application->toDate,
          'status' => $application->status,
          'delegate' => $application->delegate
        );

        // pushing to data
        array_push($application_arr, $application_obj);
      }

      // setting response code - 200 OK
      http_response_code(200);

      // converting to JSON
      echo json_encode($application_arr);

    }

    // get: /api/get_applications_for_supervisor/1
    public function get_applications_for_supervisor($supervisor_id) {

      if ( ! ( getUserType() == "HR" || ( $_SESSION['user_id'] == $supervisor_id ) ) ) {
        flash('unauthorized_access', "You do not have an access to this! 😑", 'alert alert-danger');
        redirect('users/login');
      }

      // header - get
      header('Access-Control-Allow-Methods: GET');
            
      // List of applications
      $applications = $this->applicationModel->get_applications_for_supervisor($supervisor_id);

      // application array
      $application_arr = array();

      foreach ( $applications as $application ) {
        
        // build json obj
        $application_obj = array (
          'id' => $application->id,
          'applicant' => $application->applicant,
          'leaveType' => $application->leaveType,
          'fromDate' => $application->fromDate,
          'toDate' => $application->toDate,
          'status' => $application->status,
          'delegate' => $application->delegate
        );

        // pushing to data
        array_push($application_arr, $application_obj);
      }

      // setting response code - 200 OK
      http_response_code(200);

      // converting to JSON
      echo json_encode($application_arr);

    }

    // get: /api/get_applications_for_delegate/1
    public function get_applications_for_delegate($delegate_id) {

      if ( ! ( getUserType() == "HR" || ( $_SESSION['user_id'] == $delegate_id ) ) ) {
        flash('unauthorized_access', "You do not have an access to this! 😑", 'alert alert-danger');
        redirect('users/login');
      }

      // header - get
      header('Access-Control-Allow-Methods: GET');
            
      // List of applications
      $applications = $this->applicationModel->get_applications_for_delegate($delegate_id);

      // application array
      $application_arr = array();

      foreach ( $applications as $application ) {
        
        // build json obj
        $application_obj = array (
          'id' => $application->id,
          'applicant' => $application->applicant,
          'leaveType' => $application->leaveType,
          'fromDate' => $application->fromDate,
          'toDate' => $application->toDate,
          'status' => $application->status,
        );

        // pushing to data
        array_push($application_arr, $application_obj);
      }

      // setting response code - 200 OK
      http_response_code(200);

      // converting to JSON
      echo json_encode($application_arr);

    }

    // Reclaim API ------------------------------------------------------------------------------>class

    // get: /api/get_reclaims_by_user/1
    public function get_reclaims_by_user($user_id) {

      if ( ! ( getUserType() == "HR" || ( $_SESSION['user_id'] == $user_id ) ) ) {
        flash('unauthorized_access', "You do not have an access to this! 😑", 'alert alert-danger');
        redirect('users/login');
      }

      // header - get
      header('Access-Control-Allow-Methods: GET');
            
      // List of reclaims
      $reclaims = $this->reclaimModel->get_reclaims_by_user($user_id);

      // reclaim array
      $reclaim_arr = array();

      foreach ( $reclaims as $reclaim ) {
        
        // build json obj
        $reclaim_obj = array (
          'id' => $reclaim->id,
          'applicationId' => $reclaim->applicationId,
          'leaveType' => $reclaim->leaveType,
          'fromDate' => $reclaim->fromDate,
          'toDate' => $reclaim->toDate,
          'status' => $reclaim->status,
          'createdAt' => $reclaim->createdAt
        );

        // pushing to data
        array_push($reclaim_arr, $reclaim_obj);
      }

      // setting response code - 200 OK
      http_response_code(200);

      // converting to JSON
      echo json_encode($reclaim_arr);

    }

    // get: /api/get_reclaims_for_supervisor/1
    public function get_reclaims_for_supervisor($supervisor_id) {

      if ( ! ( getUserType() == "HR" || ( $_SESSION['user_id'] == $supervisor_id ) ) ) {
        flash('unauthorized_access', "You do not have an access to this! 😑", 'alert alert-danger');
        redirect('users/login');
      }

      // header - get
      header('Access-Control-Allow-Methods: GET');
            
      // List of reclaims
      $reclaims = $this->reclaimModel->get_reclaims_for_supervisor($supervisor_id);

      // reclaim array
      $reclaim_arr = array();

      foreach ( $reclaims as $reclaim ) {
        
        // build json obj
        $reclaim_obj = array (
          'id' => $reclaim->id,
          'applicationId' => $reclaim->applicationId,
          'applicant' => $reclaim->applicant,
          'leaveType' => $reclaim->leaveType,
          'fromDate' => $reclaim->fromDate,
          'toDate' => $reclaim->toDate,
          'status' => $reclaim->status,
          'createdAt' => $reclaim->createdAt
        );

        // pushing to data
        array_push($reclaim_arr, $reclaim_obj);
      }

      // setting response code - 200 OK
      http_response_code(200);

      // converting to JSON
      echo json_encode($reclaim_arr);

    }

    // Employee API ------------------------------------------------------------------------------->class

    // get: /api/get_employees/
    public function get_employees() {

      if ( ! isLoggedIn() || getUserType() != "HR" ) {
        flash('unauthorized_access', "You do not have an access to this! 😑", 'alert alert-danger');
        redirect('users/login');
      }

      // header - get
      header('Access-Control-Allow-Methods: GET');
            
      // List of employees
      $employees = $this->userModel->get_employees();

      // employee array
      $employee_arr = array();

      foreach ($employees as $employee) {
        
        // build json obj
        $employee_obj = array (
          'id' => $employee->id,
          'name' => $employee->name,
          'gender' => $employee->gender,
          'mobile' => $employee->mobile,
          'email' => $employee->email,
          'emergencyContact' =>$employee->emergencyContact,
          'bloodGroup' => $employee->bloodGroup,
          'status' => $employee->status,
          'employeeCode' => $employee->employeeCode,
          'supervisor' => $employee->supervisor,
          'type' => $employee->type,
          'designation' => $employee->designation,
          'department' => $employee->department,
          'company' => $employee->company,
          'joiningDate' => $employee->joiningDate
        );

        // pushing to data
        array_push($employee_arr, $employee_obj);
      }

      // setting response code - 200 OK
      http_response_code(200);

      // converting to JSON
      echo json_encode($employee_arr);

    }

  }