<div id="contenido">
    <br />
    <?php echo form_open('catalogo/vendedores/alta'); ?>
    <table class="tabla-captura">
        <tr>
            <td style="width: 30%;"><label for="nombre">Nombre: </label></td>
            <td style="width: 70%;"><input type="text" name="nombre" id="nombre" /></td>
        </tr>
        <tr>
            <td><label for="apellido">Apellidos: </label></td>
            <td><input type="text" name="apellido" id="apellido" /></td>
        </tr>
        <tr>
            <td><label for="domicilio">Domicilio: </label></td>
            <td><input type="text" name="domicilio" id="domicilio" /></td>
        </tr>
        <tr>
            <td><label for="colonia">Colonia: </label></td>
            <td><input type="text" name="colonia" id="colonia" /></td>
        </tr>
        <tr>
            <td><label for="ciudad">Ciudad: </label></td>
            <td><input type="text" name="ciudad" id="ciudad" /></td>
        </tr>
        <tr>
            <td><label for="estado">Estado: </label></td>
            <td><input type="text" name="estado" id="estado" /></td>
        </tr>
        <tr>
            <td><label for="cp">C.P.: </label></td>
            <td><input type="text" name="cp" id="cp" /></td>
        </tr>
        <tr>
            <td><label for="telefono">Teléfono: </label></td>
            <td><input type="text" name="telefono" id="telefono" /></td>
        </tr>
        <tr>
            <td><label for="numero">Número: </label></td>
            <td><input type="text" name="numero" id="numero" /></td>
        </tr>
        <tr>
            <td><label for="tipo">Tipo: </label></td>
            <td>
                <select name="tipo" id="tipo">
                    <option value="sueldos" selected>Sueldos</option>
                    <option value="comision">Comisión</option>
                </select>
        </tr>
        <tr>
            <td><label for="SueldoBase">Sueldo base: </label></td>
            <td><input type="text" name="SueldoBase" id="SueldoBase" /></td>
        </tr>
        <tr>
            <td><label for="importe_comision">Importe de comisión: </label></td>
            <td><input type="text" name="importe_comision" id="importe_comision" /></td>
        </tr>
        <tr>
            <td><label for="comision_servicio">Comisión por servicio: </label></td>
            <td><input type="text" name="comision_servicio" id="comision_servicio" /></td>
        </tr>
        <tr>
            <td><label for="hora_inicio_comision">Registro desde: </label></td>
            <td><input type="text" name="hora_inicio_comision" id="hora_inicio_comision" /></td>
        </tr>
        <tr>
            <td><label for="hora_fin_comision">Hasta: </label></td>
            <td><input type="text" name="hora_fin_comision" id="hora_fin_comision" /></td>
        </tr>
        <tr>
            <td><label for="prest_inf">Prestamo Infonavit: </label></td>
            <td><input type="text" name="prest_inf" id="prest_inf" /></td>
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