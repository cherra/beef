<?php

/**
 * Description of linea
 *
 * @author cherra
 */
class Empresa extends CI_Model{
    
    public function get($filtro = null, $limit = null, $offset = 0){
        if(!is_null($filtro)){
            foreach($filtro as $key => $valor){
                $this->db->like($key,$valor);
            }
        }
        
        if( !is_null($limit) ){
            $this->db->limit($limit, $offset);
        }
        
        $this->db->order_by('nombre');
        $query = $this->db->get('Empresas');
        return $query->result();
    }
    
    public function get_num($filtro = null){
        if(!is_null($filtro)){
            foreach($filtro as $key => $valor){
                $this->db->like($key,$valor);
            }
        }
        $this->db->order_by('nombre');
        $query = $this->db->get('Empresas');
        return $query->num_rows();
    }
    
    public function get_por_id($id = ''){
        $this->db->where('id_empresa',$id);
        $query = $this->db->get('Empresas');
        return $query->row_array();
    }
    
    public function update($data){
        $this->db->update('Empresas',$data,array('id_empresa' => $data['id_empresa']));
    }
    
    public function insert($data){
        $this->db->insert('Empresas',$data);
    }
}

?>
