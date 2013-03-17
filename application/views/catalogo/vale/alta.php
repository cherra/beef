<div id="contenido">
    <?php echo form_open('catalogo/vales/alta'); ?>
    <table class="tabla-captura">
        <tr>
            <td style="width: 40%;"><label for="concepto">Concepto del vale: </label></td>
            <td style="width: 60%;"><input type="text" name="concepto" id="concepto" /></td>
        </tr>
        <tr>
            <td><label for="codigo_barras">Códigos de barras?: </label></td>
            <td><input type="checkbox" name="codigo_barras" id="codigo_barras" value="s" /></td>
        </tr>
        <tr>
            <td><label for="tipo">Tipo: </label></td>
            <td>
                <input type="radio" name="tipo" id="tipo" value="salida" checked />Salida
                <input type="radio" name="tipo" id="tipo" value="entrada" />Entrada
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