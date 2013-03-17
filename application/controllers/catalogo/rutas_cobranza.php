<?php

/**
 * Description of lineas
 *
 * @author cherra
 */
class Rutas_cobranza extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('catalogo/ruta_cobranza');
    }
    
    private function guarda($data, $id_ruta_cobranza = ''){
        if(strlen($id_ruta_cobranza) > 0){
            //var_dump($data);
            //die();
            $this->ruta_cobranza->update($data);
            $this->msg['bien'] = 'Ruta modificada con éxito';
            //redirect('catalogo/usuarios/modifica/'.$id_usuario);
        }else{
            $this->ruta_cobranza->insert($data);
            $this->msg['bien'] = 'Ruta registrada';
        }
    }
    
    public function alta(){
        $data = $this->input->post();
        if($data){
            $this->guarda($data);
        }
        $this->load->view('catalogo/ruta_cobranza/alta');
    }
    
    public function listado(){
        $datos_busqueda = $this->input->post();
        
        $data['rutas'] = $this->ruta_cobranza->get($datos_busqueda?$datos_busqueda:NULL);
        $this->load->view('catalogo/ruta_cobranza/listado',$data);
    }
    
    public function modifica($id_ruta_cobranza = ''){
        $data = $this->input->post();
        if($data){
            $this->guarda($data,$id_ruta_cobranza);
        }
        //$data = $this->input->get();
        if(strlen($id_ruta_cobranza) > 0){
            $resultado['ruta'] = $this->ruta_cobranza->get_por_id($id_ruta_cobranza);
            $this->load->view('catalogo/ruta_cobranza/modifica',$resultado);
        }else
            redirect('catalogo/rutas_cobranza/listado');
    }
}

?>
