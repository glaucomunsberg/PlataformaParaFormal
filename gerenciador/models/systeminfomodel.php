<?php

class SystemInfoModel extends Model {

    public function getDBVersion() {
        return $this->db->version();
    }
    
    public function getDBCorrent() {
        return $this->db->database;
    }
    
    public function getDBHost() {
        return $this->db->hostname;
    }
    
    
}
