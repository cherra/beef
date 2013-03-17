<div id="contenido">
    <?php echo form_open('catalogo/roles/alta'); ?>
    <table class="tabla-captura">
        <tr>
            <td style="width: 40%;"><label for="roleName">Nombre del rol: </label></td>
            <td style="width: 60%;"><input type="text" name="roleName" id="roleName" /></td>
        </tr>
        <tr>
            <td><label for="roleDescription">Descripción: </label></td>
            <td><input type="text" name="roleDescription" id="roleDescription" /></td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="acordion">
                    <h3><a href="#">Permisos:</a></h3>
                    <div>
                        <?php
                        $class = '';
                        $folder = '';
                        foreach($perms AS $perm){
                            if($folder != $perm->folder){
                            ?>
                            <br />
                            <p style="font-weight: bold;"><?php echo ucwords($perm->folder); ?></p>
                        <?php
                            }
                            if($class != $perm->class){
                        ?>
                            <p><?php echo ucwords($perm->class); ?></p>
                        <?php
                            }
                        ?>
                        <input type="checkbox" name="role_perms[]" value="<?php echo $perm->ID; ?>"/><?php echo $perm->permName; ?><br />
                        <?php
                            $class = $perm->class;
                            $folder = $perm->folder;
                        }
                        ?>
                    </div>
                </div>
            </td>
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