<?php

/**
 * Description of linea
 *
 * @author cherra
 */
class Linea extends CI_Model{
    
    public function get($filtro = NULL){
        if(!is_null($filtro)){
            foreach($filtro as $key => $valor){
                $this->db->like($key,$valor);
            }
        }
        $this->db->order_by('nombre');
        $query = $this->db->get('Linea');
        return $query->result();
    }
    
    public function get_por_id($id = ''){
        $this->db->where('id_linea',$id);
        $query = $this->db->get('Linea');
        return $query->row_array();
    }
    
    public function update($data){
        $datos = array(
            'nombre' => $data['nombre'],
            'listado' => array_key_exists('listado',$data) ? $data['listado'] : 'n'
        );
        
        $this->db->update('Linea',$datos,array('id_linea' => $data['id_linea']));
    }
    
    public function insert($data){
        $this->db->insert('Linea',$data);
    }
}

?>
