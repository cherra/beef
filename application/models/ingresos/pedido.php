<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pedido
 *
 * @author cherra
 */
class Pedido extends CI_Model{
    
    public function get_all(){
        $this->db->order_by('id_pedido');
        $query = $this->db->get('Pedido');
        return $query->result();
    }
    
    public function get($filtro = null, $limit = null, $offset = 0){
        
        $this->db->from("Pedido")->join("Cliente","Pedido.id_cliente = Cliente.id_cliente");
        
        if(!is_null($filtro)){
            foreach($filtro as $key => $valor){
                if($key == 'nombre'){
                    $where = "(Cliente.id_cliente LIKE '%$valor%' OR Cliente.nombre LIKE '%$valor%' OR Cliente.nombre_comercial LIKE '%$valor%' OR Cliente.contacto LIKE '%$valor%')";
                    $this->db->where($where);
                }else
                    $this->db->like($key,$valor);
            }
        }
        if( !is_null($limit) ){
            $this->db->limit($limit, $offset);
        }

        $this->db->order_by('id_pedido');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_num($filtro = null){
        
        $this->db->from("Pedido")->join("Cliente","Pedido.id_cliente = Cliente.id_cliente");
        
        if(!is_null($filtro)){
            foreach($filtro as $key => $valor){
                if($key == 'nombre'){
                    $where = "(Cliente.id_cliente LIKE '%$valor%' OR Cliente.nombre LIKE '%$valor%' OR Cliente.nombre_comercial LIKE '%$valor%' OR Cliente.contacto LIKE '%$valor%')";
                    $this->db->where($where);
                }else
                $this->db->like($key,$valor);
            }
        }
        $this->db->order_by('id_pedido');
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function cancela($id_pedido){
        $this->db->where('id_pedido', $id_pedido);
        $this->db->update('Pedido', array('cancelado' => 's'));
    }
    
    public function get_por_id($id_pedido){
        $this->db->where('id_pedido', $id_pedido);
        $query = $this->db->get('Pedido');
        return $query->row();
    }
}

?>
