<div id="contenido">
    <br />
    <div style=" font-weight: bold;"><?php echo $permiso['permName']; ?></div><br />
    <?php echo form_open('catalogo/permisos/modifica/'.$permiso['ID']); ?>
    <input type="hidden" name="ID" value="<?php echo $permiso['ID']; ?>"/>
    <table class="tabla-captura">
        <tr>
            <td style="width: 40%;"><label for="permName">Nombre del permiso: </label></td>
            <td style="width: 60%;"><input type="text" name="permName" id="permName" value="<?php echo $permiso['permName']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="menu">En el menú?: </label></td>
            <td><input type="checkbox" name="menu" id="menu" value="1" <?php if($permiso['menu'] == '1'){ echo "checked"; } ?> /></td>
        </tr>
        <tr>
            <td><label for="ruta">Submenu: </label></td>
            <td><input type="text" name="submenu" id="submenu" value="<?php echo $permiso['submenu']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="ruta">Ruta: </label></td>
            <td><input type="text" name="ruta" id="ruta" value="<?php echo $permiso['folder'].'/'.$permiso['class'].'/'.$permiso['method']; ?>" disabled /></td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="Guardar" />
            </td>
        </tr>
    </table>
   
    <?php echo form_close(); ?>
    
</div>