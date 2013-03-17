<div id="contenido">
    <br />
    <div style=" font-weight: bold;"><?php echo $cliente['nombre']; ?></div><br />
    <?php echo form_open('catalogo/clientes/credito/'.$cliente['id_cliente']); ?>
    <input type="hidden" name="id_cliente" value="<?php echo $cliente['id_cliente']; ?>"/>
    <table class="tabla-captura">
        <tr>
            <td style="width: 25%;"><label>Número: </label></td>
            <td style="width: 75%;"><div><?php echo $cliente['id_cliente']; ?></div></td>
        </tr>
        <tr>
            <td><label>Nombre o Razón social: </label></td>
            <td><div><?php echo $cliente['nombre']; ?></div></td>
        </tr>
        <tr>
            <td><label for="tipo_pago">Tipo de pago: </label></td>
            <td>
                <input type="radio" name="tipo_pago" id="tipo_pago_contado" value="contado" <?php if($cliente['tipo_pago'] == 'contado'){ echo "checked"; } ?> />Contado
                <input type="radio" name="tipo_pago" id="tipo_pago_contado" value="credito" <?php if($cliente['tipo_pago'] == 'credito'){ echo "checked"; } ?> />Crédito
            </td>
        </tr>
        <tr>
            <td><label for="vencimiento">Días de crédito: </label></td>
            <td><input type="text" name="vencimiento" id="vencimiento" value="<?php echo $cliente['vencimiento']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="id_ruta_cobranza">Ruta de cobranza: </label></td>
            <td>
                <select name="id_ruta_cobranza" id="id_ruta_cobranza">
                    <?php foreach($rutas_cobranza as $ruta){ ?>
                        <option value="<?php echo $ruta->id_ruta_cobranza; ?>" <?php if($ruta->id_ruta_cobranza == $cliente['id_ruta_cobranza']){ echo "selected"; } ?>><?php echo $ruta->descripcion; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="limite_credito">Monto máximo de crédito: </label></td>
            <td><input type="text" name="limite_credito" id="limite_credito" value="<?php echo $cliente['limite_credito']; ?>" /></td>
        </tr>
        <tr>
            <td><label>Días de cobro: </label></td>
            <td>
                <input type="checkbox" name="lun" id="lun" value="s" <?php if($cliente['lun'] == 's'){ echo "checked"; } ?>/>Lunes<br />
                <input type="checkbox" name="mar" id="mar" value="s" <?php if($cliente['mar'] == 's'){ echo "checked"; } ?>/>Martes<br />
                <input type="checkbox" name="mie" id="mie" value="s" <?php if($cliente['mie'] == 's'){ echo "checked"; } ?>/>Miercoles<br />
                <input type="checkbox" name="jue" id="jue" value="s" <?php if($cliente['jue'] == 's'){ echo "checked"; } ?>/>Jueves<br />
                <input type="checkbox" name="vie" id="vie" value="s" <?php if($cliente['vie'] == 's'){ echo "checked"; } ?>/>Viernes<br />
                <input type="checkbox" name="sab" id="sab" value="s" <?php if($cliente['sab'] == 's'){ echo "checked"; } ?>/>Sábado<br />
                <input type="checkbox" name="dom" id="dom" value="s" <?php if($cliente['dom'] == 's'){ echo "checked"; } ?>/>Domingo<br />
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