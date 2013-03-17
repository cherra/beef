<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usuarios
 *
 * @author cherra
 */
class Usuario extends CI_Model{
    
    public function get_all(){
        $this->db->order_by('id_usuario');
        $query = $this->db->get('Usuario');
        return $query->result();
    }
    
    public function get_all_activos(){
        $this->db->where('eliminado','n');
        $this->db->order_by('nombre');
        $query = $this->db->get('Usuario');
        return $query->result();
    }
    
    public function get_por_rol($filtro = NULL){
        $this->db->select('*')->from('Usuario')->join('user_roles','Usuario.id_usuario = user_roles.userID','left');
        if(!is_null($filtro)){
            $this->db->like('nombre',$filtro['nombre']);
            if(strlen($filtro['roleID']) > 0)
                $this->db->where('roleID',$filtro['roleID']);
        }
        $this->db->group_by('id_usuario');
        $this->db->order_by('id_usuario');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_por_nombre($nombre = ''){
        $this->db->select('*');
        $this->db->from('Usuario');
        $this->db->like('nombre',$nombre);
        $this->db->order_by('apellido');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_por_id($id = ''){
        $this->db->select('*');
        $this->db->from('Usuario');
        $this->db->where('id_usuario',$id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    
    public function get_roles($id = ''){
        $this->db->select('*')->from('user_roles')->join('role_data','user_roles.roleID = role_data.ID')->where('userID',$id);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_permisos($id = ''){
        $this->db->select('*')->from('user_perms')->join('perm_data','user_perms.permID = perm_data.ID')->where('userID',$id);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function insert($data){
        $this->db->insert('Usuario',$data);
    }
    
    public function update($data){
        $datos = array(
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'password' => $data['password'],
            'username' => $data['username'],
            'eliminado' => $data['eliminado']
        );

        $this->db->update('Usuario',$datos,array('id_usuario' => $data['id_usuario']));

        // Se borran los roles y los permisos individuales
        $this->db->delete('user_roles',array('userID' => $data['id_usuario']));
        $this->db->delete('user_perms',array('userID' => $data['id_usuario']));
        
        // Los roles llegan en forma de array
        if(isset($data['user_roles'])){
            $roles = array();
            foreach($data['user_roles'] AS $rol){
                $roles[] = array(
                    'userID' => $data['id_usuario'],
                    'roleID' => $rol,
                );
            }
            $this->db->insert_batch('user_roles',$roles);
        }
        
        // Los permisos llegan en forma de array
        $perms = array();
        if(isset($data['user_perms'])){
            foreach($data['user_perms'] AS $perm){
                $perms[] = array(
                    'userID' => $data['id_usuario'],
                    'permID' => $perm,
                    'value' => '1',
                );
            }
            $this->db->insert_batch('user_perms',$perms);
        }

    }
}

?>
