<?php

  class user extends model {

    // Register new User
    public function register($data_array) {
      $this->db->query('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');

      // binding query values with parametes
      $this->db->bind(':name', $data_array['name']);
      $this->db->bind(':email', $data_array['email']);
      $this->db->bind(':password', $data_array['password']);

      // execute query
      if ($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    }

    // User log in processing
    public function login($email, $password) {
      $this->db->query('SELECT u.id, u.name, u.email, u.password, u.type FROM users u, employees e WHERE u.email = :email and u.id = e.id');
      $this->db->bind(':email', $email);

      // Fetching a single user by email 
      $row = $this->db->single();

      // Checking if user exists
      if ($this->db->rowCount() > 0) {
        // does exist

        // Since password is encrypted in database
        $hashed_password = $row->password;
        // Checking if password is matched
        if ( md5( $password ) === $hashed_password ) {
          // did match, so sending user row
          return $row;
        }

      }
      else {
        // record does not exist in employees table

        $this->db->query('SELECT password FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        // Fetching a single user by email 
        $row = $this->db->single();

        // Checking if user exists
        if ($this->db->rowCount() > 0) {
          // user exists but not verified

          // Since password is encrypted in database
          $hashed_password = $row->password;
          // Checking if password is matched
          if ( md5( $password ) === $hashed_password ) {
            // did match, so sending user message that he is not verified
            return 'not verified';
          }

        }

      }

      // does not exist
      return 'invalid credentials';

    }

    // Get user by id
    public function get_user_by_id($id) {
      $this->db->query('SELECT * FROM users WHERE id = :id');
      $this->db->bind(':id', $id);

      // Fetching a single user by id 
      $row = $this->db->single();

      // returning user
      return $row;
    }

    // Get employee by id
    public function get_employee_by_id($id) {
      $this->db->query('SELECT u.id, u.name, u.email, u.type, e.designation, d.name AS \'department\', c.name AS \'company\', e.mobile, e.emergency_contact AS \'emergencyContact\', e.blood_group AS \'bloodGroup\', e.status, e.employee_code AS \'employeeCode\', s.name AS \'supervisor\', e.created_at AS \'joiningDate\' FROM users u, employees e, companies c, departments d, users s WHERE e.id = :id AND u.id = e.id AND e.department_id = d.id AND e.company_id = c.id AND e.supervisor_id = s.id');
      $this->db->bind(':id', $id);

      // Fetching a single user by id 
      if ($row = $this->db->single()) {
        // returning user
        return $row;
      }
      
      return false;
    }

    // Check user existance from email
    public function check_user_existance_from_email($email) {

      $this->db->query('SELECT id FROM users WHERE email = :email');
      $this->db->bind(':email', $email);

      // Fetching a single user by email 
      $row = $this->db->single();

      // Checking if user exists
      if ($this->db->rowCount() > 0) {
        // does exist
        return true;
      }

      // does not exist
      return false;
    }

    public function check_not_self_user_existance_from_email($email, $id) {

      $this->db->query('SELECT id FROM users WHERE email = :email');
      $this->db->bind(':email', $email);

      // Fetching a single user by email 
      $row = $this->db->single();

      // Checking if user exists
      if ($this->db->rowCount() > 0) {
        // does exist
        if ($row->id == $id) {
          return false; // self
        }
        return true; // others
      }

      // does not exist
      return false;
    }

    // api: GET

    public function get_employees() {

      $this->db->query('SELECT u.id, u.name, u.email, u.type, e.gender, e.designation, d.name AS \'department\', c.name AS \'company\', e.mobile, e.emergency_contact AS \'emergencyContact\', e.blood_group AS \'bloodGroup\', e.status, e.employee_code AS \'employeeCode\', s.name AS \'supervisor\', e.created_at AS \'joiningDate\' FROM users u, employees e, companies c, departments d, users s WHERE u.id = e.id AND e.department_id = d.id AND e.company_id = c.id AND e.supervisor_id = s.id AND u.id > 0');

      // Fetching all the employees
      $result = $this->db->resultSet();

      // returning employees
      return $result;

    }

    // Update personal data
    public function update_personal_data($data_array) {

      // user part
      $this->db->query('UPDATE users SET name=:name, email=:email WHERE id=:id');

      // binding query values with parametes
      $this->db->bind(':id', $data_array['id']);
      $this->db->bind(':name', $data_array['name']);
      $this->db->bind(':email', $data_array['email']);

      $updatedUserRecord = $this->db->execute();

      // employee part
      $this->db->query('UPDATE employees SET mobile=:mobile, emergency_contact=:emergency_contact, blood_group=:blood_group WHERE id=:id');

      // binding query values with parametes
      $this->db->bind(':id', $data_array['id']);
      $this->db->bind(':mobile', $data_array['mobile']);
      $this->db->bind(':emergency_contact', $data_array['emergency_contact']);
      $this->db->bind(':blood_group', $data_array['blood_group']);

      $updatedEmployeeRecord = $this->db->execute();

      // execute query
      if ($updatedUserRecord && $updatedEmployeeRecord) {
        return true;
      } else {
        return false;
      }
    }

    // check if the user has typed his actual current password
    public function check_current_password( $password, $id ) {
      $this->db->query( 'SELECT password FROM users WHERE id = :id' );
      $this->db->bind( ':id', $id );

      // Fetching password by id
      $row = $this->db->single();

      // Checking if user has typed accurate current password
      if ( $password == $row->password ) {
        // does match
        return true;
      }
      // does not match
      return false;
    }

    // change / update current password of the user
    public function change_password( $password, $id ) {
      // user part
      $this->db->query('UPDATE users SET password=:password WHERE id=:id');

      // binding query values with parametes
      $this->db->bind( ':id', $id );
      $this->db->bind( ':password', $password );

      $updatedUserPassword = $this->db->execute();

      // execute query
      if (updatedUserPassword) {
        return true;
      } else {
        return false;
      }

    }

    public function change_password_with_email( $password, $email ) {
      // user part
      $this->db->query('UPDATE users SET password=:password WHERE email=:email');

      // binding query values with parametes
      $this->db->bind( ':email', $email );
      $this->db->bind( ':password', $password );

      $updatedUserPassword = $this->db->execute();

      // execute query
      if (updatedUserPassword) {
        return true;
      } else {
        return false;
      }

    }

    // get user email from id
    public function get_email_by_id( $id ) {
      $this->db->query('SELECT email FROM users WHERE id = :id');
      $this->db->bind(':id', $id);
      $row = $this->db->single();
      return $row->email;
    }

    // get supervisor id from user id
    public function get_supervisor_id_by_user_id( $id ) {
      $this->db->query('SELECT supervisor_id FROM employees WHERE id = :id');
      $this->db->bind(':id', $id);
      $row = $this->db->single();
      return $row->supervisor_id;
    }

    // get user name from id
    public function get_name_by_id( $id ) {
      $this->db->query('SELECT name FROM users WHERE id = :id');
      $this->db->bind(':id', $id);
      $row = $this->db->single();
      return $row->name;
    }

    // insert new reference
    public function insert_reference( $email, $ref_type, $ref_code ) {
      $this->db->query('INSERT INTO temp (email, ref_type, ref_code) VALUES (:email, :ref_type, :ref_code)');

      // binding query values with parametes
      $this->db->bind(':email', $email);
      $this->db->bind(':ref_type', $ref_type);
      $this->db->bind(':ref_code', $ref_code);

      // execute query
      if ($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    }

    // get user email from ref_code
    public function get_user_email_from_ref_code( $ref_code ) {
      $this->db->query('SELECT * FROM temp WHERE ref_code = :ref_code');
      $this->db->bind(':ref_code', $ref_code);
      $row = $this->db->single();
      return $row;
    }

    // delete temp date from ref_code
    public function delete_temp_data( $ref_code ) {
      $this->db->query('DELETE FROM temp WHERE ref_code = :ref_code');

      // binding query values with parametes
      $this->db->bind(':ref_code', $ref_code);

      // execute query
      if ($this->db->execute()) {
        return true;
      }
      return false;
    }

    // get employees in leave
    public function getEmployeesInLeave( $from, $to ) {
      $this->db->query("SELECT e.employee_code, u.name, a.from_date, a.to_date FROM applications a, users u, employees e WHERE a.employee_id = e.id AND a.employee_id = u.id AND a.status = 'Accepted' AND (a.from_date BETWEEN '$from' AND '$to' OR a.to_date BETWEEN '$from' AND '$to')");
      $this->db->bind(':from', $from);
      $this->db->bind(':to', $to);
      $result = $this->db->resultSet();
      return $result;
    }

    // Get emails of HRs
    public function get_hr_emails() {
      $this->db->query("SELECT email FROM users WHERE type = 'HR'");

      // Fetching id and name of all registered employee(s)
      return $this->db->resultSet();
    }

  }