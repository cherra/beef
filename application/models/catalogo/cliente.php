<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cliente
 *
 * @author cherra
 */
class Cliente extends CI_Model {
    
    public function get($filtro = null, $limit = null, $offset = 0){
        if(!is_null($filtro)){
            foreach($filtro as $key => $valor){
                if($key == 'nombre'){
                    $where = "(id_cliente LIKE '%$valor%' OR nombre LIKE '%$valor%' OR nombre_comercial LIKE '%$valor%' OR contacto LIKE '%$valor%')";
                    $this->db->where($where);
                }else
                    $this->db->like($key,$valor);
            }
        }
        if( !is_null($limit) ){
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by('nombre');
        $query = $this->db->get('Cliente');
        return $query->result();
    }
    
    public function get_num($filtro = null){
        if(!is_null($filtro)){
            foreach($filtro as $key => $valor){
                $this->db->like($key,$valor);
            }
        }
        $this->db->order_by('nombre');
        $query = $this->db->get('Cliente');
        return $query->num_rows();
    }
    
    public function get_por_id($id = ''){
        $this->db->where('id_cliente',$id);
        $query = $this->db->get('Cliente');
        return $query->row_array();
    }
    
    public function get_ultima_cuenta_contable(){
        $this->db->having('cuenta_contable BETWEEN 0 AND 50000');
        $this->db->select('cuenta_contable')->order_by('cuenta_contable','desc')->limit(1);
        $query = $this->db->get('Cliente');
        return $query->row_array();
    }
    
    public function update($data){
        $this->db->update('Cliente',$data,array('id_cliente' => $data['id_cliente']));
    }
    
    public function update_lista($id_cliente, $id_lista){
        $this->db->update('Cliente',array('id_lista' => $id_lista),array('id_cliente' => $id_cliente));
    }
    
    public function insert($data){
        $this->db->insert('Cliente',$data);
    }
}

?>
