<?php

/**
 * Description of lineas
 *
 * @author cherra
 */
class Empresas extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('catalogo/empresa');
    }
    
    private function guarda($data, $id = ''){
        if(strlen($id) > 0){
            //var_dump($data);
            //die();
            $this->empresa->update($data);
            $this->msg['bien'] = 'Empresa modificada con éxito';
            //redirect('catalogo/usuarios/modifica/'.$id_usuario);
        }else{
            $this->empresa->insert($data);
            $this->msg['bien'] = 'Empresa registrada';
        }
    }
    
    public function alta(){
        $data = $this->input->post();
        if($data){
            $this->guarda($data);
        }
        $this->load->view('catalogo/empresa/alta');
    }
    
    public function listado( $offset = 0 ){
        $datos_busqueda = $this->session->userdata('filtros');
        
        $config['total_rows'] = $this->empresa->get_num($datos_busqueda?$datos_busqueda:NULL);
        $config['base_url'] = base_url('catalogo/conceptos_comision/listado');
        
        $data['empresas'] = $this->empresa->get($datos_busqueda?$datos_busqueda:NULL,$this->config->item('per_page'),$offset);
        $data['filtros'] = $datos_busqueda;
        
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('catalogo/empresa/listado',$data);
    }
    
    public function modifica($id = ''){
        $data = $this->input->post();
        if($data){
            $this->guarda($data,$id);
        }
        //$data = $this->input->get();
        if(strlen($id) > 0){
            $resultado['empresa'] = $this->empresa->get_por_id($id);
            $this->load->view('catalogo/empresa/modifica',$resultado);
        }else
            redirect('catalogo/empresas/listado');
    }
}

?>
