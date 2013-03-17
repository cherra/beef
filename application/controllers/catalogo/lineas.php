<?php

/**
 * Description of lineas
 *
 * @author cherra
 */
class Lineas extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('catalogo/linea');
    }
    
    private function guarda($data, $id_linea = ''){
        if(strlen($id_linea) > 0){
            //var_dump($data);
            //die();
            $this->linea->update($data);
            $this->msg['bien'] = 'Linea modificada con éxito';
            //redirect('catalogo/usuarios/modifica/'.$id_usuario);
        }else{
            $this->linea->insert($data);
            $this->msg['bien'] = 'Linea registrada con número: '.$this->db->insert_id();
        }
    }
    
    public function alta(){
        $data = $this->input->post();
        if($data){
            $this->guarda($data);
        }
        $this->load->view('catalogo/linea/alta');
    }
    
    public function listado(){
        $datos_busqueda = $this->input->post();
        
        $data['lineas'] = $this->linea->get($datos_busqueda?$datos_busqueda:NULL);
        $this->load->view('catalogo/linea/listado',$data);
    }
    
    public function modifica($id_linea = ''){
        $data = $this->input->post();
        if($data){
            $this->guarda($data,$id_linea);
        }
        //$data = $this->input->get();
        if(strlen($id_linea) > 0){
            $resultado['linea'] = $this->linea->get_por_id($id_linea);
            $this->load->view('catalogo/linea/modifica',$resultado);
        }else
            redirect('catalogo/lineas/listado');
    }
}

?>
