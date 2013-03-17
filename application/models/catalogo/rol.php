<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rol_model
 *
 * @author cherra
 */
class Rol extends CI_Model {
    
    public function get($filtro = NULL){
        if(!is_null($filtro)){
            $this->db->like('roleName',$filtro['roleName']);
        }
        $query = $this->db->order_by('roleName');
        $query = $this->db->get('role_data');
        return $query->result();
    }
    
    public function get_por_id($ID = ''){
        $this->db->where('ID',$ID);
        $query = $this->db->get('role_data');
        return $query->row_array();
    }
    
    public function get_permisos($id = ''){
        $this->db->select('*')->from('role_perms')->join('role_data','role_perms.roleID = role_data.ID')->join('perm_data','role_perms.permID = perm_data.ID')->where('role_perms.roleID',$id);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function insert($data){
        $datos = array(
            'roleName' => $data['roleName'],
            'roleDescription' => $data['roleDescription']
        );
        
        $this->db->insert('role_data',$datos);
        
        $perms = array();
        if(isset($data['role_perms'])){
            foreach($data['role_perms'] AS $perm){
                $perms[] = array(
                    'roleID' => $this->db->insert_id(),
                    'permID' => $perm,
                    'value' => '1',
                );
            }
            $this->db->insert_batch('role_perms',$perms);
        }
    }
    
    public function update($data){
        $datos = array(
            'roleName' => $data['roleName'],
            'roleDescription' => $data['roleDescription']
        );
        
        $this->db->update('role_data',$datos,array('ID' => $data['ID']));
        $this->db->delete('role_perms',array('roleID' => $data['ID']));
        
        $perms = array();
        if(isset($data['role_perms'])){
            foreach($data['role_perms'] AS $perm){
                $perms[] = array(
                    'roleID' => $data['ID'],
                    'permID' => $perm,
                    'value' => '1',
                );
            }
            $this->db->insert_batch('role_perms',$perms);
        }
    }
}

?>
