<div id="contenido">
    <br />
    <div style=" font-weight: bold;"><?php echo $usuario['nombre']." ".$usuario['apellido']; ?></div><br />
    <?php echo form_open('catalogo/usuarios/modifica/'.$usuario['id_usuario']); ?>
    <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>" />
    <table class="tabla-captura">
        <tr>
            <td style="width: 40%;"><label for="username">Nombre de usuario: </label></td>
            <td style="width: 60%;"><input type="text" name="username" id="username" value="<?php echo $usuario['username']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="password">Contraseña: </label></td>
            <td><input type="password" name="password" id="password" value="<?php echo $usuario['password']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="name">Nombre: </label></td>
            <td><input type="text" name="nombre" id="nombre" value="<?php echo $usuario['nombre']; ?>"/></td>
        </tr>
        <tr>
            <td><label for="apellido">Apellido: </label></td>
            <td><input type="text" name="apellido" id="apellido" value="<?php echo $usuario['apellido']; ?>"/></td>
        </tr>
        <tr>
            <td><label for="activo">Activo?: </label></td>
            <td>
                <input type="radio" name="eliminado" id="eliminado" value="n" <?php if($usuario['eliminado'] == 'n' or $usuario['eliminado'] == '') echo "checked" ?>/>Si<br />
                <input type="radio" name="eliminado" id="eliminado" value="s" <?php if($usuario['eliminado'] == 's') echo "checked" ?>/>No
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="acordion">
                    <h3><a href="#">Roles:</a></h3>
                    <div>
                        <?php
                        foreach($roles AS $rol){
                        ?>
                        <input type="checkbox" name="user_roles[]" value="<?php echo $rol->ID; ?>" <?php
                        foreach($userRoles AS $userRol){
                            if($rol->ID == $userRol->roleID)
                                echo "checked";
                        }
                        ?>/><?php echo $rol->roleName; ?><br />
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </td>
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
                        <input type="checkbox" name="user_perms[]" value="<?php echo $perm->ID; ?>" <?php
                        foreach($userPerms AS $userPerm){
                            if($perm->ID == $userPerm->permID)
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