<div id="contenido">
    <?php echo form_open('catalogo/conceptos_comision/alta'); ?>
    <table class="tabla-captura">
        <tr>
            <td style="width: 40%;"><label for="descripcion">Descripción: </label></td>
            <td style="width: 60%;"><input type="text" name="descripcion" id="descripcion" /></td>
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