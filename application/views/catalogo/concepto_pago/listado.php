<div id="contenido">
    <?php echo form_open('catalogo/conceptos_pago/listado'); ?>
    <table class="tabla-filtros">
        <tr class="ui-widget-header">
            <td colspan="2" class="filtro-titulo">Filtros de búsqueda</td>
        </tr>
        <tr>
            <td class="filtro-nombre">Descripción:</td>
            <td class="filtro-dato"><input type="text" name="concepto_pago" value="<?php echo isset($filtros['concepto_pago']) ? $filtros['concepto_pago'] : ''; ?>"/></td>
        </tr>
        <tr>
            <td colspan="2"><button type="submit">Buscar</button></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
    <div style="padding-bottom: 1em; text-align: center;"><?php echo $pagination; ?></div>
    <table class="tabla-listado">
        <tr class="ui-widget-header">
            <td style="width: 45%;">Descripcion</td>
            <td style="width: 45%;">Observaciones</td>
            <td style="width: 10%">&nbsp;</td>
        </tr>
        <?php
            foreach ($conceptos as $concepto){
        ?>
        <tr>
            <td><?php echo $concepto->concepto_pago; ?></td>
            <td><?php echo $concepto->observaciones; ?></td>
            <td>
                <?php echo anchor('catalogo/conceptos_pago/modifica/'.$concepto->id_concepto_pago, 'Modificar'); ?>
            </td>
        </tr>
        <?php
            }
        ?>
    </table>
    <div style="padding-bottom: 1em; text-align: center;"><?php echo $pagination; ?></div>
</div>
