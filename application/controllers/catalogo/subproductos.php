<?php
/**
 * Description of subproductos
 *
 * @author cherra
 */
class Subproductos extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('catalogo/producto');
        $this->load->model('catalogo/subproducto');
    }
    
    private function guarda($data, $id_subproducto = ''){
            if(strlen($id_subproducto) > 0){
                //var_dump($data);
                //die();
                $this->subproducto->update($data);
                $this->msg['bien'] = 'Subproducto modificado con éxito';
                //redirect('catalogo/usuarios/modifica/'.$id_usuario);
            }else{
                $this->subproducto->insert($data);
                $this->msg['bien'] = 'Subproducto registrado';
            }
    }
    
    public function alta(){
        $data = $this->input->post();
        if($data){
            $this->guarda($data);
        }
        $data['productos'] = $this->producto->get_por_linea();
        $this->load->view('catalogo/subproducto/alta',$data);
    }
    
    public function listado(){
        $datos_busqueda = $this->input->post();
        $data['subproductos'] = $this->subproducto->get_por_producto($datos_busqueda?$datos_busqueda:NULL);
        $data['productos'] = $this->producto->get_por_linea();
        $data['filtros'] = $datos_busqueda;
        //$data['roles'] = $this->usuarios_model->getRolesPorUsuario($data['usuario']->id_usuario);
        $this->load->view('catalogo/subproducto/listado',$data);
    }
    
    public function modifica($id_subproducto = ''){
        $data = $this->input->post();
        if($data){
            $this->guarda($data,$id_subproducto);
        }
        //$data = $this->input->get();
        if(strlen($id_subproducto) > 0){
            $resultado['subproducto'] = $this->subproducto->get_por_id($id_subproducto);
            $resultado['productos'] = $this->producto->get_all();
            $this->load->view('catalogo/subproducto/modifica',$resultado);
        }else{
            redirect('catalogo/subproductos/listado');
        }
    }
}

?>
