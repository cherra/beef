<?php
/**
 * Description of precios
 *
 * @author cherra
 */
class Precios extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('catalogo/precio');
    }
    
    private function guarda($data, $id_lista = ''){
        if(strlen($id_lista) > 0){
            //var_dump($data);
            //die();
            $this->precio->update_lista($data);
            $this->msg['bien'] = 'Lista modificada con éxito';
            //redirect('catalogo/usuarios/modifica/'.$id_usuario);
        }else{
            $this->precio->insert_lista($data);
            $this->msg['bien'] = 'Lista registrada';
        }
    }

    public function lista_listado(){
        $data['listas'] = $this->precio->get_all_listas();
        $this->load->view('catalogo/precio/lista_listado',$data);
    }
    
    public function lista_modifica($id_lista = ''){
        $data = $this->input->post();
        if($data){
            $this->guarda($data,$id_lista);
        }
        //$data = $this->input->get();
        if(strlen($id_lista) > 0){
            $resultado['lista'] = $this->precio->get_lista_por_id($id_lista);
            $this->load->view('catalogo/precio/lista_modifica',$resultado);
        }else
            redirect('catalogo/precios/lista_listado');
    }
    
    public function lista_alta(){
        $this->load->model('catalogo/presentacion');

        $data = $this->input->post();
        if($data){
            $this->guarda($data);
            $id_lista = $this->db->insert_id();
            $presentaciones = $this->presentacion->get_all();
            foreach ($presentaciones as $presentacion){
                $datos = array(
                    'id_lista' => $id_lista,
                    'id_articulo' => $presentacion->id_articulo
                );
                $this->db->insert('Articulo_Lista',$datos);
            }
        }
        $this->load->view('catalogo/precio/lista_alta');
    }
    
    public function precio_cambia(){
        $this->load->model('catalogo/linea');
        
        /*$datos_busqueda = $this->input->post();
        if($datos_busqueda){
            $datos['precios'] = $this->presentacion->
        }*/
        $datos = array();
        $datos['listas'] = $this->precio->get_all_listas();
        $datos['lineas'] = $this->linea->get(array('listado' => 's'));
        $this->load->view('catalogo/precio/precio_cambia',$datos);
    }
    
    public function precio_listado(){
        $this->load->model('catalogo/linea');
        
        $datos_busqueda = $this->input->post();
        $datos = array();
        $datos['filtros'] = $datos_busqueda;
        $datos['precios'] = $this->precio->get_precios($datos_busqueda ? $datos_busqueda : null);
        $datos['listas'] = $this->precio->get_all_listas();
        $datos['lineas'] = $this->linea->get(array('listado' => 's'));
        $this->load->view('catalogo/precio/precio_listado',$datos);
    }

}

?>
