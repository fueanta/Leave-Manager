<?php
  /*
   * PDO Database Classes
   * Database Connection
   * Prepared Statements
   * Value Bindings
   * Rows and Tables Fetching
   */
  
  class database {
    // initializing from the constants defined in _config/config.php
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    // helper properties
    private $db_handler;
    private $statement;
    private $error;

    public function __construct() {
      // setting DSN
      $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
      
      $options = array(
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      );

      // PDO instance
      try {
        $this->db_handler = new PDO($dsn, $this->user, $this->pass, $options);
      }
      catch(PDOException $e) {
        $this->error = $e->getMessage();
        echo $this->error;
      }
    }

    // preparing statement with query
    public function query($sql) {
      $this->statement = $this->db_handler->prepare($sql);
    }

    // binding values
    public function bind($param, $value, $type = null) {
      if (is_null($type)) {
        switch(true) {
          case is_int($value):
            $type = PDO::PARAM_INT;
            break;
          case is_bool($value):
            $type = PDO::PARAM_BOOL;
            break;
          case is_null($value):
            $type = PDO::PARAM_NULL;
            break;
          default:
            $type = PDO::PARAM_STR;
        }
      }

      $this->statement->bindValue($param, $value, $type);
    }

    // Executing prepared statement
    public function execute() {
      return $this->statement->execute();
    }

    // Getting resultset / table as array of objects
    public function resultSet() {
      $this->execute();
      return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }

    // Getting a single row/record as object
    public function single() {
      $this->execute();
      return $this->statement->fetch(PDO::FETCH_OBJ);
    }

    // Getting Row Count
    public function rowCount() {
      return $this->statement->rowCount();
    }

    // Getting Last Insert Id
    public function lastInsertId() {
      return $this->db_handler->lastInsertId();
    }
  }