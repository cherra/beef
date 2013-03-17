<div id="contenido">
    <br />
    <div style=" font-weight: bold;"><?php echo $lista['nombre']; ?></div><br />
    <?php echo form_open('catalogo/precios/lista_modifica/'.$lista['id_lista']); ?>
    <input type="hidden" name="id_lista" value="<?php echo $lista['id_lista']; ?>"/>
    <table class="tabla-captura">
        <tr>
            <td style="width: 40%;"><label for="nombre">Nombre de la lista: </label></td>
            <td style="width: 60%;"><input type="text" name="nombre" id="nombre" value="<?php echo $lista['nombre']; ?>" /></td>
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