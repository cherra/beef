<div id="contenido">
    <br />
    <div style=" font-weight: bold;"><?php echo $gasto['descripcion']; ?></div><br />
    <?php echo form_open('catalogo/gastos/modifica/'.$gasto['id_gasto']); ?>
    <input type="hidden" name="id_gasto" value="<?php echo $gasto['id_gasto']; ?>"/>
    <table class="tabla-captura">
        <tr>
            <td style="width: 40%;"><label for="descripcion">Descripción: </label></td>
            <td style="width: 60%;"><input type="text" name="descripcion" id="descripcion" value="<?php echo $gasto['descripcion']; ?>" /></td>
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