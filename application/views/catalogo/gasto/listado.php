<div id="contenido">
    <?php echo form_open('catalogo/gastos/listado'); ?>
    <table class="tabla-filtros">
        <tr class="ui-widget-header">
            <td colspan="2" class="filtro-titulo">Filtros de búsqueda</td>
        </tr>
        <tr>
            <td class="filtro-nombre">Descripción:</td>
            <td class="filtro-dato"><input type="text" name="descripcion" value="<?php echo isset($filtros['descripcion']) ? $filtros['descripcion'] : ''; ?>"/></td>
        </tr>
        <tr>
            <td colspan="2"><button type="submit">Buscar</button></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
    <div style="padding-bottom: 1em; text-align: center;"><?php echo $pagination; ?></div>
    <table class="tabla-listado">
        <tr class="ui-widget-header">
            <td style="width: 90%;">Descripcion</td>
            <td style="width: 10%">&nbsp;</td>
        </tr>
        <?php
            foreach ($gastos as $gasto){
        ?>
        <tr>
            <td><?php echo $gasto->descripcion; ?></td>
            <td>
                <?php echo anchor('catalogo/gastos/modifica/'.$gasto->id_gasto, 'Modificar'); ?>
            </td>
        </tr>
        <?php
            }
        ?>
    </table>
    <div style="padding-bottom: 1em; text-align: center;"><?php echo $pagination; ?></div>
</div>
