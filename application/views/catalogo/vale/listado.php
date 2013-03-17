<div id="contenido">
    <?php echo form_open('catalogo/vales/listado'); ?>
    <table class="tabla-filtros">
        <tr class="ui-widget-header">
            <td colspan="2" class="filtro-titulo">Filtros de búsqueda</td>
        </tr>
        <tr>
            <td class="filtro-nombre">Concepto:</td>
            <td class="filtro-dato"><input type="text" name="concepto" value="<?php echo isset($filtros['concepto']) ? $filtros['concepto'] : ''; ?>" /></td>
        </tr>
        <tr>
            <td colspan="2"><button type="submit">Buscar</button></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
    <table class="tabla-listado">
        <tr class="ui-widget-header">
            <td style="width: 60%;">Concepto del vale</td>
            <td style="width: 15%;">Código de barras</td>
            <td style="width: 15%;">Tipo</td>
            <td style="width: 10%">&nbsp;</td>
        </tr>
        <?php
            foreach ($vales as $vale){
        ?>
        <tr>
            <td><?php echo $vale->concepto; ?></td>
            <td style="text-align: center;"><?php echo $vale->codigo_barras; ?></td>
            <td><?php echo $vale->tipo; ?></td>
            <td>
                <?php echo anchor('catalogo/vales/modifica/'.$vale->id_concepto, 'Modificar'); ?>
            </td>
        </tr>
        <?php
            }
        ?>
    </table>
</div>
