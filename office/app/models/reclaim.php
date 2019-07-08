<?php

  class reclaim extends model {

    // Post new reclaim application

    public function post_reclaim($application) {

      $this->db->query('INSERT INTO reclaims (application_id, supervisor_id, from_date, to_date) VALUES (:application_id, :supervisor_id, :from_date, :to_date)');

      $application = ( object ) $application;

      // binding query values with parametes
      $this->db->bind(':application_id', $application->application_id);
      $this->db->bind(':supervisor_id', $application->supervisor_id);
      $this->db->bind(':from_date', $application->from_date);
      $this->db->bind(':to_date', $application->to_date);

      // execute query
      if ($this->db->execute()) {
        $_SESSION['lastInsertId'] = $this->db->lastInsertId();
        return true;
      }
      return false;

    }

    // Update existing reclaim application

    public function put_reclaim($application) {

      $this->db->query('UPDATE reclaims SET from_date = :from_date, to_date = :to_date WHERE id = :id');

      $application = ( object ) $application;

      // binding query values with parametes
      $this->db->bind(':id', $application->reclaim_id);
      $this->db->bind(':from_date', $application->from_date);
      $this->db->bind(':to_date', $application->to_date);

      // execute query
      if ($this->db->execute()) {
        return true;
      }
      return false;

    }

    // Delete existing reclaim application

    public function delete_reclaim($id) {

      $this->db->query('DELETE FROM reclaims WHERE id = :id');

      // binding query values with parametes
      $this->db->bind(':id', $id);

      // execute query
      if ($this->db->execute()) {
        return true;
      }
      return false;

    }

    // API
    public function get_reclaims_by_user($id) {
      $this->db->query('SELECT r.id, a.id AS "applicationId", l.name AS "leaveType", r.from_date AS "fromDate", r.to_date AS "toDate", r.status, r.created_at AS "createdAt" FROM leaves l, applications a, reclaims r WHERE a.id = r.application_id AND a.leave_id = l.id AND a.employee_id = :id ORDER By r.id DESC');

      // binding query values with parametes
      $this->db->bind(':id', $id);

      // Fetching all the reclaims
      $result = $this->db->resultSet();

      // returning reclaims
      return $result;
    }

    public function get_reclaims_for_supervisor($id) {
      $this->db->query('SELECT r.id, a.id AS "applicationId", u.name AS "applicant", l.name AS "leaveType", r.from_date AS "fromDate", r.to_date AS "toDate", r.status, r.created_at AS "createdAt" FROM users u, leaves l, applications a, reclaims r WHERE a.id = r.application_id AND a.leave_id = l.id AND a.employee_id = u.id AND r.supervisor_id = :id ORDER By r.id DESC ');

      // binding query values with parametes
      $this->db->bind(':id', $id);

      // Fetching all the reclaims
      $result = $this->db->resultSet();

      // returning reclaims
      return $result;
    }

    public function get_reclaim_details($id) {
      $this->db->query('SELECT r.*, s.name AS "Supervisor" FROM reclaims r, users s WHERE s.id = r.supervisor_id AND r.id = :id');
      
      // binding query values with parametes
      $this->db->bind(':id', $id);

      // Fetching the application
      $row = $this->db->single();

      // returning application
      return $row;
    }

    public function get_pending_reclaim_by_application_id($id) {
      $this->db->query('SELECT r.*, s.name AS "Supervisor" FROM reclaims r, users s WHERE s.id = r.supervisor_id AND r.status = \'Pending\' AND r.application_id = :id');
      
      // binding query values with parametes
      $this->db->bind(':id', $id);

      // Fetching the application
      $row = $this->db->single();

      // returning application
      return $row;
    }

    public function process_reclaim($reclaim_id, $status) {
      $this->db->query('UPDATE reclaims SET status = :status WHERE id = :reclaim_id');

      // binding query values with parametes
      $this->db->bind(':status', $status);
      $this->db->bind(':reclaim_id', $reclaim_id);

      // execute query
      if ($this->db->execute()) {
        return true;
      }
      return false;
    }

  }