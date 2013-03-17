<?php
/**
 * Description of presentacion
 *
 * @author cherra
 */
class Presentacion extends CI_Model{
    
    public function get_por_subproducto($filtro = NULL, $limit = null, $offset = null){
        $this->db->select('Articulo.*, Subproducto.nombre AS nombre_subproducto, Subproducto.codigo AS codigo_subproducto')->from('Articulo')->join('Subproducto','Articulo.id_subproducto = Subproducto.id_subproducto');
        if(strlen($filtro['nombre']) > 0)
            $this->db->like('Articulo.nombre',$filtro['nombre']);
        if($filtro['id_subproducto'] > 0)
            $this->db->where('Articulo.id_subproducto',$filtro['id_subproducto']);
        if($filtro['con_codigo'] == 's')
            $this->db->where('Articulo.codigo IS NOT NULL')->where('Subproducto.codigo IS NOT NULL');
        $this->db->group_by('Articulo.id_articulo')->order_by('Subproducto.nombre, Articulo.nombre');

        if( !is_null($limit) && !is_null($offset)){
            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_num_por_subproducto($filtro = NULL){
        $this->db->select('Articulo.*, Subproducto.nombre AS nombre_subproducto, Subproducto.codigo AS codigo_subproducto')->from('Articulo')->join('Subproducto','Articulo.id_subproducto = Subproducto.id_subproducto');
        if(strlen($filtro['nombre']) > 0)
            $this->db->like('Articulo.nombre',$filtro['nombre']);
        if($filtro['id_subproducto'] > 0)
            $this->db->where('Articulo.id_subproducto',$filtro['id_subproducto']);
        if($filtro['con_codigo'] == 's')
            $this->db->where('Articulo.codigo IS NOT NULL')->where('Subproducto.codigo IS NOT NULL');
        $this->db->group_by('Articulo.id_articulo')->order_by('Subproducto.nombre, Articulo.nombre');
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function get_por_linea( $id, $nombre = '', $con_codigo = 's', $limit = null, $offset = null ){
        $this->db->select('Articulo.*, Subproducto.codigo AS codigo_subproducto')->from('Articulo')->join('Subproducto','Articulo.id_subproducto = Subproducto.id_subproducto')->join('Producto','Subproducto.id_producto = Producto.id_producto')->join('Linea','Producto.id_linea = Linea.id_linea');
        if($id > 0)
            $this->db->where('Linea.id_linea',$id);
        
        if(strlen($nombre) > 0){
            $this->db->like('Articulo.nombre',$nombre);
        }
        
        if($con_codigo != 'n')
            $this->db->where('Articulo.codigo IS NOT NULL')->where('Subproducto.codigo IS NOT NULL');
        
        if( !is_null($limit) && !is_null($offset)){
            $this->db->limit($limit, $offset);
        }
        
        $this->db->order_by('Articulo.nombre');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_num_por_linea( $id, $nombre = '', $con_codigo = 's' ){
        $this->db->select('*')->from('Articulo')->join('Subproducto','Articulo.id_subproducto = Subproducto.id_subproducto')->join('Producto','Subproducto.id_producto = Producto.id_producto')->join('Linea','Producto.id_linea = Linea.id_linea');
        if($id > 0)
            $this->db->where('Linea.id_linea',$id);
        if(strlen($nombre) > 0){
            $this->db->like('Articulo.nombre',$nombre);
        }
        if($con_codigo != 'n')
            $this->db->where('Articulo.codigo IS NOT NULL')->where('Subproducto.codigo IS NOT NULL');
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function get_por_id($id){
        $this->db->select('*');
        $this->db->from('Articulo');
        $this->db->where('id_articulo',$id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    public function get_all(){
        $query = $this->db->get('Articulo');
        return $query->result();
    }
    
    public function update($data){
        $data['codigo'] = strlen($data['codigo']) > 0 ? $data['codigo'] : NULL;
        $datos = array(
            'nombre' => $data['nombre'],
            'codigo' => $data['codigo'],
            'id_subproducto' => $data['id_subproducto'],
        );
        //$this->db->where('id_usuario',$data['id_usuario']);
        $this->db->update('Articulo',$datos,array('id_articulo' => $data['id_articulo']));
    }
    
    public function insert($data){
        $this->db->insert('Articulo',$data);
    }
}

?>
