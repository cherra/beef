<?php

/**
 * Description of lineas
 *
 * @author cherra
 */
class Vendedores extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('catalogo/vendedor');
    }
    
    private function guarda($data, $id = ''){
        if(strlen($id) > 0){
            $this->vendedor->update($data);
            $this->msg['bien'] = 'Proveedor modificado con éxito';
        }else{
            $this->vendedor->insert($data);
            $this->msg['bien'] = 'Proveedor registrado';
        }
    }
    
    public function alta(){
        $data = $this->input->post();
        if($data){
            $this->guarda($data);
        }
        $this->load->view('catalogo/vendedor/alta');
    }
    
    public function listado($offset = 0){
        $datos_busqueda = $this->session->userdata('filtros');
        
        $config['total_rows'] = $this->vendedor->get_num($datos_busqueda?$datos_busqueda:NULL);
        $config['base_url'] = base_url('catalogo/vendedores/listado');
        $data['vendedores'] = $this->vendedor->get($datos_busqueda?$datos_busqueda:NULL,$this->config->item('per_page'),$offset);
        
        $data['filtros'] = $datos_busqueda;
        
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('catalogo/vendedor/listado',$data);
    }
    
    public function modifica($id = ''){
        $data = $this->input->post();
        if($data){
            $this->guarda($data,$id);
        }

        if(strlen($id) > 0){
            $resultado['vendedor'] = $this->vendedor->get_por_id($id);
            $this->load->view('catalogo/vendedor/modifica',$resultado);
        }else
            redirect('catalogo/vendedores/listado');
    }
}

?>
