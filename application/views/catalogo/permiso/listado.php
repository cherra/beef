<div id="contenido">
    <?php echo form_open('catalogo/permisos/listado'); ?>
    <table class="tabla-filtros">
        <tr class="ui-widget-header">
            <td colspan="2" class="filtro-titulo">Filtros de búsqueda</td>
        </tr>
        <tr>
            <td class="filtro-nombre">Nombre:</td>
            <td class="filtro-dato"><input type="text" name="permName" /></td>
        </tr>
        <tr>
            <td colspan="2"><button type="submit">Buscar</button></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
    <table class="tabla-listado">
        <tr class="ui-widget-header">
            <td style="width: 30%;">Nombre del Permiso</td>
            <td style="width: 30%;">Ruta</td>
            <td style="width: 30%;">Submenu</td>
            <td style="width: 10%">&nbsp;</td>
        </tr>
        <?php
        $folder = '';
        $class = '';
            foreach ($permisos as $permiso){
        ?>
        <?php
            if($folder != $permiso->folder){
        ?>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" style="font-weight: bold; font-size: 1.2em;"><?php echo ucwords($permiso->folder); ?></td>
        </tr>
        <?php
            }
        ?>
        <?php
            if($class != $permiso->class){
                $fila = 1;
        ?>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" style="font-weight: bold;"><?php echo ucwords($permiso->class); ?></td>
        </tr>
        <?php
            }
        ?>
        <tr>
            <td><?php echo $permiso->permName; ?></td>
            <td><?php echo $permiso->folder.'/'.$permiso->class.'/'.$permiso->method; ?></td>
            <td><?php echo $permiso->submenu; ?></td>
            <td>
                <?php echo anchor('catalogo/permisos/modifica/'.$permiso->ID, 'Modificar'); ?>
            </td>
        </tr>
        <?php
        $class = $permiso->class;
        $folder = $permiso->folder;
            }
        ?>
    </table>
</div>
