<?php

/**
 * Description of linea
 *
 * @author cherra
 */
class Proveedor extends CI_Model{
    
    public function get($filtro = NULL, $limit = null, $offset = 0){
        if(!is_null($filtro)){
            foreach($filtro as $key => $valor){
                $this->db->like($key,$valor);
            }
        }
        if( !is_null($limit) ){
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by('razon_social');
        $query = $this->db->get('Proveedor');
        return $query->result();
    }
    
    public function get_num($filtro = NULL){
        if(!is_null($filtro)){
            foreach($filtro as $key => $valor){
                $this->db->like($key,$valor);
            }
        }
        $this->db->order_by('razon_social');
        $query = $this->db->get('Proveedor');
        return $query->num_rows();
    }
    
    public function get_por_id($id = ''){
        $this->db->where('id_proveedor',$id);
        $query = $this->db->get('Proveedor');
        return $query->row_array();
    }
    
    public function get_productos($id, $id_linea = '', $nombre = '', $mostrar = 'todos'){
        $this->db->select('Producto.*, Linea.nombre AS nombre_linea, Proveedor_Producto.id_proveedor')->from('Producto');
        $this->db->join('Proveedor_Producto','Producto.id_producto = Proveedor_Producto.id_producto AND Proveedor_Producto.id_proveedor = '.$id,'left')->join('Linea','Producto.id_linea = Linea.id_linea');
        //$this->db->where('Proveedor_Producto.id_proveedor',$id);
        if($mostrar == 'asignados'){
            $this->db->where('Proveedor_Producto.id_proveedor',$id);
        }
        
        if( $id_linea > 0 ){
            $this->db->where('Producto.id_linea',$id_linea);
        }
        
        if( strlen($nombre) > 0 ){
            $this->db->like('Producto.nombre',$nombre);
        }
        
        $this->db->order_by('Producto.nombre');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function set_producto($id_proveedor, $id_producto){
        $this->db->insert('Proveedor_Producto',array('id_proveedor' => $id_proveedor, 'id_producto' => $id_producto));
    }
    
    public function unset_producto($id_proveedor, $id_producto){
        $this->db->delete('Proveedor_Producto',array('id_proveedor'=>$id_proveedor, 'id_producto'=>$id_producto));
    }
    
    
    public function get_gastos($id, $nombre = '', $mostrar = 'todos'){
        $this->db->select('Gasto.*, Proveedor_Gasto.id_proveedor')->from('Gasto');
        $this->db->join('Proveedor_Gasto','Gasto.id_gasto = Proveedor_Gasto.id_gasto AND Proveedor_Gasto.id_proveedor = '.$id,'left');
        //$this->db->where('Proveedor_Producto.id_proveedor',$id);
        if($mostrar == 'asignados'){
            $this->db->where('Proveedor_Gasto.id_proveedor',$id);
        }
        
        if( strlen($nombre) > 0 ){
            $this->db->like('Gasto.descripcion',$nombre);
        }
        
        $this->db->order_by('Gasto.descripcion');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function set_gasto($id_proveedor, $id_gasto){
        $this->db->insert('Proveedor_Gasto',array('id_proveedor' => $id_proveedor, 'id_gasto' => $id_gasto));
    }
    
    public function unset_gasto($id_proveedor, $id_gasto){
        $this->db->delete('Proveedor_Gasto',array('id_proveedor'=>$id_proveedor, 'id_gasto'=>$id_gasto));
    }
    
    public function update($data){
        $this->db->update('Proveedor',$data,array('id_proveedor' => $data['id_proveedor']));
    }
    
    public function insert($data){
        $this->db->insert('Proveedor',$data);
    }
}

?>
