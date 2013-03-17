<?php

/**
 * Description of producto
 *
 * @author cherra
 */
class Producto extends CI_Model{
    
    public function get_all(){
        $this->db->order_by('id_linea, nombre');
        $query = $this->db->get('Producto');
        return $query->result();
    }
    
    public function get_por_linea($filtro = NULL){
        $this->db->select('Producto.*, Linea.nombre AS nombre_linea')->from('Producto')->join('Linea','Producto.id_linea = Linea.id_linea');
        if(strlen($filtro['nombre']) > 0)
            $this->db->like('Producto.nombre',$filtro['nombre'])->or_like('Linea.nombre',$filtro['nombre']);
        if($filtro['id_linea'] > 0)
            $this->db->where('Producto.id_linea',$filtro['id_linea']);
        $this->db->group_by('Producto.id_producto')->order_by('Linea.nombre, Producto.nombre');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_por_id($id = ''){
        $this->db->select('*');
        $this->db->from('Producto');
        $this->db->where('id_producto',$id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    public function update($data){
        $datos = array(
            'nombre' => $data['nombre'],
            'id_linea' => $data['id_linea'],
        );
        //$this->db->where('id_usuario',$data['id_usuario']);
        $this->db->update('Producto',$datos,array('id_producto' => $data['id_producto']));
    }
    
    public function insert($data){
        $this->db->insert('Producto',$data);
    }
}

?>
