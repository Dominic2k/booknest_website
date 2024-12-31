<?php
class adminModel extends DModel {

    public function __construct() {
        parent::__construct();
    }

    public function updateUserAdmin($table_users,$data,$condition){
        return $this->db->update($table_users, $data, $condition);
    }

    public function deleteUserAdmin($table_users, $condition, $limit = 1){
        return $this->db->delete($table_users, $condition, $limit = 1);
    }
}