<div id="contenido">
    <div style="padding-bottom: 1em; text-align: center;"><?php echo $pagination; ?></div>
    <table class="tabla-listado">
        <tr class="ui-widget-header">
            <td style="width: 80%;">Bascula</td>
            <td style="width: 10%">Código</td>
            <td style="width: 10%">&nbsp;</td>
        </tr>
        <?php
            foreach ($basculas as $bascula){
        ?>
        <tr>
            <td><?php echo $bascula->bascula; ?></td>
            <td><?php echo $bascula->codigo; ?></td>
            <td>
                <?php echo anchor('herramientas/basculas/exportar_catalogo/'.$bascula->id_bascula, 'Exportar'); ?>
            </td>
        </tr>
        <?php
            }
        ?>
    </table>
    <div style="padding-bottom: 1em; text-align: center;"><?php echo $pagination; ?></div>
</div>
