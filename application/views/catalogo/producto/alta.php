<div id="contenido">
    <?php echo form_open('catalogo/productos/alta'); ?>
    <table class="tabla-captura">
        <tr>
            <td style="width: 40%;"><label for="nombre">Nombre del producto: </label></td>
            <td style="width: 60%;"><input type="text" name="nombre" id="nombre" /></td>
        </tr>
        <tr>
            <td><label for="id_linea">Línea: </label></td>
            <td>
                <select name="id_linea" id="id_linea">
                    <?php foreach($lineas AS $linea){ ?>
                    <option value="<?php echo $linea->id_linea; ?>"><?php echo $linea->nombre; ?></option>
                    <?php } ?>
                </select>
            </td>
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