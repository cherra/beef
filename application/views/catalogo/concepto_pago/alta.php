<div id="contenido">
    <?php echo form_open('catalogo/conceptos_pago/alta'); ?>
    <table class="tabla-captura">
        <tr>
            <td style="width: 40%;"><label for="concepto_pago">Descripción: </label></td>
            <td style="width: 60%;"><input type="text" name="concepto_pago" id="concepto_pago" /></td>
        </tr>
        <tr>
            <td><label for="observaciones">Observaciones: </label></td>
            <td><input type="text" name="observaciones" id="observaciones" /></td>
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