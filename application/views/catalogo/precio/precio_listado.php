<div id="contenido">
    <?php echo form_open('catalogo/precios/precio_listado'); ?>
    <table class="tabla-filtros">
        <tr class="ui-widget-header">
            <td colspan="2" class="filtro-titulo">Filtros de busqueda</td>
        </tr>
        <tr>
            <td class="filtro-nombre">Lista de precios</td>
            <td class="filtro-dato">
                <select name="id_lista" id="id_lista">
                    <option>Selecciona una lista...</option>
                    <?php foreach($listas as $lista){ ?>
                    <option value="<?php echo $lista->id_lista; ?>" <?php if($lista->id_lista == $filtros['id_lista']){ echo "selected"; $lista_nombre = $lista->nombre; } ?>><?php echo $lista->nombre; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="filtro-nombre">Linea de productos</td>
            <td class="filtro-dato">
                <select name="id_linea" id="id_linea">
                    <option value="0">Selecciona una linea...</option>
                    <?php foreach($lineas as $linea){ ?>
                    <option value="<?php echo $linea->id_linea; ?>" <?php if($linea->id_linea == $filtros['id_linea']) echo "selected"; ?>><?php echo $linea->nombre; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="filtro-nombre">Nombre de la presentación</td>
            <td class="filtro-dato">
                <input type="text" name="nombre" id="nombre" value="<?php echo $filtros['nombre']; ?>" />
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="Buscar" /></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
    <div><h2>&nbsp;<?php if(isset($lista_nombre)) echo $lista_nombre; ?></h2></div>
    <table class="tabla-listado">
        <tr class="ui-widget-header">
            <td style="width: 10%;">Código</td>
            <td style="width: 70%">Presentación</td>
            <td style="width: 10%">Precio</td>
            <td style="width: 10%">Precio mínimo</td>
        </tr>
        <?php
            $nombre_linea ='';
            foreach ($precios as $precio){
        ?>
        <?php if($nombre_linea != $precio->nombre_linea){ ?>
        <tr><td>&nbsp;</td></tr>
        <tr><td colspan="4" style="font-weight: bold;"><?php echo $precio->nombre_linea; ?></td></tr>
        <?php }?>
        <tr>
            <td><?php echo $precio->codigo_subproducto.$precio->codigo; ?></td>
            <td><?php echo $precio->nombre; ?></td>
            <td style="text-align: right;"><?php echo $precio->precio; ?></td>
            <td style="text-align: right;"><?php echo $precio->precio_minimo; ?></td>
        </tr>
        <?php
        $nombre_linea = $precio->nombre_linea;
            }
        ?>
    </table>
</div>
