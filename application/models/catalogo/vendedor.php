<?php

/**
 * Description of linea
 *
 * @author cherra
 */
class Vendedor extends CI_Model{
    
    public function get($filtro = NULL, $limit = null, $offset = 0){
        if(!is_null($filtro)){
            foreach($filtro as $key => $valor){
                $this->db->like($key,$valor);
            }
        }
        if( !is_null($limit) ){
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by('nombre');
        $query = $this->db->get('Empleado');
        return $query->result();
    }
    
    public function get_num($filtro = NULL){
        if(!is_null($filtro)){
            foreach($filtro as $key => $valor){
                $this->db->like($key,$valor);
            }
        }
        $this->db->order_by('nombre');
        $query = $this->db->get('Empleado');
        return $query->num_rows();
    }
    
    public function get_por_id($id = ''){
        $this->db->where('id_empleado',$id);
        $query = $this->db->get('Empleado');
        return $query->row_array();
    }
    
    public function update($data){
        $this->db->update('Empleado',$data,array('id_empleado' => $data['id_empleado']));
    }
    
    public function insert($data){
        $this->db->insert('Empleado',$data);
    }
}

?>
