<?php

/**
 * Description of productos
 *
 * @author cherra
 */
class Productos extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('catalogo/producto');
        $this->load->model('catalogo/linea');
    }
    
    private function guarda($data, $id_producto = ''){
            if(strlen($id_producto) > 0){
                //var_dump($data);
                //die();
                $this->producto->update($data);
                $this->msg['bien'] = 'Producto modificado con éxito';
                //redirect('catalogo/usuarios/modifica/'.$id_usuario);
            }else{
                $this->producto->insert($data);
                $this->msg['bien'] = 'Producto registrado';
            }
    }
    
    public function alta(){
        $data = $this->input->post();
        if($data){
            $this->guarda($data);
        }
        $data['lineas'] = $this->linea->get();
        $this->load->view('catalogo/producto/alta',$data);
    }
    
    public function listado(){
        $datos_busqueda = $this->input->post();
        $data['productos'] = $this->producto->get_por_linea($datos_busqueda?$datos_busqueda:NULL);
        $data['lineas'] = $this->linea->get();
        //$data['roles'] = $this->usuarios_model->getRolesPorUsuario($data['usuario']->id_usuario);
        $this->load->view('catalogo/producto/listado',$data);
    }
    
    public function modifica($id_producto = ''){
        $data = $this->input->post();
        if($data){
            $this->guarda($data,$id_producto);
        }
        //$data = $this->input->get();
        if(strlen($id_producto) > 0){
            $resultado['producto'] = $this->producto->get_por_id($id_producto);
            $resultado['lineas'] = $this->linea->get();
            $this->load->view('catalogo/producto/modifica',$resultado);
        }else{
            redirect('catalogo/productos/listado');
        }
    }
}

?>
