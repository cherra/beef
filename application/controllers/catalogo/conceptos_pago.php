<?php

/**
 * Description of lineas
 *
 * @author cherra
 */
class Conceptos_pago extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('catalogo/concepto_pago');
    }
    
    private function guarda($data, $id = ''){
        if(strlen($id) > 0){
            //var_dump($data);
            //die();
            $this->concepto_pago->update($data);
            $this->msg['bien'] = 'Concepto modificado con éxito';
            //redirect('catalogo/usuarios/modifica/'.$id_usuario);
        }else{
            $this->concepto_pago->insert($data);
            $this->msg['bien'] = 'Concepto registrado';
        }
    }
    
    public function alta(){
        $data = $this->input->post();
        if($data){
            $this->guarda($data);
        }
        $this->load->view('catalogo/concepto_pago/alta');
    }
    
    public function listado( $offset = 0 ){
        $datos_busqueda = $this->session->userdata('filtros');
        
        $config['total_rows'] = $this->concepto_pago->get_num($datos_busqueda?$datos_busqueda:NULL);
        $config['base_url'] = base_url('catalogo/conceptos_pago/listado');
        
        $data['conceptos'] = $this->concepto_pago->get_all($datos_busqueda?$datos_busqueda:NULL,$this->config->item('per_page'),$offset);
        $data['filtros'] = $datos_busqueda;
        
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('catalogo/concepto_pago/listado',$data);
    }
    
    public function modifica($id = ''){
        $data = $this->input->post();
        if($data){
            $this->guarda($data,$id);
        }
        //$data = $this->input->get();
        if(strlen($id) > 0){
            $resultado['concepto'] = $this->concepto_pago->get_por_id($id);
            $this->load->view('catalogo/concepto_pago/modifica',$resultado);
        }else
            redirect('catalogo/conceptos_pago/listado');
    }
    
    // Métodos para peticiones por medio de Ajax
    
    public function get_concepto_pago(){
        if(($data = $this->input->post())){
            $id_concepto_pago = $data['id_concepto_pago'];
            $this->load->model('catalogo/concepto_pago');
            $concepto_pago = $this->concepto_pago->get_por_id($id_concepto_pago);
            if($this->input->is_ajax_request()){
                echo json_encode($concepto_pago, JSON_FORCE_OBJECT);
            }else{
                return $concepto_pago;
            }
        }

    }
}

?>
