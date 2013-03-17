<div id="contenido">
    
        <table class="tabla-filtros">
            <tr class="ui-widget-header">
                <td colspan="2" class="filtro-titulo">Filtros de busqueda de clientes</td>
            </tr>
            <tr>
                <td class="filtro-nombre">Cliente</td>
                <td class="filtro-dato">
                    <input type="text" name="nombre" id="nombre" />
                </td>
            </tr>
            <tr>
                <td colspan="2"><button id="buscar-cliente">Buscar</button></td>
            </tr>
        </table>
        <div class="ui-widget-content">
            <div style="height: 10em; overflow-y: auto; margin-bottom: 10px;">
                <table id="clientes" style="width: 100%;" class="tabla-listado tabla-seleccionable">

                </table>
            </div>
            <div id="datos" style="height: 2.5em;">
                <input type="hidden" id="id_cliente" />
                <div style="position: relative; float: left; top: .5em;">Lista de precios:</div>
                <div style="float: left;">
                    <select name="id_lista" id="id_lista" disabled >
                        <?php foreach( $listas as $lista ){?>
                        <option value="<?php echo $lista->id_lista; ?>"><?php echo $lista->nombre; ?></option>
                        <?php }?>
                    </select>
                </div>
                <div id="cliente_nombre" style="position: relative; float: left; top: .5em; left: 1em;">&nbsp;</div>
                <div style="float: right;"><input type="button" id="guarda-lista" value="Cambiar"/></div>
            </div>
        </div>
    <div style="height: 2.5em;"></div>
    <table class="tabla-filtros">
        <tr class="ui-widget-header">
            <td colspan="2" class="filtro-titulo">Filtros de busqueda de presentaciones</td>
        </tr>
        <tr>
            <td class="filtro-nombre">Presentación</td>
            <td class="filtro-dato">
                <input type="text" name="nombre-presentacion" id="nombre-presentacion" />
            </td>
        </tr>
        <tr>
            <td class="filtro-nombre">Línea</td>
            <td class="filtro-dato">
                <select name="id_linea" id="id_linea">
                    <option value="0">Selecciona una...</option>
                    <?php foreach( $lineas as $linea){ ?>
                        <option value="<?php echo $linea->id_linea; ?>"><?php echo $linea->nombre; ?></option>
                    <?php }?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><button id="buscar-presentacion">Buscar</button></td>
        </tr>
    </table>
    <div class="ui-widget-content">
        <div style="height: 25em; overflow-y: auto; margin-bottom: 10px;">
            <table id="precios" style="width: 100%;" class="tabla-listado tabla-seleccionable">

            </table>
        </div>
        <div id="datos" style="height: 2.5em;">
            <input type="hidden" id="id_articulo" />
            <div style="position: relative; float: left; top: .5em;">Descuento:</div>
            <div style="float: left;"><input type="text" name="descuento" id="descuento" size="6" disabled /></div>
            <div id="articulo_nombre" style="position: relative; float: left; top: .5em; left: 1em;">&nbsp;</div>
            <div style="float: right;"><input type="button" id="guarda-descuento" value="Guardar"/></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        
        function get_clientes(){
            var fila=0;
            var clase = '';
            
            $.ajax({
                url: "<?php echo base_url().'catalogo/ajax/get_clientes'; ?>",
                type: 'post',
                data: {nombre: $('#nombre').val()},
                dataType: 'json'
            }).done(function(clientes){
                //alert(clientes);
                $('#clientes').html('<tr class="ui-widget-header">'+
                '<td style="width: 10%;">Número</td>'+
                '<td style="width: 60%;">Nombre</td>'+
                '<td style="width: 30%;">Contacto</td>'+
                '</tr>');
                $.each(clientes,function(key,val){
                    if(fila % 2 == 0)
                        clase = 'fila-alterna';
                    else
                        clase='';
                    $('#clientes').append('<tr class="'+clase+'" id_cliente="'+val.id_cliente+'" nombre="'+val.nombre+'" id_lista="'+val.id_lista+'">'+
                                            '<td>'+val.id_cliente+'</td>'+
                                            '<td>'+val.nombre+'</td>'+
                                            '<td>'+val.contacto+'</td>');
                    fila++;
                });
            }).fail(function(){
                    alert("Error al buscar los clientes! URL: <?php echo current_url(); ?>");
            });
        }
        
        function get_precios(){
            var id_lista = $('option:selected','#id_lista').val()
            var id_cliente = $('#id_cliente').val();
            var id_linea = $('option:selected','#id_linea').val();
            var nombre = $('#nombre-presentacion').val();
            var fila=0;
            var clase = '';
            var precio_final = 0;
            //alert(id_linea);
            $.ajax({
                url: "<?php echo base_url().'catalogo/ajax/get_precios_descuentos'; ?>",
                type: 'post',
                dataType: 'json',
                data: {'id_lista': id_lista, 'id_cliente': id_cliente, 'nombre': nombre, 'id_linea': id_linea}
            }).done(function(precios){
                //alert(precios);
                $('#precios').html('<tr class="ui-widget-header">'+
                '<td style="width: 10%;">Código</td>'+
                '<td style="width: 50%;">Presentación</td>'+
                '<td style="width: 10%;">Precio</td>'+
                '<td style="width: 10%;">Precio mínimo</td>'+
                '<td style="width: 10%;">Descuento</td>'+
                '<td style="width: 10%;">Precio final</td>'+
                '</tr>');
                $.each(precios,function(key,val){
                    if(fila % 2 == 0)
                        clase = 'fila-alterna';
                    else
                        clase='';
                    if(!val.descuento)
                        val.descuento = '0.00';
                    precio_final = Number(val.precio) + Number(val.descuento);
                    $('#precios').append('<tr class="'+clase+'" id_articulo="'+val.id_articulo+'" nombre="'+val.nombre+'" codigo="'+val.codigo_subproducto+val.codigo+'" precio="'+val.precio+'" precio_minimo="'+val.precio_minimo+'" descuento="'+val.descuento+'">'+
                                            '<td>'+val.codigo_subproducto+val.codigo+'</td>'+
                                            '<td>'+val.nombre+'</td>'+
                                            '<td style="text-align: right;">'+val.precio+'</td>'+
                                            '<td style="text-align: right;">'+val.precio_minimo+'</td>'+
                                            '<td style="text-align: right;">'+val.descuento+'</td>'+
                                            '<td style="text-align: right;">'+$.fn.numberFormat( precio_final, 2 )+'</td>'+
                                            '</tr>');
                    fila++;
                });
            }).fail(function(){
                    alert("Error al buscar los precios! URL: <?php echo current_url(); ?>");
            });
        }
        
        function desactiva_inputs(){
            $('#guarda-descuento').attr('disabled','disabled');
            $('#datos input[type="text"]').val('');
            $('#articulo_nombre').html('');
        }
        
        $('#id_lista').change(function(){
            desactiva_inputs();
            get_precios();
        });
        
        $('#buscar-cliente').click(function(){
            desactiva_inputs();
            get_clientes();
        });
        
        $('#clientes').on('click','tr[class!="ui-widget-header"]',function(){
            //alert($(this).attr('id_articulo'));
            $('#id_cliente').val($(this).attr('id_cliente'));
            
            $('#id_lista').val($(this).attr('id_lista'));
            $('#id_lista').change();
            
            $('#clientes tr[class!="ui-widget-header"]').css('font-weight','normal');
            $(this).css('font-weight','bold');
            $('#cliente_nombre').html($(this).attr('nombre'));
            $('#datos select').removeAttr('disabled');
            $('#guarda-lista').removeAttr('disabled');
        });
    
        $('#guarda-lista').click(function(){
            var id_cliente = $('#id_cliente').val()
            var id_lista = $('option:selected','#id_lista').val()

            $.ajax({
                url: "<?php echo base_url().'catalogo/ajax/update_cliente_lista/'; ?>"+id_cliente+"/"+id_lista,
                type: 'post',
                dataType: 'text'
            }).done(function(resultado){
                get_clientes();
                get_precios();
                desactiva_inputs();
                $('#cliente_nombre').html('Lista de precios para el cliente '+id_cliente+' actualizada!')
            }).fail(function(){
                    alert("Error al actualizar la lista! URL: <?php echo current_url(); ?>");
            });
        });
        
        $('#buscar-presentacion').click(function(){
            desactiva_inputs();
            get_precios();
        });
        
        $('#precios').on('click','tr[class!="ui-widget-header"]',function(){
            //alert($(this).attr('id_articulo'));
            $('#id_articulo').val($(this).attr('id_articulo'));
            $('#precios tr[class!="ui-widget-header"]').css('font-weight','normal');
            $(this).css('font-weight','bold');
            $('#articulo_nombre').html($(this).attr('codigo')+'  '+$(this).attr('nombre'));
            $('#descuento').val($(this).attr('descuento'));
            $('#datos input').removeAttr('disabled');
            $('#descuento').focus();
        });
        
        $("#guarda-descuento").click(function(){
            var nombre = $('#articulo_nombre').html();
            var id_articulo = $('#id_articulo').val();
            var id_cliente = $('#id_cliente').val()
            var descuento = $('#descuento').val();

            $.ajax({
                url: "<?php echo base_url().'catalogo/ajax/update_descuento'; ?>",
                type: 'post',
                dataType: 'text',
                data: {'id_articulo': id_articulo, 'id_cliente': id_cliente, 'descuento': descuento}
            }).done(function(resultado){
                //alert(resultado);
                get_precios();
                desactiva_inputs();
                $('#articulo_nombre').html('Descuento de  '+nombre+' actualizado!')
            }).fail(function(){
                    alert("Error al actualizar el descuento! URL: <?php echo current_url(); ?>");
            });
            
        });
        
        /*
        $('#precios').on('mouseenter','tr',function(){
            $(this).addClass('ui-widget-header');
        });
        
        $('#precios').on('mouseleave','tr',function(){
            $(this).removeClass('ui-widget-header');
        });
        */
    });

</script>