<div id="contenido">
    <br />
    <div style=" font-weight: bold;"><?php echo $vendedor['nombre']; ?></div><br />
    <?php echo form_open('catalogo/vendedores/modifica/'.$vendedor['id_empleado']); ?>
    <input type="hidden" name="id_empleado" value="<?php echo $vendedor['id_empleado']; ?>"/>
    <table class="tabla-captura">
        <tr>
            <td style="width: 30%;"><label for="nombre">Nombre: </label></td>
            <td style="width: 70%;"><input type="text" name="nombre" id="nombre" value="<?php echo $vendedor['nombre']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="apellido">Apellidos: </label></td>
            <td><input type="text" name="apellido" id="apellido" value="<?php echo $vendedor['apellido']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="domicilio">Domicilio: </label></td>
            <td><input type="text" name="domicilio" id="domicilio" value="<?php echo $vendedor['domicilio']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="colonia">Colonia: </label></td>
            <td><input type="text" name="colonia" id="colonia" value="<?php echo $vendedor['colonia']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="ciudad">Ciudad: </label></td>
            <td><input type="text" name="ciudad" id="ciudad" value="<?php echo $vendedor['ciudad']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="estado">Estado: </label></td>
            <td><input type="text" name="estado" id="estado" value="<?php echo $vendedor['estado']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="cp">C.P.: </label></td>
            <td><input type="text" name="cp" id="cp" value="<?php echo $vendedor['cp']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="telefono">Teléfono: </label></td>
            <td><input type="text" name="telefono" id="telefono" value="<?php echo $vendedor['telefono']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="numero">Número: </label></td>
            <td><input type="text" name="numero" id="numero" value="<?php echo $vendedor['numero']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="tipo">Tipo: </label></td>
            <td>
                <select name="tipo" id="tipo">
                    <option value="sueldos" <?php if($vendedor['tipo'] == 'Sueldos') echo "selected"; ?>>Sueldos</option>
                    <option value="comision" <?php if($vendedor['tipo'] == 'Comision') echo "selected"; ?>>Comisión</option>
                </select>
        </tr>
        <tr>
            <td><label for="SueldoBase">Sueldo base: </label></td>
            <td><input type="text" name="SueldoBase" id="SueldoBase" value="<?php echo $vendedor['SueldoBase']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="importe_comision">Importe de comisión: </label></td>
            <td><input type="text" name="importe_comision" id="importe_comision" value="<?php echo $vendedor['importe_comision']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="comision_servicio">Comisión por servicio: </label></td>
            <td><input type="text" name="comision_servicio" id="comision_servicio" value="<?php echo $vendedor['comision_servicio']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="hora_inicio_comision">Registro desde: </label></td>
            <td><input type="text" name="hora_inicio_comision" id="hora_inicio_comision" value="<?php echo $vendedor['hora_inicio_comision']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="hora_fin_comision">Hasta: </label></td>
            <td><input type="text" name="hora_fin_comision" id="hora_fin_comision" value="<?php echo $vendedor['hora_fin_comision']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="prest_inf">Prestamo Infonavit: </label></td>
            <td><input type="text" name="prest_inf" id="prest_inf" value="<?php echo $vendedor['prest_inf']; ?>" /></td>
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