<div id="contenido">
    <table class="tabla-filtros">
        <tr class="ui-widget-header">
            <td colspan="2" class="filtro-titulo">Filtros de busqueda de presentaciones</td>
        </tr>
        <tr>
            <td class="filtro-nombre">Presentación</td>
            <td class="filtro-dato">
                <input type="text" name="nombre" id="nombre" value="<?php echo $filtros['nombre']; ?>" />
            </td>
        </tr>
        <tr>
        <td class="filtro-nombre">Linea:</td>
        <td class="filtro-dato">
            <select name="id_linea" id="id_linea">
                <option value="">Todos</option>
                <?php 
                foreach($lineas AS $linea){
                    ?>
                <option value="<?php echo $linea->id_linea; ?>" <?php if($filtros['id_linea'] == $linea->id_linea) echo "selected"; ?>><?php echo $linea->nombre; ?></option>
                <?php
                }
                ?>
            </select>
        </td>
        </tr>
        <tr>
            <td colspan="2"><button id="buscar">Buscar</button></td>
        </tr>
    </table>
    <div style="height: 1.3em;">Selecciona una presentación para ver sus descuentos:</div>
    <div class="ui-widget-content" style="height: 15em; overflow-y: auto; margin-bottom: 10px;">
        <table id="presentaciones" style="width: 100%;" class="tabla-listado tabla-seleccionable">

        </table>
        <input type="hidden" id="id_articulo" />
    </div>
    
    <table class="tabla-filtros">
        <tr class="ui-widget-header">
            <td colspan="2" class="filtro-titulo">Filtros de busqueda de clientes</td>
        </tr>
        <tr>
            <td class="filtro-nombre">Cliente</td>
            <td class="filtro-dato">
                <input type="text" name="nombre-cliente" id="nombre" value="<?php echo $filtros['nombre-cliente']; ?>" />
            </td>
        </tr>
        <tr>
            <td colspan="2"><button id="buscar-cliente">Buscar</button></td>
        </tr>
    </table>
    <div class="ui-widget-content" style="height: 15em; overflow-y: auto; margin-bottom: 10px;">
        <table id="clientes" style="width: 100%;" class="tabla-listado tabla-seleccionable">

        </table>
    </div>
    <div id="datos" class="ui-widget-content" style="height: 2.3em;">
        <input type="hidden" id="id_cliente" />
        <div style="position: relative; float: left; top: .5em;">Descuento:</div>
        <div style="float: left;"><input type="text" name="descuento" id="descuento" size="6" disabled /></div>
        <div id="cliente_nombre" style="position: relative; float: left; top: .5em; left: 1em;">&nbsp;</div>
        <div style="float: right;"><input type="button" id="guarda" value="Guardar"/></div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        
        function get_presentaciones(){
            var fila=0;
            var clase = '';
            
            $.ajax({
                url: "<?php echo base_url().'catalogo/ajax/get_presentaciones'; ?>",
                type: 'post',
                data: {nombre: $('#nombre').val(), id_linea: $('#id_linea').val()},
                dataType: 'json'
            }).done(function(presentaciones){
                //alert(clientes);
                $('#presentaciones').html('<tr class="ui-widget-header">'+
                '<td style="width: 90%;">Nombre</td>'+
                '<td style="width: 10%;">Código</td>'+
                '</tr>');
                $.each(presentaciones,function(key,val){
                    if(fila % 2 == 0)
                        clase = 'fila-alterna';
                    else
                        clase='';
                    $('#presentaciones').append('<tr class="'+clase+'" id_articulo="'+val.id_articulo+'" nombre="'+val.nombre+'">'+
                                            '<td>'+val.nombre+'</td>'+
                                            '<td>'+val.codigo_subproducto+val.codigo+'</td>');
                    fila++;
                });
            }).fail(function(){
                    alert("Error al buscar los paquetes! URL: <?php echo current_url(); ?>");
            });
        }
        
        function get_clientes(){
            var fila=0;
            var clase = '';
            var precio_final = 0;
            
            $.ajax({
                url: "<?php echo base_url().'catalogo/ajax/get_descuento_presentacion_cliente'; ?>",
                type: 'post',
                data: {id_articulo: $('#id_articulo').val()},
                dataType: 'json'
            }).done(function(clientes){
                //alert(clientes);
                $('#clientes').html('<tr class="ui-widget-header">'+
                '<td style="width: 8%;">Núm.</td>'+
                '<td style="width: 52%;">Nombre</td>'+
                '<td style="width: 8%;">Última compra</td>'+
                '<td style="width: 8%;">Precio</td>'+
                '<td style="width: 8%;">Desc.</td>'+
                '<td style="width: 8%;">Precio final</td>'+
                '<td style="width: 8%;">Precio minimo</td>'+
                '</tr>');
                $.each(clientes,function(key,val){
                    if(fila % 2 == 0)
                        clase = 'fila-alterna';
                    else
                        clase='';
                    precio_final = Number(val.precio) + Number(val.descuento);
                    $('#clientes').append('<tr class="'+clase+'" id_cliente="'+val.id_cliente+'" descuento="'+val.descuento+'">'+
                                            '<td>'+val.id_cliente+'</td>'+
                                            '<td>'+val.nombre+'</td>'+
                                            '<td>'+'</td>'+
                                            '<td align="right">'+val.precio+'</td>'+
                                            '<td align="right">'+val.descuento+'</td>'+
                                            '<td align="right">'+$.fn.numberFormat(precio_final, 2)+'</td>'+
                                            '<td align="right">'+val.precio_minimo+'</td>');
                    fila++;
                });
            }).fail(function(){
                    alert("Error al buscar los clientes! URL: <?php echo current_url(); ?>");
            });
        }
        
        function desactiva_inputs(){
            $('#datos input').attr('disabled','true');
            $('#descuento').val('');
        }
        
        $('#buscar').click(function(){
            desactiva_inputs();
            $('#presentaciones').html('');
            $('#clientes').html('');
            get_presentaciones();
        });
        
        $('#presentaciones').on('click','tr[class!="ui-widget-header"]',function(){
            $('#id_articulo').val($(this).attr('id_articulo'));
            
            $('#presentaciones tr[class!="ui-widget-header"]').css('font-weight','normal');
            $(this).css('font-weight','bold');
            
            get_clientes();
        });
        
        $('#clientes').on('click','tr[class!="ui-widget-header"]',function(){
            $('#id_cliente').val($(this).attr('id_cliente'));
            
            $('#clientes tr[class!="ui-widget-header"]').css('font-weight','normal');
            $(this).css('font-weight','bold');
            
            $('#descuento').removeAttr('disabled').val($(this).attr('descuento')).focus();
            $('#guarda').removeAttr('disabled');
        });
        
        $('#guarda').click(function(){
            $.ajax({
                url: "<?php echo base_url().'catalogo/ajax/update_descuento_presentacion_cliente'; ?>",
                type: 'post',
                data: {id_articulo: $('#id_articulo').val(), id_cliente: $('#id_cliente').val(), descuento: $('#descuento').val()},
                dataType: 'json'
            }).done(function(){
                desactiva_inputs();
                get_clientes();
            }).fail(function(){
                alert('Error al actualizar el descuento');
            });
        });
        
    });

</script>