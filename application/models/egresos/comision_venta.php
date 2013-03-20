<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of comision_venta
 *
 * @author cherra
 */
class Comision_venta extends CI_Model{
    
    public function get_clientes_asignados( $filtros = array() ){
        $this->db->select('Cliente.*, Comision.*');
        $this->db->from('Cliente')->join('Comision',"Cliente.id_cliente = Comision.id_cliente")->join('Empleado','Comision.id_empleado = Empleado.id_empleado');
        if(isset($filtros['id_empleado']))
            $this->db->where('Comision.id_empleado', $filtros['id_empleado']);
        if(isset($filtros['nombre_cliente']))
            $this->db->where("Cliente.nombre LIKE '%".$filtros['nombre_cliente']."%'");
        $this->db->order_by('LTRIM(Cliente.nombre)');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function update_fecha_asignacion( $id_comision, $fecha ){
        $this->db->update('Comision', array('fecha' => $fecha), array('id_comision' => $id_comision));
        return $this->db->affected_rows();
    }
    
    public function get_clientes( $filtros = array() ){
        $this->db->select('Cliente.*, IFNULL(Comision.id_empleado,"") AS id_empleado, IFNULL(Comision.fecha,"") AS fecha, IFNULL(Comision.id_comision,"") AS id_comision, IFNULL(Empleado.nombre,"") AS nombre_empleado', FALSE);
        $this->db->from('Cliente')->join('Comision','Cliente.id_cliente = Comision.id_cliente','left')->join('Empleado','Comision.id_empleado = Empleado.id_empleado','left');
        //if(isset($filtros['id_empleado']))
         //   $this->db->where('Comision.id_empleado', $filtros['id_empleado']);
        if(isset($filtros['nombre_cliente']))
            $this->db->where("Cliente.nombre LIKE '%".$filtros['nombre_cliente']."%'");
        $this->db->order_by('LTRIM(Cliente.nombre)');
        $this->db->limit(200);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function asignar_cliente( $id_cliente, $id_empleado, $fecha ){
        $this->db->delete('Comision', array('id_cliente' => $id_cliente));
        
        $this->db->insert('Comision', array('id_cliente' => $id_cliente, 'id_empleado' => $id_empleado, 'fecha' => $fecha, 'id_usuario' => $this->session->userdata('userid')));
        return $this->db->affected_rows();
    }
    
    public function quitar_cliente( $id_cliente ){
        $this->db->delete('Comision', array('id_cliente' => $id_cliente));
        return $this->db->affected_rows();
    }
}

?>
