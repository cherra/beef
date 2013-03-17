<?php

/**
 * Description of linea
 *
 * @author cherra
 */
class Concepto_pago extends CI_Model{
    
    public function get_all($filtro = null, $limit = null, $offset = 0){
        if(!is_null($filtro)){
            foreach($filtro as $key => $valor){
                $this->db->like($key,$valor);
            }
        }
        
        if( !is_null($limit) ){
            $this->db->limit($limit, $offset);
        }
        
        $this->db->order_by('id_concepto_pago');
        $query = $this->db->get('ConceptoPago');
        return $query->result();
    }
    
    public function get_num($filtro = null){
        if(!is_null($filtro)){
            foreach($filtro as $key => $valor){
                $this->db->like($key,$valor);
            }
        }
        $this->db->order_by('concepto_pago');
        $query = $this->db->get('ConceptoPago');
        return $query->num_rows();
    }
    
    public function get_por_id($id = ''){
        $this->db->where('id_concepto_pago',$id);
        $query = $this->db->get('ConceptoPago');
        return $query->row_array();
    }
    
    public function update($data){
        $this->db->update('ConceptoPago',$data,array('id_concepto_pago' => $data['id_concepto_pago']));
    }
    
    public function insert($data){
        $this->db->insert('ConceptoPago',$data);
    }
}

?>
