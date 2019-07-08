<?php

  class application extends model {

    // Get leaves drop down items

    public function get_leave_dropdown_items() {
      // gender of the employee
      $gender = $this->get_gender($_SESSION['user_id']);

      $this->db->query("SELECT * FROM leaves WHERE id > 0 AND gender_dependency IN ('Not Applicable', :gender)");
      $this->db->bind(':gender', $gender);

      // Fetching id and name of all department(s)
      return $this->db->resultSet();
    }

    // Get delegate drop down items

    public function get_delegate_dropdown_items($id) {
      $this->db->query('SELECT u.id, u.name FROM users u, employees e WHERE u.id = e.id AND u.id > 0 AND u.id <> ' . $id);

      // Fetching id and name of all registered employee(s)
      return $this->db->resultSet();

    }

    // Post new application

    public function post_application($application) {
      $this->db->query('INSERT INTO applications (employee_id, supervisor_id, leave_id, from_date, to_date, reason, delegate_id) VALUES (:employee_id, :supervisor_id,:leave_id, :from_date, :to_date, :reason, :delegate_id)');
      $application = ( object ) $application;

      // binding query values with parametes
      $this->db->bind(':employee_id', $application->employee_id);
      $this->db->bind(':supervisor_id', $application->supervisor_id);
      $this->db->bind(':leave_id', $application->leave_id);
      $this->db->bind(':from_date', $application->from_date);
      $this->db->bind(':to_date', $application->to_date);
      $this->db->bind(':reason', $application->reason);
      $this->db->bind(':delegate_id', $application->delegate_id);

      // execute query
      if ($this->db->execute()) {
        $_SESSION['lastInsertId'] = $this->db->lastInsertId();
        return true;
      }
      return false;
    }

    // map documents and application
    public function map_application_documents( $fileNames, $application_id ) {
      foreach( $fileNames as $fileName ) {
        $this->db->query('INSERT INTO documents (application_id, document_name) VALUES (:application_id, :document_name)');  
        // binding query values with parametes
        $this->db->bind(':application_id', $application_id);
        $this->db->bind(':document_name', $fileName);
        $this->db->execute();
      }
    }

    public function unmap_application_documents( $application_id ) {
      $this->db->query('DELETE FROM documents WHERE application_id = :application_id');

      // binding query values with parametes
      $this->db->bind(':application_id', $application_id);

      // execute query
      if ($this->db->execute()) {
        return true;
      }
      return false;
    }

    // update application

    public function put_application($application) {
      $this->db->query('UPDATE applications SET employee_id = :employee_id, leave_id = :leave_id, from_date = :from_date, to_date = :to_date, reason = :reason, delegate_id = :delegate_id WHERE id = :id');

      $application = ( object ) $application;

      // binding query values with parametes
      $this->db->bind(':id', $application->id);
      $this->db->bind(':employee_id', $application->employee_id);
      $this->db->bind(':leave_id', $application->leave_id);
      $this->db->bind(':from_date', $application->from_date);
      $this->db->bind(':to_date', $application->to_date);
      $this->db->bind(':reason', $application->reason);
      $this->db->bind(':delegate_id', $application->delegate_id);

      // execute query
      if ($this->db->execute()) {
        return true;
      }
      return false;

    }

    // api: GET

    public function get_self_applications($id) {

      $this->db->query('SELECT a.id, l.name AS \'leaveType\', a.from_date AS \'fromDate\', a.to_date AS \'toDate\', a.status, d.name AS \'delegate\' FROM users u, leaves l, applications a, users d WHERE a.delegate_id = d.id AND a.employee_id = u.id AND a.leave_id = l.id AND u.id = :id ORDER By a.id DESC');

      // binding query values with parametes
      $this->db->bind(':id', $id);

      // Fetching all the applications
      $result = $this->db->resultSet();

      // returning applications
      return $result;

    }

    public function get_application_documents( $application_id ) {

      $this->db->query( 'SELECT document_name FROM documents WHERE application_id = :application_id' );

      // binding query values with parametes
      $this->db->bind( ':application_id', $application_id );

      // Fetching all the application documents
      $result = $this->db->resultSet();

      // returning documents
      return $result;

    }

    public function get_supervisor_id_from_application($id) {
      $this->db->query('SELECT supervisor_id FROM applications WHERE id = :id');

      // binding query values with parametes
      $this->db->bind(':id', $id);

      // Fetching supervisor id from the application
      $row = $this->db->single();

      // returning supervisor id
      return $row->supervisor_id;
    }

    public function get_application_form_by_id($id) {
      $this->db->query('SELECT a.id, l.name AS \'leaveType\', a.from_date AS \'fromDate\', a.to_date AS \'toDate\', a.status, d.name AS \'delegate\', a.reason FROM users u, leaves l, applications a, users d WHERE a.delegate_id = d.id AND a.employee_id = u.id AND a.leave_id = l.id AND a.id = :id');
      // binding query values with parametes
      $this->db->bind(':id', $id);

      // Fetching the application
      $row = $this->db->single();

      // returning application
      return $row;
    }

    // meant for the api

    public function get_applications_for_supervisor($supervisor_id) {
      $this->db->query('SELECT a.id, u.name AS \'applicant\', l.name AS \'leaveType\', a.from_date AS \'fromDate\', a.to_date AS \'toDate\', a.status, d.name AS \'delegate\' FROM users u, leaves l, applications a, users d WHERE a.supervisor_id = :supervisor_id AND a.delegate_id = d.id AND a.employee_id = u.id AND a.leave_id = l.id ORDER By a.id DESC');

      // binding query values with parametes
      $this->db->bind(':supervisor_id', $supervisor_id);

      // Fetching all the applications
      $result = $this->db->resultSet();

      // returning applications
      return $result;
    }

    public function get_applications_for_delegate($delegate_id) {
      $this->db->query('SELECT a.id, u.name AS \'applicant\', l.name AS \'leaveType\', a.from_date AS \'fromDate\', a.to_date AS \'toDate\', a.status FROM users u, leaves l, applications a WHERE a.delegate_id = :delegate_id AND a.employee_id = u.id AND a.leave_id = l.id ORDER By a.id DESC');

      // binding query values with parametes
      $this->db->bind(':delegate_id', $delegate_id);

      // Fetching all the applications
      $result = $this->db->resultSet();

      // returning applications
      return $result;
    }

    public function get_application_details($application_id) {
      $this->db->query('SELECT a.id, a.employee_id, a.declined_by, a.created_at AS "Date", a.status AS "Application Status", u.name AS "Employee Name", e.employee_code AS "Employee Code", e.designation AS "Designation", d.name AS "Department", c.name AS "Company", e.created_at AS "Date of Join", e.emergency_contact AS "Emergency Contact No", dg.id AS "Delegate Id", dg.name AS "Delegation", s.id AS "Supervisor Id", s.name AS "Supervisor", a.reason AS "Reason of Leave", l.name AS "Type of Leave", a.from_date AS "From", a.to_date AS "To" FROM users u, departments d, companies c, applications a, employees e, leaves l, users s, users dg WHERE a.employee_id = u.id AND a.employee_id = e.id AND e.department_id = d.id AND e.company_id = c.id AND a.leave_id = l.id AND a.supervisor_id = s.id AND a.delegate_id = dg.id AND a.id = :application_id');
      
      // binding query values with parametes
      $this->db->bind(':application_id', $application_id);

      // Fetching the application
      $row = $this->db->single();

      // returning application
      return $row;
    }

    public function get_leave_status($employee_id) {
      // gender of the employee
      $gender = $this->get_gender($employee_id);

      $this->db->query('SELECT l.id, l.name AS "Leave Title", l.gender_dependency, ( CASE WHEN DATE_ADD( e.created_at, INTERVAL l.eligible_after MONTH ) > SYSDATE() THEN 0 ELSE CEIL( CASE WHEN YEAR( DATE_ADD( e.created_at, INTERVAL l.eligible_after MONTH ) ) = YEAR( SYSDATE() ) AND l.renewal_period = \'Yearly\' THEN ( l.annual_balance * ( 12 - MONTH( DATE_ADD( e.created_at, INTERVAL l.eligible_after MONTH ) ) + 1 ) / 12 ) ELSE l.annual_balance END ) END ) AS "Leave Days" FROM leaves l, employees e WHERE e.id = :employee_id');

      // binding query values with parametes
      $this->db->bind(':employee_id', $employee_id);

      // fetching part of leave statuses
      $id_leaveTitle_genderDependency_leaveDays = $this->db->resultSet();

      $this->db->query('SELECT IFNULL( SUM((DATEDIFF(a.to_date, a.from_date) + 1)), 0 ) AS "Spent Leave" FROM applications a RIGHT OUTER JOIN leaves l ON a.leave_id = l.id AND a.employee_id = :employee_id AND a.status = "Accepted" AND ( ( l.renewal_period = \'Yearly\' AND YEAR(a.from_date) = YEAR(SYSDATE()) ) OR l.renewal_period = \'Never\' ) GROUP BY l.id, l.name, l.annual_balance');

      // binding query values with parametes
      $this->db->bind(':employee_id', $employee_id);

      // fetching part of leave statuses
      $spentLeave = $this->db->resultSet();

      // merging leave statuses
      $leave_status = array();
      for ($i = 0; $i <  $this->db->rowCount(); $i++) {
        if ($id_leaveTitle_genderDependency_leaveDays[$i]->gender_dependency == 'Not Applicable' || $id_leaveTitle_genderDependency_leaveDays[$i]->gender_dependency == $gender) {
          $leave_status[$i]['Id'] = $id_leaveTitle_genderDependency_leaveDays[$i]->id;
          $leave_status[$i]['Leave Title'] = $id_leaveTitle_genderDependency_leaveDays[$i]->{'Leave Title'};
          $leave_status[$i]['Leave Days'] = $id_leaveTitle_genderDependency_leaveDays[$i]->{'Leave Days'};
          $leave_status[$i]['Spent Leave'] = $spentLeave[$i]->{'Spent Leave'};
          $leave_status[$i]['Balance'] = (int) $leave_status[$i]['Leave Days'] - (int) $leave_status[$i]['Spent Leave'];
          $leave_status[$i] = (object) $leave_status[$i];
        }
      }

      // returning leave status
      return (object) $leave_status;
    }

    public function process_application($application_id, $status, $declined_by) {
      $this->db->query('UPDATE applications SET status = :status, declined_by = :declined_by WHERE id = :application_id');

      // binding query values with parametes
      $this->db->bind(':status', $status);
      $this->db->bind(':declined_by', $declined_by);
      $this->db->bind(':application_id', $application_id);

      // execute query
      if ($this->db->execute()) {
        return true;
      }
      return false;
    }

    public function delete_application($application_id) {
      $this->db->query('DELETE FROM applications WHERE id = :application_id');

      // binding query values with parametes
      $this->db->bind(':application_id', $application_id);

      // execute query
      if ($this->db->execute()) {
        return true;
      }
      return false;
    }

    public function update_application_days($id, $from, $to) {
      $this->db->query('UPDATE applications SET from_date = :from, to_date = :to WHERE id = :id');

      // binding query values with parametes
      $this->db->bind(':from', $from);
      $this->db->bind(':to', $to);
      $this->db->bind(':id', $id);

      // execute query
      if ($this->db->execute()) {
        return true;
      }
      return false;
    }

    public function reclaim_application($id) {
      return $this->process_application($id, 'Reclaimed', 'Not Declined');
    }

    // get user gender from id
    public function get_gender( $id ) {
      $this->db->query('SELECT gender FROM employees WHERE id = :id');
      $this->db->bind(':id', $id);
      $row = $this->db->single();
      return $row->gender;
    }

  }