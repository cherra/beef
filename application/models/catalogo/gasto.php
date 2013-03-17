<?php

/**
 * Description of linea
 *
 * @author cherra
 */
class Gasto extends CI_Model{
    
    public function get($filtro = null, $limit = null, $offset = 0){
        if(!is_null($filtro)){
            foreach($filtro as $key => $valor){
                $this->db->like($key,$valor);
            }
        }
        
        if( !is_null($limit) ){
            $this->db->limit($limit, $offset);
        }
        
        $this->db->order_by('descripcion');
        $query = $this->db->get('Gasto');
        return $query->result();
    }
    
    public function get_num($filtro = null){
        if(!is_null($filtro)){
            foreach($filtro as $key => $valor){
                $this->db->like($key,$valor);
            }
        }
        $this->db->order_by('descripcion');
        $query = $this->db->get('Gasto');
        return $query->num_rows();
    }
    
    public function get_por_id($id = ''){
        $this->db->where('id_gasto',$id);
        $query = $this->db->get('Gasto');
        return $query->row_array();
    }
    
    public function update($data){
        $this->db->update('Gasto',$data,array('id_gasto' => $data['id_gasto']));
    }
    
    public function insert($data){
        $this->db->insert('Gasto',$data);
    }
}

?>
