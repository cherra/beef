<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pedidos
 *
 * @author cherra
 */
class Pedidos extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('ingresos/pedido');
    }
    
    public function listado( $offset = 0 ){

        $datos_busqueda = $this->session->userdata('filtros');
        if(!isset($datos_busqueda['fecha']))
            $datos_busqueda['fecha'] = date ("Y-m-d");
        
        $config['total_rows'] = $this->pedido->get_num($datos_busqueda?$datos_busqueda:NULL);
        $config['base_url'] = base_url('ingresos/pedidos/listado');
        $data['pedidos'] = $this->pedido->get($datos_busqueda?$datos_busqueda:NULL,$this->config->item('per_page'),$offset);
        $data['filtros'] = $datos_busqueda;
        
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('ingresos/pedido/listado',$data);
    }
    
    public function cancela( $id_pedido ){
        if($this->input->is_ajax_request()){
            if($datos = $this->input->post()){
                if($datos['id_pedido'] > 0){
                    $resultado = $this->pedido->cancela($datos['id_pedido']);
                    echo $resultado;
                }
            }
        }
    }
}

?>
