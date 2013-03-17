<div id="contenido">
    <?php echo form_open('catalogo/subproductos/alta'); ?>
    <table class="tabla-captura">
        <tr>
            <td style="width: 40%;"><label for="nombre">Nombre del subproducto: </label></td>
            <td style="width: 60%;"><input type="text" name="nombre" id="nombre" /></td>
        </tr>
        <tr>
            <td><label for="codigo">Código: </label></td>
            <td><input type="text" name="codigo" id="codigo"/></td>
        </tr>
        <tr>
            <td><label for="id_producto">Producto: </label></td>
            <td>
                <select name="id_producto" id="id_producto">
                    <?php 
                    $nombre_linea = '';
                    foreach($productos AS $producto){ ?>
                    <?php if($nombre_linea != $producto->nombre_linea){ ?>
                    <option style="font-weight: bold;" value="0" disabled>----------</option>
                    <option style="font-weight: bold;" value="0" disabled><?php echo $producto->nombre_linea; ?></option>
                    <?php }?>
                    <option value="<?php echo $producto->id_producto; ?>"><?php echo $producto->nombre; ?></option>
                    <?php 
                    $nombre_linea = $producto->nombre_linea;
                    } ?>
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