<?php
/**
 * Description of ruta_cobranza
 *
 * @author cherra
 */
class Ruta_cobranza extends CI_Model{
    
    public function get_all(){
        $query = $this->db->order_by('descripcion')->get('RutaCobranza');
        return $query->result();
    }
    
    public function get($filtro = null){
        if(!is_null($filtro)){
            foreach($filtro as $key => $valor){
                $this->db->like($key,$valor);
            }
        }
        $this->db->order_by('descripcion');
        $query = $this->db->get('RutaCobranza');
        return $query->result();
    }
    
    public function get_por_id($id){
        $this->db->where('id_ruta_cobranza',$id);
        $query = $this->db->get('RutaCobranza');
        return $query->row_array();
    }
    
    public function insert($data){
        $this->db->insert('RutaCobranza',$data);
    }
    
    public function update($data){
        $datos = array(
            'descripcion' => $data['descripcion'],
        );
        
        $this->db->update('RutaCobranza',$datos,array('id_ruta_cobranza' => $data['id_ruta_cobranza']));
    }
}

?>
