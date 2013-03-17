<div id="contenido">
    <br />
    <div style=" font-weight: bold;"><?php echo $linea['nombre']; ?></div><br />
    <?php echo form_open('catalogo/lineas/modifica/'.$linea['id_linea']); ?>
    <input type="hidden" name="id_linea" value="<?php echo $linea['id_linea']; ?>"/>
    <table class="tabla-captura">
        <tr>
            <td style="width: 40%;"><label for="nombre">Nombre de la línea: </label></td>
            <td style="width: 60%;"><input type="text" name="nombre" id="nombre" value="<?php echo $linea['nombre']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="listado">Mostrar en busquedas?: </label></td>
            <td><input type="checkbox" name="listado" id="listado" value="s" <?php if($linea['listado'] == 's') echo 'checked'; ?> /></td>
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