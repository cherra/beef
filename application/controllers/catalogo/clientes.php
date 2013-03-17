<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clientes
 *
 * @author cherra
 */
class Clientes extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('catalogo/cliente');
    }

    private function guarda($data, $id_cliente = ''){
            if(strlen($id_cliente) > 0){
                //var_dump($data);
                //die();
                $this->cliente->update($data);
                $this->msg['bien'] = 'Cliente modificado con éxito';
                //redirect('catalogo/usuarios/modifica/'.$id_usuario);
            }else{
                if(strlen($data['rfc']) > 0 && $data['tipo_impresion'] == 'factura'){
                    $result = $this->cliente->get_ultima_cuenta_contable();
                    $data['cuenta_contable'] = $result['cuenta_contable'] + 1;
                }
                $this->cliente->insert($data);
                $this->msg['bien'] = 'Cliente registrado';
            }
    }
    
    public function alta(){
        $data = $this->input->post();
        if($data){
            $this->guarda($data);
        }
        $this->load->view('catalogo/cliente/alta',$data);
    }
    
    public function listado( $offset = 0 ){

        $datos_busqueda = $this->session->userdata('filtros');
        
        $config['total_rows'] = $this->cliente->get_num($datos_busqueda?$datos_busqueda:NULL);
        $config['base_url'] = base_url('catalogo/clientes/listado');
        $data['clientes'] = $this->cliente->get($datos_busqueda?$datos_busqueda:NULL,$this->config->item('per_page'),$offset);
        $data['filtros'] = $datos_busqueda;
        
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('catalogo/cliente/listado',$data);
    }
    
    public function modifica($id_cliente = ''){
        $data = $this->input->post();
        if($data){
            $this->guarda($data,$id_cliente);
        }

        if(strlen($id_cliente) > 0){
            $resultado['cliente'] = $this->cliente->get_por_id($id_cliente);
            $this->load->view('catalogo/cliente/modifica',$resultado);
        }else{
            redirect('catalogo/clientes/listado');
        }
    }
    
    public function precios(){
        $this->load->model('catalogo/precio');
        $this->load->model('catalogo/linea');
        $data['listas'] = $this->precio->get_all_listas();
        $data['lineas'] = $this->linea->get(array('listado' => 's'));
        $this->load->view('catalogo/cliente/precios',$data);
    }
    
    public function credito($id_cliente = ''){
        $this->load->model('catalogo/ruta_cobranza');
        $data = $this->input->post();
        if($data){
            $this->guarda($data,$id_cliente);
        }

        if(strlen($id_cliente) > 0){
            $resultado['cliente'] = $this->cliente->get_por_id($id_cliente);
            $resultado['rutas_cobranza'] = $this->ruta_cobranza->get_all();
            $this->load->view('catalogo/cliente/credito',$resultado);
        }else{
            redirect('catalogo/clientes/listado');
        }
    }
}

?>
