<?php

  class company extends model {

    public function get_companies() {
      $this->db->query('SELECT * FROM companies WHERE id > 0');

      // Fetching all the companies
      $result = $this->db->resultSet();

      // returning companies
      return $result;
    }

    public function get_company($id) {
      $this->db->query('SELECT * FROM companies WHERE id = :id');
      $this->db->bind(':id', $id);

      // Fetching a single company by id
      $row = $this->db->single();

      // returning company
      return $row;
    }

    public function post_company($company) {
      $this->db->query('INSERT INTO companies (name, description) VALUES (:name, :description)');

      // binding query values with parametes
      $this->db->bind(':name', $company->name);
      $this->db->bind(':description', $company->description);

      // execute query
      if ($this->db->execute()) {
        return true;
      }
      return false;

    }

    public function put_company($company) {

      // update query
      $this->db->query('UPDATE companies SET name = :name, description = :description WHERE id = :id');

      // binding query values with parametes
      $this->db->bind(':name', $company->name);
      $this->db->bind(':description', $company->description);
      $this->db->bind(':id', $company->id);

      // execute query
      if ($this->db->execute()) {
        return true;
      } 
      return false;
      
    }

    public function delete_company($id) {

      // delete query
      $this->db->query('DELETE FROM companies WHERE id = :id');

      // binding query values with parametes
      $this->db->bind(':id', $id);

      // executing query
      if ($this->db->execute()) {

        return $this->db->rowCount();

      }

      return false;
      
    }

  }