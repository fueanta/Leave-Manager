<?php

  class hrmodel extends model {

    // Get pending requests
    public function get_pending_requests() {
      $this->db->query('SELECT  u.id, u.name, u.email, u.type FROM users u WHERE NOT EXISTS ( SELECT  1 FROM employees e WHERE e.id = u.id )');

      // Fetching all pending requests
      $result = $this->db->resultSet();

      // returning requests
      return $result;
    }

    // Decline user request
    public function decline_request($id) {

      // delete query
      $this->db->query('DELETE FROM users WHERE id = :id');
      $this->db->bind(':id', $id);

      // if delete was possible
      if ($this->db->execute()) {
        return true;
      }

      // deletion failed
      return false;
    }

    // Verify new employee by providing data
    public function verify_registration($data_array) {
      $this->db->query('INSERT INTO employees (id, gender, designation, department_id, mobile, emergency_contact, blood_group, company_id, supervisor_id, status, employee_code, created_at) VALUES (:id, :gender, :designation, :department_id, :mobile, :emergency_contact, :blood_group, :company_id, :supervisor_id, :status, :employee_code, :created_at)');

      // binding query values with parametes
      $this->db->bind(':id', $data_array['id']);
      $this->db->bind(':designation', $data_array['designation']);
      $this->db->bind(':gender', $data_array['gender']);
      $this->db->bind(':department_id', $data_array['department_id']);
      $this->db->bind(':mobile', $data_array['mobile']);
      $this->db->bind(':emergency_contact', $data_array['emergency_contact']);
      $this->db->bind(':blood_group', $data_array['blood_group']);
      $this->db->bind(':company_id', $data_array['company_id']);
      $this->db->bind(':supervisor_id', $data_array['supervisor_id']);
      $this->db->bind(':status', $data_array['status']);
      $this->db->bind(':employee_code', $data_array['employee_code']);
      $this->db->bind(':created_at', $data_array['created_at']);

      $insertedIntoEmployeesTable = $this->db->execute();

      // Update Employee Account Type
      $this->db->query('UPDATE users SET type = :type WHERE id = :id');

      // binding query values with parametes
      $this->db->bind(':id', $data_array['id']);
      $this->db->bind(':type', $data_array['type']);

      $updatedUsersTable = $this->db->execute();

      // execute query
      if ($insertedIntoEmployeesTable && $updatedUsersTable) {
        return true;
      } else {
        return false;
      }
    }

    // Update the data for an existing employee
    public function update_information($data_array) {
      $this->db->query('UPDATE employees SET designation=:designation, gender=:gender, department_id=:department_id, mobile=:mobile, emergency_contact=:emergency_contact, blood_group=:blood_group, company_id=:company_id, supervisor_id=:supervisor_id, status=:status, employee_code=:employee_code, created_at=:created_at WHERE id=:id');

      // binding query values with parametes
      $this->db->bind(':id', $data_array['id']);
      $this->db->bind(':designation', $data_array['designation']);
      $this->db->bind(':gender', $data_array['gender']);
      $this->db->bind(':department_id', $data_array['department_id']);
      $this->db->bind(':mobile', $data_array['mobile']);
      $this->db->bind(':emergency_contact', $data_array['emergency_contact']);
      $this->db->bind(':blood_group', $data_array['blood_group']);
      $this->db->bind(':company_id', $data_array['company_id']);
      $this->db->bind(':supervisor_id', $data_array['supervisor_id']);
      $this->db->bind(':status', $data_array['status']);
      $this->db->bind(':employee_code', $data_array['employee_code']);
      $this->db->bind(':created_at', $data_array['created_at']);

      $updatedEmployeeRecord = $this->db->execute();

      // Update Employee Account Type
      $this->db->query('UPDATE users SET type=:type WHERE id = :id');

      // binding query values with parametes
      $this->db->bind(':id', $data_array['id']);
      $this->db->bind(':type', $data_array['type']);

      $updatedUsersTable = $this->db->execute();

      // execute query
      if ($updatedEmployeeRecord && $updatedUsersTable) {
        return true;
      } else {
        return false;
      }
    }

    // Get company drop down items

    public function get_company_dropdown_items() {
      $this->db->query('SELECT id, name FROM companies WHERE id > 0');

      // Fetching id and name of all compan(y/ies)
      return $this->db->resultSet();

    }

    // Get department drop down items

    public function get_department_dropdown_items() {
      $this->db->query('SELECT id, name FROM departments WHERE id > 0');

      // Fetching id and name of all department(s)
      return $this->db->resultSet();

    }

    // Get employee drop down items

    public function get_employee_dropdown_items($id) {
      $this->db->query('SELECT u.id, u.name FROM users u, employees e WHERE u.id = e.id AND u.id > -2 AND u.id <> ' . $id);

      // Fetching id and name of all registered employee(s)
      return $this->db->resultSet();

    }

  }