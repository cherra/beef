<?php
/**
 * Controlador para solicitudes por medio de ajax
 * Por default, el ACL no incluye esta clase en los permisos.
 *
 * @author cherra
 */
class Ajax extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
    }

    public function get_precios($id_lista='', $id_linea='', $nombre=''){
        if(($data = $this->input->post())){
            $id_lista = $data['id_lista'];
            $id_linea = $data['id_linea'];
            $nombre = $data['nombre'];
        }
        $this->load->model('catalogo/precio');
        $filtros = array(
            'id_lista' => $id_lista,
            'id_linea' => $id_linea,
            'nombre' => $nombre
        );
        $precios = $this->precio->get_precios($filtros);
        
        echo json_encode($precios,JSON_FORCE_OBJECT);
    }
    
    public function get_precios_descuentos($id_lista='', $id_cliente='', $nombre = '', $id_linea = ''){
        if(($data = $this->input->post())){
            $id_lista = $data['id_lista'];
            $id_cliente = $data['id_cliente'];
            $nombre = $data['nombre'];
            $id_linea = $data['id_linea'];
        }
        $this->load->model('catalogo/precio');
        $filtros = array(
            'id_lista' => $id_lista,
            'id_cliente' => $id_cliente,
            'id_linea' => $id_linea,
            'nombre' => $nombre
        );
        $precios = $this->precio->get_precios_descuentos($filtros);
        //echo $nombre;
        //echo $this->db->last_query();
        echo json_encode($precios,JSON_FORCE_OBJECT);
    }
        
    public function update_precio($id_articulo, $id_lista, $precio, $precio_minimo){
        $this->load->model('catalogo/precio');
        $this->precio->update_precio($id_articulo, $id_lista, $precio, $precio_minimo);
    }
    
    public function update_descuento($id_articulo = '', $id_cliente = '', $descuento = ''){
        if(($data = $this->input->post())){
            $id_articulo = $data['id_articulo'];
            $id_cliente = $data['id_cliente'];
            $descuento = $data['descuento'];
        }
        
        $this->load->model('catalogo/precio');
        $this->precio->update_descuento($id_articulo, $id_cliente, $descuento);
    }
    
    public function get_descuento_presentacion_cliente($id_articulo = ''){
        if(($data = $this->input->post())){
            $id_articulo = $data['id_articulo'];
        }
        $this->load->model('catalogo/precio');
        $descuentos = $this->precio->get_descuento_presentacion_cliente($id_articulo);
        echo json_encode($descuentos, JSON_FORCE_OBJECT);
    }
    
    public function update_descuento_presentacion_cliente($id_articulo = '', $id_cliente = '', $descuento = 0 ){
        if(($data = $this->input->post())){
            $id_articulo = $data['id_articulo'];
            $id_cliente = $data['id_cliente'];
            $descuento = $data['descuento'];
        }
        $this->load->model('catalogo/precio');
        $this->precio->update_descuento_presentacion_cliente($id_articulo, $id_cliente, $descuento);
    }
    
    public function update_cliente_lista($id_cliente, $id_lista){
        $this->load->model('catalogo/cliente');
        $this->cliente->update_lista($id_cliente, $id_lista);
    }
    
    public function get_clientes($nombre = ''){
        if(($data = $this->input->post()))
            $nombre = $data['nombre'];
        $this->load->model('catalogo/cliente');
        
        $clientes = $this->cliente->get(array('nombre' => $nombre),100);
        echo json_encode($clientes,JSON_FORCE_OBJECT);
    }
    
    public function get_proveedores($razon_social = ''){
        if(($data = $this->input->post()))
            $razon_social = $data['razon_social'];
        $this->load->model('catalogo/proveedor');
        
        $proveedores = $this->proveedor->get(array('razon_social' => $razon_social),100);
        echo json_encode($proveedores,JSON_FORCE_OBJECT);
    }
    
    public function get_productos_por_proveedor(){ //$mostrar = todos || asignados || no-asignados
        if(($data = $this->input->post())){
            $id_proveedor = $data['id_proveedor'];
            $id_linea = $data['id_linea'];
            $nombre = $data['nombre'];
            $mostrar = $data['mostrar'];
        }
        $this->load->model('catalogo/proveedor');
        
        $proveedores = $this->proveedor->get_productos($id_proveedor, $id_linea, $nombre, $mostrar);
        echo json_encode($proveedores,JSON_FORCE_OBJECT);
    }
    
    public function set_producto_proveedor(){
        if(($data = $this->input->post())){
            $id_proveedor = $data['id_proveedor'];
            $id_producto = $data['id_producto'];
            
            $this->load->model('catalogo/proveedor');
            $this->proveedor->set_producto($id_proveedor, $id_producto);
        }
    }
    
    public function unset_producto_proveedor(){
        if(($data = $this->input->post())){
            $id_proveedor = $data['id_proveedor'];
            $id_producto = $data['id_producto'];
            
            $this->load->model('catalogo/proveedor');
            $this->proveedor->unset_producto($id_proveedor, $id_producto);
        }
    }
    
    public function get_gastos_por_proveedor(){ //$mostrar = todos || asignados || no-asignados
        if(($data = $this->input->post())){
            $id_proveedor = $data['id_proveedor'];
            $nombre = $data['nombre'];
            $mostrar = $data['mostrar'];
        }
        $this->load->model('catalogo/proveedor');
        
        $proveedores = $this->proveedor->get_gastos($id_proveedor, $nombre, $mostrar);
        echo json_encode($proveedores,JSON_FORCE_OBJECT);
    }
    
    public function set_gasto_proveedor(){
        if(($data = $this->input->post())){
            $id_proveedor = $data['id_proveedor'];
            $id_gasto = $data['id_gasto'];
            
            $this->load->model('catalogo/proveedor');
            $this->proveedor->set_gasto($id_proveedor, $id_gasto);
        }
    }
    
    public function unset_gasto_proveedor(){
        if(($data = $this->input->post())){
            $id_proveedor = $data['id_proveedor'];
            $id_gasto = $data['id_gasto'];
            
            $this->load->model('catalogo/proveedor');
            $this->proveedor->unset_gasto($id_proveedor, $id_gasto);
        }
    }
    
    public function get_presentaciones(){
        if(($data = $this->input->post())){
            $nombre = $data['nombre'];
            $id_linea = $data['id_linea'];
        }
        $this->load->model('catalogo/presentacion');
        $presentaciones = $this->presentacion->get_por_linea($id_linea, $nombre);
        echo json_encode($presentaciones,JSON_FORCE_OBJECT);
    }
    
    public function get_presentaciones_fuera_paquete(){
        if(($data = $this->input->post())){
            $nombre = $data['nombre'];
            $id_linea = $data['id_linea'];
            $id_articulo = $data['id_articulo'];
        }
        $this->load->model('catalogo/paquete');
        $presentaciones = $this->paquete->get_presentaciones_fuera($id_articulo, $nombre, $id_linea);
        echo json_encode($presentaciones, JSON_FORCE_OBJECT);
        //echo $this->db->last_query();
    }
    
    public function get_presentaciones_dentro_paquete(){
        if(($data = $this->input->post())){
            $id_articulo = $data['id_articulo'];
        }
        $this->load->model('catalogo/paquete');
        $presentaciones = $this->paquete->get_presentaciones($id_articulo);
        echo json_encode($presentaciones, JSON_FORCE_OBJECT);
        //echo $this->db->last_query();
    }
    
    public function set_presentacion_paquete(){
        if(($data = $this->input->post())){
            $id_articulo = $data['id_articulo'];
            $id_articulo_paquete = $data['id_articulo_paquete'];
            
            $this->load->model('catalogo/paquete');
            $this->paquete->set_presentacion($id_articulo, $id_articulo_paquete);
        }
    }
    
    public function set_cantidad_presentacion_paquete(){
        if(($data = $this->input->post())){
            $id_articulo_paquete = $data['id_articulo_paquete'];
            $id_articulo = $data['id_articulo'];
            $cantidad = $data['cantidad'];
            
            $this->load->model('catalogo/paquete');
            $this->paquete->update_cantidad($id_articulo, $id_articulo_paquete, $cantidad);
        }
    }
    
    public function delete_presentacion_paquete(){
        if(($data = $this->input->post())){
            $id_articulo = $data['id_articulo'];
            $id_articulo_paquete = $data['id_articulo_paquete'];
            
            $this->load->model('catalogo/paquete');
            $this->paquete->delete_presentacion($id_articulo, $id_articulo_paquete);
        }
    }
    
    public function session_registra_valor(){
        if(($variables = $this->input->post())){
            foreach($variables as $key => $valor){
                $this->session->set_userdata($key, $valor);
            }
        }
    }
    
    public function session_obten_valor($key){
        $valor = $this->session->userdata($key);
        echo $valor;
    }
}

