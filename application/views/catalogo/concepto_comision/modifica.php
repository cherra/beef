<div id="contenido">
    <br />
    <div style=" font-weight: bold;"><?php echo $concepto['descripcion']; ?></div><br />
    <?php echo form_open('catalogo/conceptos_comision/modifica/'.$concepto['id_concepto_comision']); ?>
    <input type="hidden" name="id_concepto_comision" value="<?php echo $concepto['id_concepto_comision']; ?>"/>
    <table class="tabla-captura">
        <tr>
            <td style="width: 40%;"><label for="descripcion">Descripción: </label></td>
            <td style="width: 60%;"><input type="text" name="descripcion" id="descripcion" value="<?php echo $concepto['descripcion']; ?>" /></td>
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