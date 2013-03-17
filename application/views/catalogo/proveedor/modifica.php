<div id="contenido">
    <br />
    <div style=" font-weight: bold;"><?php echo $proveedor['razon_social']; ?></div><br />
    <?php echo form_open('catalogo/proveedores/modifica/'.$proveedor['id_proveedor']); ?>
    <input type="hidden" name="id_proveedor" value="<?php echo $proveedor['id_proveedor']; ?>"/>
    <table class="tabla-captura">
        <tr>
            <td style="width: 30%;"><label for="razon_social">Nombre o Razón social: </label></td>
            <td style="width: 70%;"><input type="text" name="razon_social" id="razon_social" value="<?php echo $proveedor['razon_social']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="rfc">RFC: </label></td>
            <td><input type="text" name="rfc" id="rfc" value="<?php echo $proveedor['rfc']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="nombre_comercial">Nombre comercial: </label></td>
            <td><input type="text" name="nombre_comercial" id="nombre_comercial" value="<?php echo $proveedor['nombre_comercial']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="domicilio">Domicilio: </label></td>
            <td><input type="text" name="domicilio" id="domicilio" value="<?php echo $proveedor['domicilio']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="colonia">Colonia: </label></td>
            <td><input type="text" name="colonia" id="colonia" value="<?php echo $proveedor['colonia']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="ciudad">Ciudad: </label></td>
            <td><input type="text" name="ciudad" id="ciudad" value="<?php echo $proveedor['ciudad']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="estado">Estado: </label></td>
            <td><input type="text" name="estado" id="estado" value="<?php echo $proveedor['estado']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="cp">C.P.: </label></td>
            <td><input type="text" name="cp" id="cp" value="<?php echo $proveedor['cp']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="telefono">Teléfono: </label></td>
            <td><input type="text" name="telefono" id="telefono" value="<?php echo $proveedor['telefono']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="telefono2">Teléfono 2: </label></td>
            <td><input type="text" name="telefono2" id="telefono2" value="<?php echo $proveedor['telefono2']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="fax">Fax: </label></td>
            <td><input type="text" name="fax" id="fax" value="<?php echo $proveedor['fax']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="email">Email: </label></td>
            <td><input type="text" name="email" id="email" value="<?php echo $proveedor['email']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="contacto">Contacto: </label></td>
            <td><input type="text" name="contacto" id="contacto" value="<?php echo $proveedor['contacto']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="tipo">Tipo: </label></td>
            <td>
                <select name="tipo" id="tipo">
                    <option value="compras" <?php if($proveedor['tipo'] == 'compras'){ echo "selected"; } ?>>Compras</option>
                    <option value="servicios" <?php if($proveedor['tipo'] == 'servicios'){ echo "selected"; } ?>>Servicios</option>
                    <option value="servicios_compras" <?php if($proveedor['tipo'] == 'servicios_compras'){ echo "selected"; } ?>>Compras y servicios</option>
                </select>
        </tr>
        <tr>
            <td><label for="tipo_pago">Tipo de pago: </label></td>
            <td>
                <select name="tipo_pago" id="tipo_pago">
                    <option value="efectivo" <?php if($proveedor['tipo_pago'] == 'efectivo'){ echo "selected"; } ?>>Efectivo</option>
                    <option value="cheque" <?php if($proveedor['tipo_pago'] == 'cheque'){ echo "selected"; } ?>>Cheque</option>
                    <option value="transferencia" <?php if($proveedor['tipo_pago'] == 'transferencia'){ echo "selected"; } ?>>Transferencia</option>
                </select>
        </tr>
        <tr>
            <td><label for="dias_credito">Días de crédito: </label></td>
            <td><input type="text" name="dias_credito" id="dias_credito" value="<?php echo $proveedor['dias_credito']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="cuenta_contable">Cuenta contable: </label></td>
            <td><input type="text" name="cuenta_contable" id="cuenta_contable" value="<?php echo $proveedor['cuenta_contable']; ?>" /></td>
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