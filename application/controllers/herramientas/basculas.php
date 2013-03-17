<?php
/**
 * Description of basculas
 *
 * @author cherra
 */
class Basculas extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('catalogo/bascula');
    }
    
    private function genera_archivo_berkel( $id_bascula, $id_lista = 1 ){
        $this->load->model('catalogo/presentacion');
        $this->load->model('catalogo/subproducto');
        $this->load->model('catalogo/precio');
        
        $presentaciones = $this->precio->get_precios(array('id_lista'=>$id_lista));
        $bascula = $this->bascula->get_por_id( $id_bascula );
        $contenido = "";
        foreach($presentaciones as $presentacion){
            //codigo
            $contenido .= str_pad($presentacion->codigo_subproducto.$presentacion->codigo,4,"0",STR_PAD_LEFT)." ";
            //nombre
            $contenido .= str_pad(substr($presentacion->nombre,0,35),36," ",STR_PAD_RIGHT);
            //precio
            $contenido .= str_pad(number_format($presentacion->precio,2),6," ",STR_PAD_LEFT)." ";
            //Peso o Pieza
            $contenido .= ($presentacion->tipo == 'peso' ? "0" : "1") . " ";
            //Bascula
            $contenido .= $bascula['codigo'];
            $contenido .= "\r\n";
        }
        return $contenido;
    }
    
    public function exportar_catalogo( $id_bascula = 0 ){
        $config['total_rows'] = $this->bascula->get_num_all();
        $config['base_url'] = base_url('catalogo/herramientas/exportar_catalogo');
        
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        
        if($id_bascula > 0){
            $this->load->helper('download');
            $contenido = $this->genera_archivo_berkel( $id_bascula );
            $nombre_archivo = "catalogo.txt";
            force_download($nombre_archivo, $contenido);
        }else{
            $data['basculas'] = $this->bascula->get_all();
            $this->load->view('herramientas/bascula/exportar_catalogo', $data);
        }
    }
}

?>
