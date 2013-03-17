<div id="contenido">
    <?php echo form_open('catalogo/precios/listalistado'); ?>
    <table class="tabla-filtros">
        <tr class="ui-widget-header">
            <td colspan="2" class="filtro-titulo">Filtros de búsqueda</td>
        </tr>
        <tr>
            <td class="filtro-nombre">Nombre:</td>
            <td class="filtro-dato"><input type="text" name="nombre" /></td>
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
            foreach ($listas as $lista){
        ?>
        <tr>
            <td><?php echo $lista->nombre; ?></td>
            <td>
                <?php echo anchor('catalogo/precios/lista_modifica/'.$lista->id_lista, 'Modificar'); ?>
            </td>
        </tr>
        <?php
            }
        ?>
    </table>
</div>
