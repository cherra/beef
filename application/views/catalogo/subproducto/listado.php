<div id="contenido">
    <?php echo form_open('catalogo/subproductos/listado'); ?>
    <table class="tabla-filtros">
        <tr class="ui-widget-header">
            <td colspan="2" class="filtro-titulo">Filtros de búsqueda</td>
        </tr>
        <tr>
            <td class="filtro-nombre">Nombre:</td>
            <td class="filtro-dato"><input type="text" name="nombre" value="<?php echo $filtros['nombre']; ?>" /></td>
        </tr>
        <tr>
            <td class="filtro-nombre">Producto:</td>
            <td class="filtro-dato">
                <select name="id_producto">
                    <option value="">Todos</option>
                    <?php 
                    $nombre_linea = '';
                    foreach($productos AS $producto){
                        ?>
                    <?php if($nombre_linea != $producto->nombre_linea){ ?>
                    <option style="font-weight: bold;" value="0" disabled>----------</option>
                    <option style="font-weight: bold;" value="0" disabled><?php echo $producto->nombre_linea; ?></option>
                    <?php }?>
                    <option value="<?php echo $producto->id_producto; ?>" <?php if($filtros['id_producto'] == $producto->id_producto) echo "selected"; ?>><?php echo $producto->nombre; ?></option>
                    <?php
                    $nombre_linea = $producto->nombre_linea;
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="filtro-nombre">Mostrar:</td>
            <td class="filtro-dato">
                <input type="radio" name="con_codigo" value="n" <?php if(isset($filtros['con_codigo'])) echo $filtros['con_codigo'] == 'n' ? 'checked' : ""; else echo "checked"; ?>/> Todos <br />
                <input type="radio" name="con_codigo" value="s" <?php if(isset($filtros['con_codigo'])) echo $filtros['con_codigo'] == 's' ? 'checked' : ""; ?>/> Sólo con código
            </td>
        </tr>
        <tr>
            <td colspan="2"><button type="submit">Buscar</button></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
    <table class="tabla-listado">
        <tr class="ui-widget-header">
            <td style="width: 80%;">Nombre</td>
            <td style="width: 10%;">Código</td>
            <td style="width: 10%">&nbsp;</td>
        </tr>
        <?php
        $nombre_producto='';
            foreach ($subproductos as $subproducto){
        ?>
        <?php if($subproducto->nombre_producto != $nombre_producto){ 
            $fila = 1;
            ?>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td colspan="2" style="font-weight: bold;"><?php echo $subproducto->nombre_producto; ?></td>
        </tr>
        <?php } ?>
        <tr>
            <td><?php echo $subproducto->nombre; ?></td>
            <td><?php echo $subproducto->codigo; ?></td>
            <td>
                <?php echo anchor('catalogo/subproductos/modifica/'.$subproducto->id_subproducto, 'Modificar'); ?>
            </td>
        </tr>
        <?php
        $nombre_producto = $subproducto->nombre_producto;
            }
        ?>
    </table>
</div>
