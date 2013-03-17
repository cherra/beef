<?php
/**
 * Description of permiso
 *
 * @author cherra
 */
class Permiso extends CI_Model {
    
    public function get($filtro = NULL){
        if(!is_null($filtro)){
            $this->db->like('permName',$filtro['permName']);
        }
        $this->db->order_by('folder, class, method');
        $query = $this->db->get('perm_data');
        return $query->result();
    }
    
    public function get_por_id($id = ''){
        $this->db->where('ID',$id);
        $query = $this->db->get('perm_data');
        return $query->row_array();
    }
    
    public function update($data){
        $datos = array(
            'permName' => $data['permName'],
            'submenu' => $data['submenu'],
            'menu' => isset($data['menu']) ? $data['menu'] : 0
        );
        
        $this->db->update('perm_data',$datos,array('ID' => $data['ID']));
    }
}

?>
