<div id="contenido">
    <?php echo form_open('catalogo/productos/listado'); ?>
    <table class="tabla-filtros">
        <tr class="ui-widget-header">
            <td colspan="2" class="filtro-titulo">Filtros de búsqueda</td>
        </tr>
        <tr>
            <td class="filtro-nombre">Nombre:</td>
            <td class="filtro-dato"><input type="text" name="nombre" /></td>
        </tr>
        <tr>
            <td class="filtro-nombre">Linea:</td>
            <td class="filtro-dato">
                <select name="id_linea">
                    <option value="">Todas</option>
                    <?php 
                    foreach($lineas AS $linea){
                        ?>
                    <option value="<?php echo $linea->id_linea; ?>"><?php echo $linea->nombre; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><button type="submit">Buscar</button></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
    <table class="tabla-listado">
        <tr class="ui-widget-header">
            <td style="width: 90%;">Nombre</td>
            <td style="width: 10%">&nbsp;</td>
        </tr>
        <?php
        $nombre_linea='';
            foreach ($productos as $producto){
        ?>
        <?php if($producto->nombre_linea != $nombre_linea){ ?>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td colspan="2" style="font-weight: bold;"><?php echo $producto->nombre_linea; ?></td>
        </tr>
        <?php } ?>
        <tr>
            <td><?php echo $producto->nombre; ?></td>
            <td>
                <?php echo anchor('catalogo/productos/modifica/'.$producto->id_producto, 'Modificar'); ?>
            </td>
        </tr>
        <?php
        $nombre_linea = $producto->nombre_linea;
            }
        ?>
    </table>
</div>
