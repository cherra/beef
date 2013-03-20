<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of comisiones_por_clientes
 *
 * @author cherra
 */
class Comisiones_ventas extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('egresos/comision_venta');
    }
    
    public function asignacion_clientes(){
        $this->load->view('egresos/comision_venta/asignacion_cliente');
    }
    
    
    // Controladores para Ajax
    
    public function get_vendedores(){
        if($this->input->is_ajax_request()){
            if($datos_busqueda = $this->input->post()){
                $this->load->model('catalogo/vendedor');
                $vendedores = $this->vendedor->get( $datos_busqueda );
                echo json_encode($vendedores, JSON_FORCE_OBJECT);
            }
        }
    }
    
    public function get_clientes_asignados(){
        if($this->input->is_ajax_request()){
            if($datos_busqueda = $this->input->post()){
                $this->load->model('egresos/comision_venta');
                $clientes = $this->comision_venta->get_clientes_asignados( $datos_busqueda );
                echo json_encode($clientes, JSON_FORCE_OBJECT);
            }
        }
    }
    
    public function update_fecha_asignacion(){
        if($this->input->is_ajax_request()){
            if($datos = $this->input->post()){
                $this->load->model('egresos/comision_venta');
                $resultado = $this->comision_venta->update_fecha_asignacion( $datos['id_comision'], $datos['fecha'] );
                echo $resultado;
            }
        }
    }
}

?>
