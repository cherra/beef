<div id="contenido">
    <br />
    <div style=" font-weight: bold;"><?php echo $ruta['descripcion']; ?></div><br />
    <?php echo form_open('catalogo/rutas_cobranza/modifica/'.$ruta['id_ruta_cobranza']); ?>
    <input type="hidden" name="id_ruta_cobranza" value="<?php echo $ruta['id_ruta_cobranza']; ?>"/>
    <table class="tabla-captura">
        <tr>
            <td style="width: 40%;"><label for="descripcion">Nombre de la ruta: </label></td>
            <td style="width: 60%;"><input type="text" name="descripcion" id="descripcion" value="<?php echo $ruta['descripcion']; ?>" /></td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="Guardar" />
            </td>
        </tr>
    </table>
   
    <?php echo form_close(); ?>
    
</div>