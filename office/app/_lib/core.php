<?php

  /*
   * App Core Class
   * Creates URL and Loads Core Controller
   * URL Format: /{controller}/{method}/{optional: params}
   */
  
  class core {
    protected $curr_controller = 'pages'; // default controller: pages
    protected $curr_method = 'index'; // default method: index
    protected $params = [];

    // constructor<------------------------------------------------------------------------------------------------------->constructor
    public function __construct() {
      $url = $this->get_url(); // returns url components in an array
      // processing requested controller
      $controller = strtolower( $url[ 0 ] );
      $controller_path = CONTROLLERS . '/' . $controller . '.php';
      if( file_exists( $controller_path ) ) {
        // controller does exist:
        // unsetting $url[ 0 ]
        unset( $url[ 0 ] );
      } else {
        // controller does not exist:
        // die( 'corresponding controller could not be found: ' . $controller );
        flash("page_not_found", "Oops! Page could not be found.. ☹", "alert alert-warning");
        redirect("users/login");
      }
      // loading requested controller
      require_once( $controller_path );
      // instantiating requested controller class object into $curr_controller attribute
      $this->curr_controller = new $controller;
      // unsetting $controller and $controller_path
      unset( $controller );
      unset( $controller_path );
      // processing requested method/action
      $method = strtolower( isset( $url[ 1 ]) ? $url[ 1 ] : $this->curr_method );
      if( method_exists( $this->curr_controller, $method ) ) {
        // method does exist
        unset( $url[ 1 ] );
        $this->curr_method = $method;
      } else {
        // method does not exist:
        // die( 'corresponding method could not be found: ' . $method );
        flash("page_not_found", "Oops! Page could not be found.. ☹", "alert alert-warning");
        redirect("users/login");
      }
      // processing requested params
      $this->params = $url ? array_values( $url ) : [];
      // calling a callback with array of params
      call_user_func_array( [ $this->curr_controller, $this->curr_method ], $this->params );
    }

    // this function/method returns processed url as an array like this:
    // Url: http://192.168.110.42/mvc/users/details/18
    // Array ( [0] => controller: users [1] => method: details [2] => param: 18 )
    public function get_url() {
      if( isset( $_GET[ 'url' ] ) ) {
        $url = rtrim( $_GET[ 'url' ] );
        $url = filter_var( $url, FILTER_SANITIZE_URL );
        // splitting into an array
        $url = explode( '/', $url );
        // method is $curr_method by default if not given
        $url[ 1 ] = !empty( $url[ 1 ] ) ? $url[ 1 ] : $this->curr_method;
        return $url;
      } else {
        // controller is $curr_controller by default if not given
        return array( $this->curr_controller );
      }
    }
  }