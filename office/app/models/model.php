<?php

  class model {
    // db connection reference for models
    protected $db;

    public function __construct() {
      // instantaiting a db connection
      $this->db = new database();
    }
  }