<?php

  // DB Params
  define('DB_HOST', 'localhost'); // 192.168.110.42 //192.168.110.109 //localhost
  define('DB_USER', 'root'); // developer
  define('DB_PASS', ''); // dev@123
  define('DB_NAME', 'office');

  // root url for this project
  define( 'URLROOT', 'http://localhost:1234/office' ); // 192.168.110.42 //localhost // 192.168.110.109:8080

  // application root
  define( 'APPROOT', dirname( dirname( __FILE__ ) ) );

  // sitename to show on title
  define( 'SITENAME', 'Office' );

  // App Version
  define('APPVERSION', '7.0.0');

  // MVC <----------------------------------------------------------------------------------------------------------------> MVC

  // path from root directory to 'controllers' directory
  define( 'CONTROLLERS', 'app/controllers' );

  // path from root directory to 'views' directory
  define( 'VIEWS', 'app/views' );

  // path from root directory to 'models' directory
  define( 'MODELS', 'app/models' );
