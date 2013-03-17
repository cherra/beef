<div id="contenido">
    <br />
    <div style=" font-weight: bold;"><?php echo $producto['nombre']; ?></div><br />
    <?php echo form_open('catalogo/productos/modifica/'.$producto['id_producto']); ?>
    <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>"/>
    <table class="tabla-captura">
        <tr>
            <td style="width: 40%;"><label for="nombre">Nombre del producto: </label></td>
            <td style="width: 60%;"><input type="text" name="nombre" id="nombre" value="<?php echo $producto['nombre']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="id_linea">Línea: </label></td>
            <td>
                <select name="id_linea" id="id_linea">
                    <?php foreach($lineas AS $linea){ ?>
                    <option value="<?php echo $linea->id_linea; ?>" <?php if($linea->id_linea == $producto['id_linea']) echo 'selected'; ?>><?php echo $linea->nombre; ?></option>
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