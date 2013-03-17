<?php
/**
 * Description of precio
 *
 * @author cherra
 */
class Precio extends CI_Model {
    
    public function get_all_listas(){
        $this->db->order_by('nombre');
        $query = $this->db->get('Lista');
        return $query->result();
    }
    
    
    public function get_lista_por_id($id_lista = ''){
        $this->db->where('id_lista',$id_lista);
        $query = $this->db->get('Lista');
        return $query->row_array();
    }
    
    public function update_lista($data){
        $datos = array(
            'nombre' => $data['nombre'],
        );
        
        $this->db->update('Lista',$datos,array('id_lista' => $data['id_lista']));
    }
    
    public function insert_lista($data){
        $this->db->insert('Lista',$data);
    }
    
    public function get_precio($id_articulo, $id_lista){
        $query = $this->db->get_where('Articulo_Lista',array('id_articulo' => $id_articulo, 'id_lista' => $id_lista),1);
        return $query->row_array();
    }
    
    public function get_precios($filtros = ''){
        if($filtros){
            $this->db->select('Articulo.*, Subproducto.codigo AS codigo_subproducto, Articulo_Lista.precio, Articulo_Lista.precio_minimo, Linea.nombre AS nombre_linea')->from('Articulo')->join('Articulo_Lista','Articulo.id_articulo = Articulo_Lista.id_articulo')->join('Subproducto','Articulo.id_subproducto = Subproducto.id_subproducto')->join('Producto','Subproducto.id_producto = Producto.id_producto')->join('Linea','Producto.id_linea = Linea.id_linea');
            if($filtros['id_lista'] > 0)
                $this->db->where('Articulo_Lista.id_lista',$filtros['id_lista']);
            if( isset($filtros['nombre']) )
                $this->db->like('Articulo.nombre',$filtros['nombre'])->or_like('CONCAT(Subproducto.codigo,Articulo.codigo)',$filtros['nombre']);
            if( isset($filtros['id_linea']) )
                if( $filtros['id_linea']  > 0)
                    $this->db->where('Producto.id_linea',$filtros['id_linea']);
            $this->db->where('Articulo.codigo IS NOT NULL')->where('Subproducto.codigo IS NOT NULL');
            $this->db->where('Linea.listado','s');
            $this->db->group_by('Articulo.id_articulo')->order_by('Linea.nombre,codigo_subproducto, Articulo.codigo');

            $query = $this->db->get();
            return $query->result();
        }else
            return array();
    }
    
    public function get_precios_descuentos($filtros = ''){
        if($filtros){
            $this->db->select('Articulo.*, Subproducto.codigo AS codigo_subproducto, Articulo_Lista.precio, Articulo_Lista.precio_minimo, Linea.nombre AS nombre_linea, Tarjeta_Cliente.descuento' );
            $this->db->from('Articulo')->join('Articulo_Lista','Articulo.id_articulo = Articulo_Lista.id_articulo');
            $this->db->join('Subproducto','Articulo.id_subproducto = Subproducto.id_subproducto');
            $this->db->join('Producto','Subproducto.id_producto = Producto.id_producto');
            $this->db->join('Linea','Producto.id_linea = Linea.id_linea');
            $this->db->join('Tarjeta_Cliente','Articulo.id_articulo = Tarjeta_Cliente.id_articulo AND Tarjeta_Cliente.id_cliente = '.$filtros['id_cliente'],'left');
            //$this->db->join('Cliente','Tarjeta_Cliente.id_cliente = Cliente.id_cliente','left');
            if( strlen($filtros['nombre']) > 0 )
                $this->db->like('Articulo.nombre',$filtros['nombre']);
            if( $filtros['id_lista'] > 0 )
                $this->db->where('Articulo_Lista.id_lista',$filtros['id_lista']);
            if( $filtros['id_linea'] > 0 )
                $this->db->where('Linea.id_linea',$filtros['id_linea']);
            $this->db->where('Articulo.codigo IS NOT NULL')->where('Subproducto.codigo IS NOT NULL');
            $this->db->where('Linea.listado','s');
            $this->db->group_by('Articulo.id_articulo')->order_by('Linea.nombre,codigo_subproducto, Articulo.codigo');

            $query = $this->db->get();
            return $query->result();
        }else
            return array();
    }

    public function update_precio($id_articulo, $id_lista, $precio, $precio_minimo = 0){
        $datos = array(
            'id_articulo' => $id_articulo,
            'id_lista' => $id_lista,
            'precio' => $precio,
            'precio_minimo' => $precio_minimo
        );
        $this->db->where('id_articulo',$id_articulo);
        $this->db->where('id_lista',$id_lista);
        $this->db->update('Articulo_Lista',$datos);
    }
    
    public function update_descuento($id_articulo, $id_cliente, $descuento = 0){

        $datos = array(
            'id_articulo' => $id_articulo,
            'id_cliente' => $id_cliente,
            'descuento' => $descuento
        );
        
        $query = $this->db->get_where('Tarjeta_Cliente',array('id_articulo' => $id_articulo, 'id_cliente' => $id_cliente));
        
        if( $query->num_rows() > 0 ){
            $this->db->where('id_articulo',$id_articulo);
            $this->db->where('id_cliente',$id_cliente);
            if( $descuento != 0 ){
                $this->db->update('Tarjeta_Cliente',array('descuento' => $descuento));
            }else{
                $this->db->delete('Tarjeta_Cliente');
            }
        }else{
            $this->db->insert('Tarjeta_Cliente',$datos);
        }
    }
    
    public function get_descuento_presentacion_cliente($id_articulo){
        $this->db->select('Cliente.*, Articulo_Lista.*, Tarjeta_Cliente.*')->from('Articulo_Lista');
        $this->db->join('Tarjeta_Cliente','Articulo_Lista.id_articulo = Tarjeta_Cliente.id_articulo');
        $this->db->join('Cliente','Tarjeta_Cliente.id_cliente = Cliente.id_cliente AND Articulo_Lista.id_lista = Cliente.id_lista');
        $this->db->where('Articulo_Lista.id_articulo', $id_articulo)->group_by('Cliente.id_cliente');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function update_descuento_presentacion_cliente($id_articulo, $id_cliente, $descuento){
        $this->db->update('Tarjeta_Cliente',array('descuento'=>$descuento),array('id_articulo'=>$id_articulo, 'id_cliente'=>$id_cliente));
    }
}

?>
