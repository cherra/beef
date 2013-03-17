<div id="contenido">
    <br />
    <div style=" font-weight: bold;"><?php echo $rol['roleName']; ?></div><br />
    <?php echo form_open('catalogo/roles/modifica/'.$rol['ID']); ?>
    <input type="hidden" name="ID" value="<?php echo $rol['ID']; ?>"/>
    <table class="tabla-captura">
        <tr>
            <td style="width: 40%;"><label for="roleName">Nombre del rol: </label></td>
            <td style="width: 60%;"><input type="text" name="roleName" id="roleName" value="<?php echo $rol['roleName']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="description">Descripción: </label></td>
            <td><input type="text" name="roleDescription" id="description" value="<?php echo $rol['roleDescription']; ?>" /></td>
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
                            <p style="margin-top: 0.5em;">- <?php echo ucwords($perm->class); ?> -</p>
                        <?php
                            }
                        ?>
                        <input type="checkbox" name="role_perms[]" value="<?php echo $perm->ID; ?>" <?php
                        foreach($role_perms AS $role_perm){
                            if($perm->ID == $role_perm->permID)
                                echo "checked";
                        }
                        ?>/><?php echo $perm->permName; ?><br />
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