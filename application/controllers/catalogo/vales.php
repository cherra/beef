<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vales
 *
 * @author cherra
 */
class Vales extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('catalogo/vale');
    }
    
    private function guarda($data, $id_concepto = ''){
        if(strlen($id_concepto) > 0){
            $this->vale->update($data);
            $this->msg['bien'] = 'Vale modificado con éxito';
        }else{
            $this->vale->insert($data);
            $this->msg['bien'] = 'Vale registrado';
        }
    }
    
    public function alta(){
        $data = $this->input->post();
        if($data){
            $this->guarda($data);
        }
        $this->load->view('catalogo/vale/alta');
    }
    
    public function listado(){
        $datos_busqueda = $this->input->post();
        
        $data['vales'] = $this->vale->get($datos_busqueda?$datos_busqueda:NULL);
        $data['filtros'] = $datos_busqueda;
        $this->load->view('catalogo/vale/listado',$data);
    }
    
    public function modifica($id_concepto = ''){
        $data = $this->input->post();
        if($data){
            $this->guarda($data,$id_concepto);
        }
        if(strlen($id_concepto) > 0){
            $resultado['vale'] = $this->vale->get_por_id($id_concepto);
            $this->load->view('catalogo/vale/modifica',$resultado);
        }else
            redirect('catalogo/vales/listado');
    }
}

?>
