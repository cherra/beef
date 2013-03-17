<?php

class Menu extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }

    public function getOptions(){
        $this->db->where('LENGTH(folder) > 0');
        $this->db->order_by('folder,submenu,class,method');
        $query = $this->db->get('perm_data');
        return  $query->result();
    }
}

?>
