<?php
/**
 * Description of presentaciones
 *
 * @author cherra
 */
class Presentaciones extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('catalogo/subproducto');
        $this->load->model('catalogo/presentacion');
        $this->load->model('catalogo/precio');
    }
    
    private function guarda($data, $id_presentacion = ''){
            if(strlen($id_presentacion) > 0){
                //var_dump($data);
                //die();
                $this->presentacion->update($data);
                $this->msg['bien'] = 'Presentación modificada con éxito';
                //redirect('catalogo/usuarios/modifica/'.$id_usuario);
            }else{
                $this->presentacion->insert($data);
                $this->msg['bien'] = 'Presentación registrada';
            }
    }
    
    public function alta(){
        $data = $this->input->post();
        if($data){
            $this->guarda($data);
            
            $id_articulo = $this->db->insert_id();
            $listas = $this->precio->get_all_listas();
            foreach ($listas as $lista){
                $datos = array(
                    'id_lista' => $lista->id_lista,
                    'id_articulo' => $id_articulo
                );
                $this->db->insert('Articulo_Lista',$datos);
            }
        }
        $data['subproductos'] = $this->subproducto->get_por_producto();
        $this->load->view('catalogo/presentacion/alta',$data);
    }
    
    public function listado( $offset = 0 ){
        $this->load->model('catalogo/linea');
        $datos_busqueda = $this->session->userdata('filtros');

        $config['total_rows'] = $this->presentacion->get_num_por_linea($datos_busqueda['id_linea'], $datos_busqueda['nombre'], $datos_busqueda['con_codigo']);
        $config['base_url'] = base_url('catalogo/presentaciones/listado');
        
        $data['presentaciones'] = $this->presentacion->get_por_linea($datos_busqueda['id_linea'], $datos_busqueda['nombre'], $datos_busqueda['con_codigo'], $this->config->item('per_page'),$offset);
        $data['lineas'] = $this->linea->get(array('listado' => 's'));
        $data['filtros'] = $datos_busqueda;
        
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('catalogo/presentacion/listado',$data);
    }
    
    public function modifica($id_articulo = ''){
        $data = $this->input->post();
        if($data){
            $this->guarda($data,$id_articulo);
        }
        //$data = $this->input->get();
        if(strlen($id_articulo) > 0){
            $resultado['presentacion'] = $this->presentacion->get_por_id($id_articulo);
            $resultado['subproductos'] = $this->subproducto->get_all_con_codigo();
            $this->load->view('catalogo/presentacion/modifica',$resultado);
        }else{
            redirect('catalogo/presentaciones/listado');
        }
    }
    
    public function paquetes(){
        $this->load->model('catalogo/linea');
        $data['filtros'] = $this->session->userdata('filtros');
        $data['lineas'] = $this->linea->get(array('listado'=>'s'));
        $this->load->view('catalogo/presentacion/paquetes', $data);
    }
    
    public function descuentos(){
        $this->load->model('catalogo/linea');
        $datos_busqueda = $this->session->userdata('filtros');
        $data['lineas'] = $this->linea->get(array('listado'=>'s'));
        $data['filtros'] = $datos_busqueda;
        $this->load->view('catalogo/presentacion/descuentos',$data);
    }
}

?>
