<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vale
 *
 * @author cherra
 */
class Vale extends CI_Model {
    
    public function get($filtro = null){
        if(!is_null($filtro)){
            foreach($filtro as $key => $valor){
                $this->db->like($key,$valor);
            }
        }
        $this->db->order_by('concepto');
        $query = $this->db->get('Concepto_SalidasVarias');
        return $query->result();
    }
    
    public function get_por_id($id = ''){
        $this->db->where('id_concepto',$id);
        $query = $this->db->get('Concepto_SalidasVarias');
        return $query->row_array();
    }
    
    public function update($data){
        $datos = array(
            'concepto' => $data['concepto'],
            'codigo_barras' => array_key_exists('codigo_barras', $data) ? $data['codigo_barras'] : 'n',
            'tipo' => $data['tipo']
        );
        
        $this->db->update('Concepto_SalidasVarias',$datos,array('id_concepto' => $data['id_concepto']));
    }
    
    public function insert($data){
        $this->db->insert('Concepto_SalidasVarias',$data);
    }
}

?>
