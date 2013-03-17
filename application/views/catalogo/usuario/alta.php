<div id="contenido">
    <?php echo form_open('catalogo/usuarios/alta'); ?>
    <div class="label"><label for="username">Nombre de usuario: </label></div>
    <input type="text" name="username" id="username" /> <br />
    <div class="label"><label for="password">Contraseña: </label></div>
    <input type="text" name="password" id="password" /> <br />
    <div class="label"><label for="name">Nombre: </label></div>
    <input type="text" name="nombre" id="nombre" /> <br />
    <div class="label"><label for="apellido">Apellido: </label></div>
    <input type="text" name="apellido" id="apellido" /> <br /><br />
   
    <input type="submit" value="Guardar" />
   
    <?php echo form_close(); ?>
</div>