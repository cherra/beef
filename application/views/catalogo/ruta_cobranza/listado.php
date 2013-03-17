<div id="contenido">
    <?php echo form_open('catalogo/rutas_cobranza/listado'); ?>
    <table class="tabla-filtros">
        <tr class="ui-widget-header">
            <td colspan="2" class="filtro-titulo">Filtros de búsqueda</td>
        </tr>
        <tr>
            <td class="filtro-nombre">Nombre:</td>
            <td class="filtro-dato"><input type="text" name="descripcion" /></td>
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
            foreach ($rutas as $ruta){
        ?>
        <tr>
            <td><?php echo $ruta->descripcion; ?></td>
            <td>
                <?php echo anchor('catalogo/rutas_cobranza/modifica/'.$ruta->id_ruta_cobranza, 'Modificar'); ?>
            </td>
        </tr>
        <?php
            }
        ?>
    </table>
</div>
