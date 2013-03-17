<?php

/**
 * Description of lineas
 *
 * @author cherra
 */
class Gastos extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('catalogo/gasto');
    }
    
    private function guarda($data, $id_gasto = ''){
        if(strlen($id_gasto) > 0){
            //var_dump($data);
            //die();
            $this->gasto->update($data);
            $this->msg['bien'] = 'Gasto modificado con éxito';
            //redirect('catalogo/usuarios/modifica/'.$id_usuario);
        }else{
            $this->gasto->insert($data);
            $this->msg['bien'] = 'Gasto registrado';
        }
    }
    
    public function alta(){
        $data = $this->input->post();
        if($data){
            $this->guarda($data);
        }
        $this->load->view('catalogo/gasto/alta');
    }
    
    public function listado( $offset = 0 ){
        $datos_busqueda = $this->session->userdata('filtros');
        
        $config['total_rows'] = $this->gasto->get_num($datos_busqueda?$datos_busqueda:NULL);
        $config['base_url'] = base_url('catalogo/gastos/listado');
        
        $data['gastos'] = $this->gasto->get($datos_busqueda?$datos_busqueda:NULL,$this->config->item('per_page'),$offset);
        $data['filtros'] = $datos_busqueda;
        
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('catalogo/gasto/listado',$data);
    }
    
    public function modifica($id_gasto = ''){
        $data = $this->input->post();
        if($data){
            $this->guarda($data,$id_gasto);
        }
        //$data = $this->input->get();
        if(strlen($id_gasto) > 0){
            $resultado['gasto'] = $this->gasto->get_por_id($id_gasto);
            $this->load->view('catalogo/gasto/modifica',$resultado);
        }else
            redirect('catalogo/gastos/listado');
    }
}

?>
