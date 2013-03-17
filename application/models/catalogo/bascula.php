<?php
/**
 * Description of bascula
 *
 * @author cherra
 */
class Bascula extends CI_Model{
    
    public function get_all($limit = null, $offset = null){
        
        if( !is_null($limit) && !is_null($offset)){
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get('Basculas');
        return $query->result();
    }
    
    public function get_num_all(){
        $query = $this->db->get('Basculas');
        return $query->num_rows();
    }
    
    public function get_por_id( $id ){
        $query = $this->db->get_where('Basculas',array('id_bascula'=>$id));
        return $query->row_array();
    }
}

?>
