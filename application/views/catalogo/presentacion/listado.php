<div id="contenido">
    <?php echo form_open('catalogo/presentaciones/listado'); ?>
    <table class="tabla-filtros">
        <tr class="ui-widget-header">
            <td colspan="2" class="filtro-titulo">Filtros de búsqueda</td>
        </tr>
        <tr>
            <td class="filtro-nombre">Nombre:</td>
            <td class="filtro-dato"><input type="text" name="nombre" value="<?php echo $filtros['nombre']; ?>" /></td>
        </tr>
        <tr>
            <td class="filtro-nombre">Linea:</td>
            <td class="filtro-dato">
                <select name="id_linea">
                    <option value="">Todos</option>
                    <?php 
                    foreach($lineas AS $linea){
                        ?>
                    <option value="<?php echo $linea->id_linea; ?>" <?php if($filtros['id_linea'] == $linea->id_linea) echo "selected"; ?>><?php echo $linea->nombre; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="filtro-nombre">Mostrar:</td>
            <td class="filtro-dato">
                <input type="radio" name="con_codigo" value="s" <?php if(isset($filtros['con_codigo'])) echo $filtros['con_codigo'] == 's' ? 'checked' : ""; else echo "checked"; ?>/> Sólo con código<br />
                <input type="radio" name="con_codigo" value="n" <?php if(isset($filtros['con_codigo'])) echo $filtros['con_codigo'] == 'n' ? 'checked' : ""; ?>/> Todos
            </td>
        </tr>
        <tr>
            <td colspan="2"><button type="submit">Buscar</button></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
    <div style="padding-bottom: 1em; text-align: center;"><?php echo $pagination; ?></div>
    <table class="tabla-listado">
        <tr class="ui-widget-header">
            <td style="width: 80%;">Nombre</td>
            <td style="width: 10%;">Código</td>
            <td style="width: 10%">&nbsp;</td>
        </tr>
        <?php
            foreach ($presentaciones as $presentacion){
        ?>
        <tr>
            <td><?php echo $presentacion->nombre; ?></td>
            <td><?php echo strlen($presentacion->codigo) > 0 ? $presentacion->codigo_subproducto.$presentacion->codigo : ''; ?></td>
            <td>
                <?php echo anchor('catalogo/presentaciones/modifica/'.$presentacion->id_articulo, 'Modificar'); ?>
            </td>
        </tr>
        <?php
            }
        ?>
    </table>
    <div style="padding-top: 3em; text-align: center;"><?php echo $pagination; ?></div>
</div>
