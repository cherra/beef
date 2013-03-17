<?php

/**
 * Description of lineas
 *
 * @author cherra
 */
class Proveedores extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('catalogo/proveedor');
    }
    
    private function guarda($data, $id = ''){
        if(strlen($id) > 0){
            $this->proveedor->update($data);
            $this->msg['bien'] = 'Proveedor modificado con éxito';
        }else{
            $this->proveedor->insert($data);
            $this->msg['bien'] = 'Proveedor registrado';
        }
    }
    
    public function alta(){
        $data = $this->input->post();
        if($data){
            $this->guarda($data);
        }
        $this->load->view('catalogo/proveedor/alta');
    }
    
    public function listado($offset = 0){
        $datos_busqueda = $this->session->userdata('filtros');
        
        $config['total_rows'] = $this->proveedor->get_num($datos_busqueda?$datos_busqueda:NULL);
        $config['base_url'] = base_url('catalogo/proveedores/listado');
        $data['proveedores'] = $this->proveedor->get($datos_busqueda?$datos_busqueda:NULL,$this->config->item('per_page'),$offset);
        
        $data['filtros'] = $datos_busqueda;
        
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('catalogo/proveedor/listado',$data);
    }
    
    public function modifica($id = ''){
        $data = $this->input->post();
        if($data){
            $this->guarda($data,$id);
        }

        if(strlen($id) > 0){
            $resultado['proveedor'] = $this->proveedor->get_por_id($id);
            $this->load->view('catalogo/proveedor/modifica',$resultado);
        }else
            redirect('catalogo/proveedores/listado');
    }
    
    public function productos(){
        $this->load->model('catalogo/linea');
        $data['lineas'] = $this->linea->get(array('listado' => 's'));
        
        $this->load->view('catalogo/proveedor/productos',$data);
    }
    
    public function gastos(){
        $this->load->view('catalogo/proveedor/gastos');
    }
}

?>
