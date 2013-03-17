<div id="contenido">
    <br />
    <div style=" font-weight: bold;"><?php echo $vale['concepto']; ?></div><br />
    <?php echo form_open('catalogo/vales/modifica/'.$vale['id_concepto']); ?>
    <input type="hidden" name="id_concepto" value="<?php echo $vale['id_concepto']; ?>"/>
    <table class="tabla-captura">
        <tr>
            <td style="width: 40%;"><label for="concepto">Concepto del vale: </label></td>
            <td style="width: 60%;"><input type="text" name="concepto" id="concepto" value="<?php echo $vale['concepto']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="codigo_barras">Imprimir códigos de barras?: </label></td>
            <td><input type="checkbox" name="codigo_barras" id="codigo_barras" value="s" <?php if($vale['codigo_barras'] == 's') echo 'checked'; ?> /></td>
        </tr>
        <tr>
            <td><label for="tipo">Tipo: </label></td>
            <td>
                <input type="radio" name="tipo" id="tipo" value="salida" <?php if($vale['tipo'] == 'salida') echo 'checked'; ?> />Salida
                <input type="radio" name="tipo" id="tipo" value="entrada" <?php if($vale['tipo'] == 'entrada') echo 'checked'; ?> />Entrada
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