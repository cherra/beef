<div id="contenido">
    <br />
    <div style=" font-weight: bold;"><?php echo $cliente['nombre']; ?></div><br />
    <?php echo form_open('catalogo/clientes/modifica/'.$cliente['id_cliente']); ?>
    <input type="hidden" name="id_cliente" value="<?php echo $cliente['id_cliente']; ?>"/>
    <table class="tabla-captura">
        <tr>
            <td><label for="id_cliente">Número: </label></td>
            <td><input type="text" name="id_cliente" id="id_cliente" value="<?php echo $cliente['id_cliente']; ?>" disabled /></td>
        </tr>
        <tr>
            <td style="width: 30%;"><label for="nombre">Nombre o Razón social: </label></td>
            <td style="width: 70%;"><input type="text" name="nombre" id="nombre" value="<?php echo $cliente['nombre']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="rfc">RFC: </label></td>
            <td><input type="text" name="rfc" id="rfc" value="<?php echo $cliente['rfc']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="nombre_comercial">Nombre comercial: </label></td>
            <td><input type="text" name="nombre_comercial" id="nombre_comercial" value="<?php echo $cliente['nombre_comercial']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="domicilio">Domicilio: </label></td>
            <td><input type="text" name="domicilio" id="domicilio" value="<?php echo $cliente['domicilio']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="colonia">Colonia: </label></td>
            <td><input type="text" name="colonia" id="colonia" value="<?php echo $cliente['colonia']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="entre_calles">Entre calles ó referencias: </label></td>
            <td><input type="text" name="entre_calles" id="entre_calles" value="<?php echo $cliente['entre_calles']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="ciudad_estado">Ciudad y Estado: </label></td>
            <td><input type="text" name="ciudad_estado" id="ciudad_estado" value="<?php echo $cliente['ciudad_estado']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="cp">C.P.: </label></td>
            <td><input type="text" name="cp" id="cp" value="<?php echo $cliente['cp']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="telefono">Teléfono: </label></td>
            <td><input type="text" name="telefono" id="telefono" value="<?php echo $cliente['telefono']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="telefono2">Teléfono 2: </label></td>
            <td><input type="text" name="telefono2" id="telefono2" value="<?php echo $cliente['telefono2']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="telefono3">Teléfono 3: </label></td>
            <td><input type="text" name="telefono3" id="telefono3" value="<?php echo $cliente['telefono3']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="contacto">Contacto: </label></td>
            <td><input type="text" name="contacto" id="contacto" value="<?php echo $cliente['contacto']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="tipo_impresion">Tipo de comprobante: </label></td>
            <td>
                <input type="radio" name="tipo_impresion" id="tipo_impresion" value="ticket" <?php if($cliente['tipo_impresion'] == 'ticket'){ echo "checked"; } ?> />Ticket
                <input type="radio" name="tipo_impresion" id="tipo_impresion" value="factura" <?php if($cliente['tipo_impresion'] == 'factura'){ echo "checked"; } ?> />Factura
            </td>
        </tr>
        <tr>
            <td><label for="metodoDePago">Método de pago: </label></td>
            <td>
                <select name="metodoDePago" id="metodoDePago">
                    <option value="No identificado" <?php if($cliente['metodoDePago'] == 'No identificado'){ echo "selected"; } ?>>No identificado</option>
                    <option value="CHEQUE NOMINATIVO" <?php if($cliente['metodoDePago'] == 'CHEQUE NOMINATIVO'){ echo "selected"; } ?>>Cheque nominativo</option>
                    <option value="TRANSFERENCIA BANCARIA" <?php if($cliente['metodoDePago'] == 'TRANSFERENCIA BANCARIA'){ echo "selected"; } ?>>Transferencia bancaria</option>
                    <option value="TARJETA DE CREDITO" <?php if($cliente['metodoDePago'] == 'TARJETA DE CREDITO'){ echo "selected"; } ?>>Tarjeta de crédito</option>
                    <option value="TARJETA DE DEBITO" <?php if($cliente['metodoDePago'] == 'TARJETA DE DEBITO'){ echo "selected"; } ?>>Tarjeta de débito</option>
                    <option value="EFECTIVO" <?php if($cliente['metodoDePago'] == 'EFECTIVO'){ echo "selected"; } ?>>Efectivo</option>
                </select>
        </tr>
        <tr>
            <td><label for="NumCtaPago">Cuenta de pago: </label></td>
            <td><input type="text" name="NumCtaPago" id="NumCtaPago" value="<?php echo $cliente['NumCtaPago']; ?>" /></td>
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