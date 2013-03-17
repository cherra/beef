<div id="contenido">
    <?php echo form_open('catalogo/proveedores/listado'); ?>
    <table class="tabla-filtros">
        <tr class="ui-widget-header">
            <td colspan="2" class="filtro-titulo">Filtros de búsqueda</td>
        </tr>
        <tr>
            <td class="filtro-nombre">Nombre/Razón social:</td>
            <td class="filtro-dato"><input type="text" name="razon_social" value="<?php echo isset($filtros['razon_social']) ? $filtros['razon_social'] : ''; ?>" /></td>
        </tr>
        <tr>
            <td colspan="2"><button type="submit">Buscar</button></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
    <div style="padding-bottom: 1em; text-align: center;"><?php echo $pagination; ?></div>
    <table class="tabla-listado">
        <tr class="ui-widget-header">
            <td style="width: 90%;">Nombre</td>
            <td style="width: 10%">&nbsp;</td>
        </tr>
        <?php
            foreach ($proveedores as $proveedor){
        ?>
        <tr>
            <td><?php echo $proveedor->razon_social; ?></td>
            <td>
                <?php echo anchor('catalogo/proveedores/modifica/'.$proveedor->id_proveedor, 'Modificar'); ?>
            </td>
        </tr>
        <?php
            }
        ?>
    </table>
    <div style="padding-bottom: 1em; text-align: center;"><?php echo $pagination; ?></div>
</div>
