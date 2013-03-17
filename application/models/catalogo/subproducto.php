<?php
/**
 * Description of subproducto
 *
 * @author cherra
 */
class Subproducto extends CI_Model {
    
    public function get_all(){
        $this->db->order_by('nombre');
        $query = $this->db->get('Subproducto');
        return $query->result();
    }
    
    public function get_all_con_codigo(){
        $this->db->where('codigo IS NOT NULL');
        $this->db->order_by('nombre');
        $query = $this->db->get('Subproducto');
        return $query->result();
    }
    
    public function get_por_producto($filtro = NULL){
        $this->db->select('Subproducto.*, Producto.nombre AS nombre_producto')->from('Subproducto')->join('Producto','Subproducto.id_producto = Producto.id_producto');
        if(strlen($filtro['nombre']) > 0)
            $this->db->like('Subproducto.nombre',$filtro['nombre']);
        if($filtro['id_producto'] > 0)
            $this->db->where('Subproducto.id_producto',$filtro['id_producto']);
        if($filtro['con_codigo'] == 's')
            $this->db->where('Subproducto.codigo IS NOT NULL');
        $this->db->group_by('Subproducto.id_subproducto')->order_by('Producto.nombre, Subproducto.nombre');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_por_id($id = ''){
        $this->db->select('*');
        $this->db->from('Subproducto');
        $this->db->where('id_subproducto',$id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    public function update($data){
        $data['codigo'] = strlen($data['codigo']) > 0 ? $data['codigo'] : NULL;
        $datos = array(
            'nombre' => $data['nombre'],
            'codigo' => $data['codigo'],
            'id_producto' => $data['id_producto'],
        );
        //$this->db->where('id_usuario',$data['id_usuario']);
        $this->db->update('Subproducto',$datos,array('id_subproducto' => $data['id_subproducto']));
    }
    
    public function insert($data){
        $this->db->insert('Subproducto',$data);
    }
}

?>
