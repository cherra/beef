<div id="contenido">
    <?php echo form_open('catalogo/clientes/alta/'); ?>
    <table class="tabla-captura">
        <tr>
            <td style="width: 30%;"><label for="nombre">Nombre o Razón social: </label></td>
            <td style="width: 70%;"><input type="text" name="nombre" id="nombre" required="required"/></td>
        </tr>
        <tr>
            <td><label for="rfc">RFC: </label></td>
            <td><input type="text" name="rfc" id="rfc" minlength="12"/></td>
        </tr>
        <tr>
            <td><label for="nombre_comercial">Nombre comercial: </label></td>
            <td><input type="text" name="nombre_comercial" id="nombre_comercial" /></td>
        </tr>
        <tr>
            <td><label for="domicilio">Domicilio: </label></td>
            <td><input type="text" name="domicilio" id="domicilio" required="required"/></td>
        </tr>
        <tr>
            <td><label for="colonia">Colonia: </label></td>
            <td><input type="text" name="colonia" id="colonia" required="required"/></td>
        </tr>
        <tr>
            <td><label for="entre_calles">Entre calles ó referencias: </label></td>
            <td><input type="text" name="entre_calles" id="entre_calles" /></td>
        </tr>
        <tr>
            <td><label for="ciudad_estado">Ciudad y Estado: </label></td>
            <td><input type="text" name="ciudad_estado" id="ciudad_estado" required="required"/></td>
        </tr>
        <tr>
            <td><label for="cp">C.P.: </label></td>
            <td><input type="text" name="cp" id="cp" /></td>
        </tr>
        <tr>
            <td><label for="telefono">Teléfono: </label></td>
            <td><input type="number" name="telefono" id="telefono" required="required" minlength="10" maxlength="13"/></td>
        </tr>
        <tr>
            <td><label for="telefono2">Teléfono 2: </label></td>
            <td><input type="text" name="telefono2" id="telefono2" minlength="10"/></td>
        </tr>
        <tr>
            <td><label for="telefono3">Teléfono 3: </label></td>
            <td><input type="text" name="telefono3" id="telefono3" minlength="10"/></td>
        </tr>
        <tr>
            <td><label for="contacto">Contacto: </label></td>
            <td><input type="text" name="contacto" id="contacto" /></td>
        </tr>
        <tr>
            <td><label for="email">Email: </label></td>
            <td><input type="email" name="email" id="email"/></td>
        </tr>
        <tr>
            <td><label for="tipo_impresion">Tipo de comprobante: </label></td>
            <td>
                <input type="radio" name="tipo_impresion" id="tipo_impresion" value="ticket" checked/>Ticket
                <input type="radio" name="tipo_impresion" id="tipo_impresion" value="factura" />Factura
            </td>
        </tr>
        <tr>
            <td><label for="metodoDePago">Método de pago: </label></td>
            <td>
                <select name="metodoDePago" id="metodoDePago">
                    <option value="No identificado">No identificado</option>
                    <option value="CHEQUE NOMINATIVO">Cheque nominativo</option>
                    <option value="TRANSFERENCIA BANCARIA">Transferencia bancaria</option>
                    <option value="TARJETA DE CREDITO">Tarjeta de crédito</option>
                    <option value="TARJETA DE DEBITO">Tarjeta de débito</option>
                    <option value="EFECTIVO">Efectivo</option>
                </select>
        </tr>
        <tr>
            <td><label for="NumCtaPago">Cuenta de pago: </label></td>
            <td><input type="text" name="NumCtaPago" id="NumCtaPago" /></td>
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