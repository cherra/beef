<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cobranza
 *
 * @author cherra
 */
class Credito extends CI_Model{
    
    public function get_cuentas_pendientes($filtros = array()){
        $this->db->select("Cliente.id_cliente, Cliente.nombre");
        $this->db->select("Venta.fecha, Venta.id_venta, Venta.monto AS TotalVenta, Venta.id_venta, Venta.cancelada, Venta.vencimiento");
        $this->db->select("SUM(Abono.abono) AS TotalAbonos");
        $this->db->select("Venta.num_factura");
        $this->db->select("Abono.depositado AS AbonoDepositado, SUM(IF (Abono.depositado='n',Abono.abono,0) ) AS AbonosSinDepositar,  MAX(Abono.fecha_pago) AS AbonoFechaMax",false);
        $this->db->select("Cliente.lun, Cliente.mar, Cliente.mie, Cliente.jue, Cliente.vie, Cliente.sab, Cliente.dom, RutaCobranza.descripcion");
        $this->db->select("Cheque_Venta.id_cheque_posfechado");
        $this->db->from("Venta")->join("Cliente","Venta.id_cliente = Cliente.id_cliente");
        $this->db->join("RutaCobranza","RutaCobranza.id_ruta_cobranza = Cliente.id_ruta_cobranza","left");
        if(isset($filtros['mostrar'])){
            if($filtros['mostrar'] == "pagadas"){
                $this->db->join("Abono","Abono.id_venta = Venta.id_venta");
            }else{
                $this->db->join("Abono","Abono.id_venta = Venta.id_venta","left");
            }
            
            if($filtros['mostrar'] == "posfechados"){
                $this->db->join('Cheque_Venta','Venta.id_venta = Cheque_Venta.id_venta');
            }else{
                $this->db->join('Cheque_Venta','Venta.id_venta = Cheque_Venta.id_venta',"left");
            }
        }else{
            $this->db->join("Abono","Abono.id_venta = Venta.id_venta","left");
        }
        $this->db->where(array("Venta.tipo"=>"credito", "Venta.cancelada"=>"n"));
        
        if(isset($filtros['id_ruta'])){
            if($filtros['id_ruta'] > 0){
                $this->db->where("Cliente.id_ruta_cobranza",$filtros['id_ruta']);
            }
        }
        if(isset($filtros['dias_cobro'])){
            foreach($filtros['dias_cobro'] as $value){
                $this->db->where("Cliente.".$value,"s");
            }
        }
        /*if( ! empty($dias_cobro) ){
            $this->db->where($dias_cobro);
        }*/
        if(isset($filtros['nombre'])){
            if($filtros['nombre'] != ""){
                $this->db->where("(Cliente.nombre LIKE '%".$filtros['nombre']."%' OR Cliente.id_cliente = '".$filtros['nombre']."')");
            }
        }
        if(isset($filtros['folio_factura'])){
            if($filtros['folio_factura'] != ""){
                $this->db->where("(Venta.id_venta = ".$filtros['folio_factura']." OR Venta.num_factura = ".$filtros['folio_factura'].")");
            }
        }
        $this->db->where("( (Abono.fecha_pago BETWEEN '".$filtros['desde']."' AND '".$filtros['hasta']."') OR (Venta.fecha BETWEEN '".$filtros['desde']."' AND '".$filtros['hasta']."') )");
        /*if($filtros['mostrar'] == "pagadas" or $filtros['mostrar'] == "todas"){
            $this->db->where("( (Abono.fecha_pago BETWEEN '".$filtros['desde']."' AND '".$filtros['hasta']."') OR (Venta.fecha BETWEEN '".$filtros['desde']."' AND '".$filtros['hasta']."') )");
        }else if($filtros['mostrar'] == "abonos"){
            $this->db->where("Abono.fecha_pago BETWEEN '".$filtros['desde']."' AND '".$filtros['hasta']."'");
        }else if($filtros['mostrar'] == "no pagadas"){
            $this->db->where("Venta.fecha BETWEEN '".$filtros['desde']."' AND '".$filtros['hasta']."'");
        }*/
        
        $this->db->group_by("Venta.id_venta");
        
        if(isset($filtros['mostrar'])){
            if($filtros['mostrar'] == "" or $filtros['mostrar'] == "no pagadas" or $filtros['mostrar'] == 'posfechados'){
                $this->db->or_having("TotalVenta > TotalAbonos");
                $this->db->or_having("TotalAbonos IS NULL");
            }elseif($filtros['mostrar'] == "abonos"){
                $this->db->or_having("TotalVenta > TotalAbonos");
            }elseif($filtros['mostrar'] == "pagadas"){
                $this->db->having("TotalVenta <= TotalAbonos");
            }elseif($filtros['mostrar'] == 'sinposfechados'){
                $this->db->or_having("TotalVenta > TotalAbonos");
                $this->db->or_having("TotalAbonos IS NULL");
                $this->db->having('id_cheque_posfechado IS NULL');
            }
        }else{
            $this->db->or_having("TotalVenta > TotalAbonos");
            $this->db->or_having("TotalAbonos IS NULL");
        }
        $this->db->order_by("Cliente.id_cliente, Venta.id_venta");
        $query = $this->db->get();
        return $query->result();
    }
    
    public function agregar_abono($datos = array()){
        $this->db->insert('Abono',$datos);
        return $this->db->affected_rows();
    }
    
    public function get_abonos($id_venta){
        $this->db->select("Abono.id_abono, Abono.fecha_deposito, Abono.fecha_pago, CONCAT(Usuario.id_usuario,' ',Usuario.nombre) AS cobrador, Abono.abono, Abono.num_doc, IF(Abono.depositado='s','Si','No') AS depositado, Venta.monto", FALSE);
        //$this->db->select("Abono.id_abono, Abono.fecha_deposito, Abono.fecha_pago, Usuario.nombre AS cobrador, Abono.abono, Abono.num_doc, Abono.depositado, Venta.monto");
        $this->db->from("Abono");
        $this->db->join("Usuario","Usuario.id_usuario = Abono.id_usuario");
        $this->db->join("Venta","Venta.id_venta = Abono.id_venta");
        $this->db->where("Abono.id_venta", $id_venta);
        $this->db->order_by("Abono.id_venta");

        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_cheque_por_id($id_cheque_posfechado){
        $this->db->where('id_cheque_posfechado', $id_cheque_posfechado);
        $query = $this->db->get('ChequePosfechado');
        return $query->row();
    }
    
    public function get_cheques_posfechados($filtros = array()){
        $this->db->select('Ch.id_cheque_posfechado, C.nombre, Ch.fecha_pago, Ch.fecha_deposito, Ch.num_doc, Ch.monto, Ch.depositado, V.id_venta');
        $this->db->from('Cliente AS C');
        $this->db->join('Venta AS V', 'C.id_cliente = V.id_cliente');
        $this->db->join('Cheque_Venta AS ChV', 'V.id_venta = ChV.id_venta');
        $this->db->join('ChequePosfechado AS Ch', 'ChV.id_cheque_posfechado = Ch.id_cheque_posfechado');
        if($filtros['nombre'] != ""){
            $this->db->where("(C.nombre LIKE '%".$filtros['nombre']."%' OR C.id_cliente = '".$filtros['nombre']."')");
        }
        if($filtros['folio_factura'] != ""){
            $this->db->where("(V.id_venta = ".$filtros['folio_factura']." OR V.num_factura = ".$filtros['folio_factura'].")");
        }
        if($filtros['mostrar'] == 'sin_depositar'){
            $this->db->where("Ch.depositado","n");
        }elseif ($filtros['mostrar'] == 'depositados'){
            $this->db->where("Ch.depositado","s");
        }
        $this->db->group_by('Ch.id_cheque_posfechado');
        $this->db->order_by('Ch.depositado, Ch.fecha_deposito');
        
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_folios_cheque($id_cheque_posfechado){
        $this->db->select("v.id_venta, CONCAT(ff.serie,ff.folio) AS factura, v.fecha, c.nombre, v.monto", FALSE);
        $this->db->from("ChequePosfechado AS ch")->join("Cheque_Venta AS chv", "ch.id_cheque_posfechado = chv.id_cheque_posfechado");
        $this->db->join("Venta AS v", "chv.id_venta = v.id_venta")->join("factura AS f", "v.id_factura = f.id_factura")->join("factura_folio AS ff","f.id_factura_folio = ff.id_factura_folio");
        $this->db->join("Cliente AS c", "v.id_cliente = c.id_cliente");
        $this->db->where("ch.id_cheque_posfechado", $id_cheque_posfechado);
        $this->db->order_by("v.id_venta");
        $query = $this->db->get();
        return $query->result();
    }
    
    public function depositar_cheque($datos = array()){
        $this->db->where('id_cheque_posfechado',$datos['id_cheque_posfechado']);
        $this->db->update("ChequePosfechado",array('depositado' => 's', 'fecha_deposito' => $datos['fecha_deposito']));
    }
    
    public function registrar_cheque($datos = array()){
        if(count($datos) > 0)
            $this->db->insert('ChequePosfechado', $datos);
        return $this->db->insert_id();
    }
    
    public function registrar_folio_cheque($datos = array()){
        if(count($datos) > 0){
            $this->db->insert('Cheque_Venta', $datos);
        }
        return $this->db->insert_id();
    }
}

?>
