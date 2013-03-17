<div id="contenido">
    <br />
    <div style=" font-weight: bold;"><?php echo $concepto['concepto_pago']; ?></div><br />
    <?php echo form_open('catalogo/conceptos_pago/modifica/'.$concepto['id_concepto_pago']); ?>
    <input type="hidden" name="id_concepto_pago" value="<?php echo $concepto['id_concepto_pago']; ?>"/>
    <table class="tabla-captura">
        <tr>
            <td style="width: 40%;"><label for="concepto_pago">Descripción: </label></td>
            <td style="width: 60%;"><input type="text" name="concepto_pago" id="concepto_pago" value="<?php echo $concepto['concepto_pago']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="observaciones">Descripción: </label></td>
            <td><input type="text" name="observaciones" id="observaciones" value="<?php echo $concepto['observaciones']; ?>" /></td>
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