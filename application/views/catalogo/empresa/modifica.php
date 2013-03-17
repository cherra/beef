<div id="contenido">
    <br />
    <div style=" font-weight: bold;"><?php echo $empresa['nombre']; ?></div><br />
    <?php echo form_open('catalogo/empresas/modifica/'.$empresa['id_empresa']); ?>
    <input type="hidden" name="id_empresa" value="<?php echo $empresa['id_empresa']; ?>"/>
    <table class="tabla-captura">
        <tr>
            <td style="width: 40%;"><label for="nombre">Nombre: </label></td>
            <td style="width: 60%;"><input type="text" name="nombre" id="nombre" value="<?php echo $empresa['nombre']; ?>" /></td>
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