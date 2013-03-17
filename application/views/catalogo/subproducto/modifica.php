<div id="contenido">
    <br />
    <div style=" font-weight: bold;"><?php echo $subproducto['nombre']; ?></div><br />
    <?php echo form_open('catalogo/subproductos/modifica/'.$subproducto['id_subproducto']); ?>
    <input type="hidden" name="id_subproducto" value="<?php echo $subproducto['id_subproducto']; ?>"/>
    <table class="tabla-captura">
        <tr>
            <td style="width: 40%;"><label for="nombre">Nombre del subproducto: </label></td>
            <td style="width: 60%;"><input type="text" name="nombre" id="nombre" value="<?php echo $subproducto['nombre']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="codigo">Código: </label></td>
            <td><input type="text" name="codigo" id="codigo" value="<?php echo $subproducto['codigo']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="id_producto">Producto: </label></td>
            <td>
                <select name="id_producto" id="id_producto">
                    <?php foreach($productos AS $producto){ ?>
                    <option value="<?php echo $producto->id_producto; ?>" <?php if($producto->id_producto== $subproducto['id_producto']) echo 'selected'; ?>><?php echo $producto->nombre; ?></option>
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