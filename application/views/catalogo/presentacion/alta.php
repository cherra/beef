<div id="contenido">
    <?php echo form_open('catalogo/presentaciones/alta'); ?>
    <table class="tabla-captura">
        <tr>
            <td style="width: 40%;"><label for="nombre">Nombre de la presentación: </label></td>
            <td style="width: 60%;"><input type="text" name="nombre" id="nombre" /></td>
        </tr>
        <tr>
            <td><label for="id_subproducto">Subproducto: </label></td>
            <td>
                <select name="id_subproducto" id="id_subproducto">
                    <?php 
                    $nombre_producto = '';
                    foreach($subproductos AS $subproducto){ ?>
                    <?php if($nombre_producto != $subproducto->nombre_producto){ ?>
                    <option style="font-weight: bold;" value="0" disabled>----------</option>
                    <option style="font-weight: bold;" value="0" disabled><?php echo $subproducto->nombre_producto; ?></option>
                    <?php }?>
                    <option value="<?php echo $subproducto->id_subproducto; ?>" codigo="<?php echo $subproducto->codigo; ?>"><?php echo $subproducto->codigo." ".$subproducto->nombre; ?></option>
                    <?php
                    $nombre_producto = $subproducto->nombre_producto;
                    } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="codigo">Código: </label></td>
            <td><div id="codigo_subproducto" style="float: left; position: relative; top: 0.5em;"></div><input type="text" name="codigo" id="codigo"/></td>
        </tr>
        <tr>
            <td><label for="tipo">Tipo: </label></td>
            <td>
                <select name="tipo" id="tipo">
                    <option value="peso">Peso</option>
                    <option value="pieza">Pieza</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="kg_pieza">Kilos por pieza: </label></td>
            <td><input type="text" name="kg_pieza" id="kg_pieza"/></td>
        </tr>
        <tr>
            <td><label for="iva">IVA?: </label></td>
            <td><input type="checkbox" name="iva" id="iva" value="s"/></td>
        </tr>
        <tr>
            <td><label for="inventariado">Control de existencias?: </label></td>
            <td><input type="checkbox" name="inventariado" id="inventariado" value="s"/></td>
        </tr>
        <tr>
            <td colspan="2">Los siguientes valores afectan las comisiones de vendedores:</td>
        </tr>
        <tr>
            <td><label for="factor_peso">Factor de peso: </label></td>
            <td><input type="text" name="factor_peso" id="factor_peso" value="1.0"/><p style="font-size: .8em;">(Útil en el caso de paquetes, ej. si 1 unidad = 3.5kg entonces el factor de peso debe ser = 3.5)</p></td>
        </tr>
        <tr>
            <td><label for="tipo_factor_peso">Tipo de factor: </label></td>
            <td><input type="radio" name="tipo_factor_peso" id="tipo_factor_peso" value="factor" checked/>Factor
                <input type="radio" name="tipo_factor_peso" id="tipo_factor_peso" value="fijo"/>Fijo
                <p style="font-size: .8em;">(Factor = se multiplica por la cantidad. Fijo = No importa la cantidad en la venta, siempre se aplica la cantidad del factor.)</p>
            </td>
        </tr>
        <tr>
            <td><label for="observaciones">Observaciones: </label></td>
            <td><textarea rows="3" name="observaciones" id="observaciones"></textarea></td>
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
<script type="text/javascript">
    $(document).ready(function(){
        
        $("#codigo_subproducto").html($('option:selected',this).attr('codigo'));
        
        $("#id_subproducto").change(function(){
            var codigo = $('option:selected',this).attr('codigo');
            $("#codigo_subproducto").html(codigo);
            
            /*var id_subproducto = $(this).val();
            $.ajax({
                url: "<?php echo base_url().'catalogo/subproductos/getPorID/'; ?>"+id_subproducto,
                type: 'post',
                dataType: 'json'
            }).done(function(subproducto){
                $("#codigo_subproducto").html(subproducto.codigo);
            }).fail(function(){
                    alert("Error al buscar el código! URL: <?php echo base_url().'catalogo/subproductos/getPorID/'; ?>"+id_subproducto);
            });*/
        });
    });
</script>