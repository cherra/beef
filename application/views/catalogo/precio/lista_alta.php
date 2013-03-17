<div id="contenido">
    <?php echo form_open('catalogo/precios/lista_alta'); ?>
    <table class="tabla-captura">
        <tr>
            <td style="width: 40%;"><label for="nombre">Nombre de la lista: </label></td>
            <td style="width: 60%;"><input type="text" name="nombre" id="nombre" /></td>
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