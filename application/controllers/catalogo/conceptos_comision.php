<?php

/**
 * Description of lineas
 *
 * @author cherra
 */
class Conceptos_comision extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('catalogo/concepto_comision');
    }
    
    private function guarda($data, $id = ''){
        if(strlen($id) > 0){
            //var_dump($data);
            //die();
            $this->concepto_comision->update($data);
            $this->msg['bien'] = 'Concepto modificado con éxito';
            //redirect('catalogo/usuarios/modifica/'.$id_usuario);
        }else{
            $this->concepto_comision->insert($data);
            $this->msg['bien'] = 'Concepto registrado';
        }
    }
    
    public function alta(){
        $data = $this->input->post();
        if($data){
            $this->guarda($data);
        }
        $this->load->view('catalogo/concepto_comision/alta');
    }
    
    public function listado( $offset = 0 ){
        $datos_busqueda = $this->session->userdata('filtros');
        
        $config['total_rows'] = $this->concepto_comision->get_num($datos_busqueda?$datos_busqueda:NULL);
        //$config['base_url'] = base_url('catalogo/conceptos_comision/listado');
        
        $data['conceptos'] = $this->concepto_comision->get($datos_busqueda?$datos_busqueda:NULL,$this->config->item('per_page'),$offset);
        $data['filtros'] = $datos_busqueda;
        
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('catalogo/concepto_comision/listado',$data);
    }
    
    public function modifica($id = ''){
        $data = $this->input->post();
        if($data){
            $this->guarda($data,$id);
        }
        //$data = $this->input->get();
        if(strlen($id) > 0){
            $resultado['concepto'] = $this->concepto_comision->get_por_id($id);
            $this->load->view('catalogo/concepto_comision/modifica',$resultado);
        }else
            redirect('catalogo/conceptos_comision/listado');
    }
}

?>
