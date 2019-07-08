<?php

  class leave extends model {

    public function get_leaves() {
      $this->db->query('SELECT * FROM leaves WHERE id > 0');

      // Fetching all the leaves
      $result = $this->db->resultSet();

      // returning leaves
      return $result;
    }

    public function get_leave($id) {
      $this->db->query('SELECT * FROM leaves WHERE id = :id');
      $this->db->bind(':id', $id);

      // Fetching a single leave by id
      $row = $this->db->single();

      // returning leave
      return $row;
    }

    public function post_leave($leave) {
      $this->db->query('INSERT INTO leaves (name, description, eligible_after, document_required_after, annual_balance, renewal_period, gender_dependency) VALUES (:name, :description, :eligible_after, :document_required_after, :annual_balance, :renewal_period, :gender_dependency)');

      // binding query values with parametes
      $this->db->bind(':name', $leave->name);
      $this->db->bind(':description', $leave->description);
      $this->db->bind(':eligible_after', $leave->eligible_after);
      $this->db->bind(':document_required_after', $leave->document_required_after);
      $this->db->bind(':annual_balance', $leave->annual_balance);
      $this->db->bind(':renewal_period', $leave->renewal_period);
      $this->db->bind(':gender_dependency', $leave->gender_dependency);

      // execute query
      if ($this->db->execute()) {
        return true;
      }
      return false;

    }

    public function put_leave($leave) {

      // update query
      $this->db->query('UPDATE leaves SET name = :name, description = :description, eligible_after = :eligible_after, document_required_after = :document_required_after, annual_balance = :annual_balance, renewal_period = :renewal_period, gender_dependency = :gender_dependency WHERE id = :id');

      // binding query values with parametes
      $this->db->bind(':name', $leave->name);
      $this->db->bind(':description', $leave->description);
      $this->db->bind(':eligible_after', $leave->eligible_after);
      $this->db->bind(':document_required_after', $leave->document_required_after);
      $this->db->bind(':annual_balance', $leave->annual_balance);
      $this->db->bind(':renewal_period', $leave->renewal_period);
      $this->db->bind(':gender_dependency', $leave->gender_dependency);
      $this->db->bind(':id', $leave->id);

      // execute query
      if ($this->db->execute()) {
        return true;
      } 
      return false;
      
    }

    public function delete_leave($id) {

      // delete query
      $this->db->query('DELETE FROM leaves WHERE id = :id');

      // binding query values with parametes
      $this->db->bind(':id', $id);

      // executing query
      if ($this->db->execute()) {

        return $this->db->rowCount();

      }

      return false;
      
    }

  }