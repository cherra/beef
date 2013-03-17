<?php
/**
 * Description of cobranza
 *
 * @author cherra
 */
class Cobranza extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function cuentas_pendientes(){
        $this->load->model('catalogo/ruta_cobranza');
        $this->load->model('catalogo/concepto_pago');
        $this->load->model('catalogo/usuario');
        $data['rutas'] = $this->ruta_cobranza->get_all();
        $data['conceptos'] = $this->concepto_pago->get_all();
        $data['usuarios'] = $this->usuario->get_all_activos();
        $this->load->view('ingresos/cobranza/cuentas_pendientes',$data);
    }
    
    public function cheques_posfechados(){
        $this->load->view('ingresos/cobranza/cheques_posfechados');
    }
    
    public function registrar_cheque_posfechado(){
        $this->load->model('catalogo/concepto_pago');
        $this->load->model('catalogo/usuario');
        $data['conceptos'] = $this->concepto_pago->get_all();
        $data['usuarios'] = $this->usuario->get_all_activos();
        $this->load->view('ingresos/cobranza/registrar_cheque_posfechado', $data);
    }
    
    //
    // Métodos sólo para Ajax ...
    //
    public function get_cuentas_pendientes($filtros = array()){
        $this->load->model('ingresos/credito');
        if(($data = $this->input->post()))
            $filtros = $data;
       
        if($this->input->is_ajax_request()){
            $cuentas = $this->credito->get_cuentas_pendientes($filtros);
            echo json_encode($cuentas,JSON_FORCE_OBJECT);
        }
    }
    
    public function registrar_abono($datos = array()){
        if($this->input->is_ajax_request()){
            $this->load->model('ingresos/credito');
            if(($data = $this->input->post()))
                $datos = $data;
            $datos['depositado'] = 's';
            $this->credito->agregar_abono($datos);
            $registros = $this->db->affected_rows();
            echo $registros;
        }
    }
    
    public function listar_abonos($datos = array()){
        $this->load->model('ingresos/credito');
        if(($data = $this->input->post())){
            $datos = $data;
        }
        if($this->input->is_ajax_request()){
            $abonos = $this->credito->get_abonos($datos['id_venta']);
            echo json_encode($abonos, JSON_FORCE_OBJECT);
        }
    }
    
    public function get_cheques_posfechados($datos = array()){
        $this->load->model('ingresos/credito');
        if(($data = $this->input->post())){
            $datos = $data;
        }
        if($this->input->is_ajax_request()){
            $cheques = $this->credito->get_cheques_posfechados($datos);
            echo json_encode($cheques, JSON_FORCE_OBJECT);
        }
    }
    
    public function get_folios_cheque($filtros = array()){
        if(($filtros = $this->input->post())){
            if($this->input->is_ajax_request()){
                $this->load->model('ingresos/credito');
                $folios = $this->credito->get_folios_cheque($filtros['id_cheque_posfechado']);
                echo json_encode($folios, JSON_FORCE_OBJECT);
            }
        }
    }
    
    public function depositar_cheque($datos = array()){
        if(($datos = $this->input->post())){
            if($this->input->is_ajax_request()){
                $this->load->model('ingresos/credito');
                $cheque = $this->credito->get_cheque_por_id($datos['id_cheque_posfechado']);
                $folios = $this->credito->get_folios_cheque($datos['id_cheque_posfechado']);
                $i = 0;
                foreach ($folios as $folio){
                    $abono = array('id_venta' => $folio->id_venta,
                        'id_usuario' => $cheque->id_usuario,
                        'id_concepto_pago' => $cheque->id_concepto_pago,
                        'abono' => $folio->monto,
                        'monto_deposito' => $cheque->monto,
                        'fecha_pago' => $cheque->fecha_pago,
                        'fecha_deposito' => $datos['fecha_deposito'],
                        'hora' => 'CURTIME()',
                        'observaciones' => $cheque->observaciones,
                        'num_doc' => $cheque->num_doc,
                        'depositado' => 's');
                    $i += $this->credito->agregar_abono($abono);
                }
                // Si se registraron todos los abonos.
                if($i == count($folios)){
                    $this->credito->depositar_cheque($datos);
                    echo '1';
                }else {
                    echo '0';
                }
                
            }
        }
    }
    
    public function registrar_cheque(){
        if($this->input->is_ajax_request()){
            if($datos = $this->input->post()){
                $bien = true;
                //var_dump($datos['folios']);
                //die();
                $folios = $datos['folios'];
                array_pop($datos);
                $this->load->model('ingresos/credito');
                $resultado = $this->credito->registrar_cheque($datos);
                if($resultado > 0){
                    foreach($folios as $folio){
                        $chequeventa = array(
                            "id_cheque_posfechado" => $resultado,
                            "id_venta" => $folio
                        );
                        if(!($this->credito->registrar_folio_cheque($chequeventa))){
                            $bien = false;
                        }
                    }
                    echo $bien;
                }
            }
        }
    }
}

?>
