<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of paquete
 *
 * @author cherra
 */
class Paquete extends CI_Model {
    
    public function get_all(){
        $this->db->select('Articulo.*')->from('Articulo')->join('Paquete_Articulo','Articulo.id_articulo = Paquete_Articulo.id_articulo','left');
        $this->db->where('Paquete_Articulo.id_paquete_articulo IS NOT NULL');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get( $filtro = null ){
        $this->db->select('Articulo.*')->from('Articulo')->join('Paquete_Articulo','Articulo.id_articulo = Paquete_Articulo.id_articulo','left');
        $this->db->where('Paquete_Articulo.id_paquete_articulo IS NOT NULL');
        if(!is_null($filtro)){
            foreach($filtro as $key => $valor){
                $this->db->like($key,$valor);
            }
        }
        $this->db->order_by('Articulo.nombre');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_presentaciones( $id, $nombre = '', $id_linea = 0 ){
        $this->db->select('Articulo.*, Paquete_Articulo.cantidad, Subproducto.codigo AS codigo_subproducto')->from('Articulo')->join('Subproducto','Articulo.id_subproducto = Subproducto.id_subproducto')->join('Paquete_Articulo','Articulo.id_articulo = Paquete_Articulo.id_articulo_paquete');
        if( strlen($nombre) > 0)
            $this->db->where('Articulo.nombre', $nombre);
        if( $id_linea > 0 )
            $this->db->where('Articulo.id_linea', $id_linea);
        $this->db->where('Paquete_Articulo.id_articulo',$id);
        $this->db->where('Articulo.codigo IS NOT NULL');
        $this->db->order_by('Articulo.nombre');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_presentaciones_fuera( $id, $nombre = '', $id_linea = 0 ){
        $this->db->select('Articulo.*, Subproducto.codigo AS codigo_subproducto')->from('Articulo')->join('Subproducto','Articulo.id_subproducto = Subproducto.id_subproducto')->join('Paquete_Articulo','Paquete_Articulo.id_articulo_paquete = Articulo.id_articulo AND Paquete_Articulo.id_articulo = '.$id,'left');
        if( strlen($nombre) > 0)
            $this->db->like('Articulo.nombre', $nombre);
        if( $id_linea > 0 )
            $this->db->where('Articulo.id_linea', $id_linea);
        $this->db->where('Paquete_Articulo.id_articulo_paquete IS NULL');
        $this->db->where('Articulo.codigo IS NOT NULL');
        $this->db->order_by('Articulo.nombre');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function set_presentacion( $id_articulo, $id_articulo_paquete, $cantidad = 0 ){
        $this->db->insert('Paquete_Articulo', array('id_articulo'=>$id_articulo,'id_articulo_paquete'=>$id_articulo_paquete, 'cantidad' => $cantidad));
    }
    
    public function update_cantidad( $id_articulo, $id_articulo_paquete, $cantidad = 0 ){
        $this->db->update('Paquete_Articulo', array('cantidad'=>$cantidad), array('id_articulo'=>$id_articulo, 'id_articulo_paquete'=>$id_articulo_paquete));
    }
    
    public function delete_presentacion( $id_articulo, $id_articulo_paquete ){
        $this->db->delete('Paquete_Articulo', array('id_articulo'=>$id_articulo, 'id_articulo_paquete'=>$id_articulo_paquete));
    }
}

?>
