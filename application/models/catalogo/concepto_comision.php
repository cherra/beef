<?php

/**
 * Description of linea
 *
 * @author cherra
 */
class Concepto_comision extends CI_Model{
    
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
        $query = $this->db->get('ConceptoComision');
        return $query->result();
    }
    
    public function get_num($filtro = null){
        if(!is_null($filtro)){
            foreach($filtro as $key => $valor){
                $this->db->like($key,$valor);
            }
        }
        $this->db->order_by('descripcion');
        $query = $this->db->get('ConceptoComision');
        return $query->num_rows();
    }
    
    public function get_por_id($id = ''){
        $this->db->where('id_concepto_comision',$id);
        $query = $this->db->get('ConceptoComision');
        return $query->row_array();
    }
    
    public function update($data){
        $this->db->update('ConceptoComision',$data,array('id_concepto_comision' => $data['id_concepto_comision']));
    }
    
    public function insert($data){
        $this->db->insert('ConceptoComision',$data);
    }
}

?>
