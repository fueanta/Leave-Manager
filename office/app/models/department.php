<?php

  class department extends model {

    public function get_departments() {
      $this->db->query('SELECT * FROM departments WHERE id > 0');

      // Fetching all the departments
      $result = $this->db->resultSet();

      // returning departments
      return $result;
    }

    public function get_department($id) {
      $this->db->query('SELECT * FROM departments WHERE id = :id');
      $this->db->bind(':id', $id);

      // Fetching a single department by id
      $row = $this->db->single();

      // returning department
      return $row;
    }

    public function post_department($department) {
      $this->db->query('INSERT INTO departments (name, description) VALUES (:name, :description)');

      // binding query values with parametes
      $this->db->bind(':name', $department->name);
      $this->db->bind(':description', $department->description);

      // execute query
      if ($this->db->execute()) {
        return true;
      }
      return false;

    }

    public function put_department($department) {

      // update query
      $this->db->query('UPDATE departments SET name = :name, description = :description WHERE id = :id');

      // binding query values with parametes
      $this->db->bind(':name', $department->name);
      $this->db->bind(':description', $department->description);
      $this->db->bind(':id', $department->id);

      // execute query
      if ($this->db->execute()) {
        return true;
      } 
      return false;
      
    }

    public function delete_department($id) {

      // delete query
      $this->db->query('DELETE FROM departments WHERE id = :id');

      // binding query values with parametes
      $this->db->bind(':id', $id);

      // executing query
      if ($this->db->execute()) {

        return $this->db->rowCount();

      }

      return false;
      
    }

  }