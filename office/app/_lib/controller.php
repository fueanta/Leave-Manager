<?php

  /*
   * Base Controller Class
   * Every Controller Requires to Extend this Base First
   * Contains Basic Codes to Load the Models and Views
   */ 

  class controller {
    // loads model
    public function model( $model ) {
      // do require base model for db ref.
      $base_model_path = MODELS . '/model.php';
      // processing requested model
      $model = strtolower( $model );
      $model_path = MODELS . '/' . $model. '.php';
      if( !file_exists( $model_path  ) ) {
        // model does not exist:
        die( 'corresponding model could not be found: ' . $model );
      }
      // loading base model
      require_once( $base_model_path );
      // loading requested model
      require_once( $model_path );
      // instantiating requested model and returning back
      return new $model();
    }

    // loads view
    public function view( $view, $data_array = [] ) {
      // processing requested view
      $view = strtolower( $view );
      $view_path = VIEWS . '/' . $view. '.php';
      if( !file_exists( $view_path  ) ) {
        // view does not exist:
        die( 'corresponding view could not be found: ' . $view );
      }
      // loading requested view
      require_once( $view_path );
    }
  }