<?php
  class pages extends controller {

    public function __construct() {
      // load the model here
      
      // logged in user cannot access 
      $this->authorize();
    }

    public function index() {
      global $active;
      $active = "home";

      $data_array = [
        // list of data to be sent
        'title' => 'Leave Manager',
        'description' => 'A simple tool that manages the overall office-leaves.'
      ];

      $this->view_path(__FUNCTION__, $data_array);
    }

    public function about() {
      global $active;
      $active = "about";
      
      $data_array = [
        // list of data to be sent
        // 'title' => 'About',
        'message' => 'More elegant, secured and faster than ever. 😎<br>Do let the developer team know if you face any issues in this version.'
      ];

      $this->view_path(__FUNCTION__, $data_array);
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