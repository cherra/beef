<div id="contenido">
    
        <table class="tabla-filtros">
            <tr class="ui-widget-header">
                <td colspan="2" class="filtro-titulo">Filtros de busqueda de paquetes</td>
            </tr>
            <tr>
                <td class="filtro-nombre">Paquete</td>
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
                <td colspan="2"><button id="buscar-paquete">Buscar</button></td>
            </tr>
        </table>
        <div style="height: 1.3em;">Selecciona una presentación que se vaya a vender en forma de paquete:</div>
        <div class="ui-widget-content" style="height: 15em; overflow-y: auto; margin-bottom: 10px;">
            <table id="paquetes" style="width: 100%;" class="tabla-listado tabla-seleccionable">

            </table>
            <input type="hidden" id="id_articulo" />
        </div>
        <div style="height: 0.5em;"></div>
        <div>
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
                <td class="filtro-nombre">Linea:</td>
                <td class="filtro-dato">
                    <select name="id_linea-presentacion" id="id_linea-presentacion">
                        <option value="">Todos</option>
                        <?php 
                        foreach($lineas AS $linea){
                            ?>
                        <option value="<?php echo $linea->id_linea; ?>"><?php echo $linea->nombre; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </td>
                </tr>
                <tr>
                    <td colspan="2"><button id="buscar-presentacion">Buscar</button></td>
                </tr>
            </table>
        </div>
        <div class="columna">
            <div style="height: 1.3em; margin-top: 2.6em;">Haz click sobre una presentación para agregarla al paquete:</div>
            <div class="ui-widget-content" style="height: 15em; overflow-y: auto; margin-bottom: 10px;">
                <table id="presentaciones" style="width: 100%;" class="tabla-listado tabla-seleccionable">

                </table>
            </div>
        </div>
        <div class="columna">
            <div style="height: 3.9em;">Aquí se muestran las presentaciones incluidas en el paquete:</br>Un click= cambiar la cantidad.</br>Doble click= quita la presentación del paquete.</div>
            <div class="ui-widget-content" style="height: 11.5em; overflow-y: auto; margin-bottom: 10px;">
                <table id="presentaciones-paquete" style="width: 100%;" class="tabla-listado tabla-seleccionable">

                </table>
            </div>
            <div id="datos" class="ui-widget-content" style="height: 2.3em;">
                <input type="hidden" id="id_articulo_paquete" />
                <div style="position: relative; float: left; top: .5em;">Cantidad:</div>
                <div style="float: left;"><input type="text" name="cantidad" id="cantidad" size="6" disabled /></div>
                <div id="articulo_nombre" style="position: relative; float: left; top: .5em; left: 1em;">&nbsp;</div>
                <div style="float: right;"><input type="button" id="guarda-cantidad" value="Guardar"/></div>
            </div>
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
                $('#paquetes').html('<tr class="ui-widget-header">'+
                '<td style="width: 80%;">Nombre</td>'+
                '<td style="width: 20%;">Código</td>'+
                '</tr>');
                $.each(presentaciones,function(key,val){
                    if(fila % 2 == 0)
                        clase = 'fila-alterna';
                    else
                        clase='';
                    $('#paquetes').append('<tr class="'+clase+'" id_articulo="'+val.id_articulo+'" nombre="'+val.nombre+'">'+
                                            '<td>'+val.nombre+'</td>'+
                                            '<td>'+val.codigo_subproducto+val.codigo+'</td>');
                    fila++;
                });
            }).fail(function(){
                    alert("Error al buscar los paquetes! URL: <?php echo current_url(); ?>");
            });
        }
        
        function get_presentaciones_fuera(){
            var id_articulo = $('#id_articulo').val();
            var id_linea = $('option:selected','#id_linea-presentacion').val();
            var nombre = $('#nombre-presentacion').val();
            var fila=0;
            var clase = '';

            $.ajax({
                url: "<?php echo base_url().'catalogo/ajax/get_presentaciones_fuera_paquete'; ?>",
                type: 'post',
                dataType: 'json',
                data: {'id_articulo': id_articulo, 'nombre': nombre, 'id_linea': id_linea}
            }).done(function(presentaciones){
                //alert(presentaciones);
                $('#presentaciones').html('<tr class="ui-widget-header">'+
                '<td style="width: 80%;">Presentación</td>'+
                '<td style="width: 20%;">Código</td>'+
                '</tr>');
                $.each(presentaciones,function(key,val){
                    if(fila % 2 == 0)
                        clase = 'fila-alterna';
                    else
                        clase='';
                    $('#presentaciones').append('<tr class="'+clase+'" id_articulo_paquete="'+val.id_articulo+'" nombre="'+val.nombre+'">'+
                                            '<td>'+val.nombre+'</td>'+
                                            '<td>'+val.codigo_subproducto+val.codigo+'</td>'+
                                            '</tr>');
                    fila++;
                });
                //alert(presentaciones);
            }).fail(function(){
                    alert("Error al buscar las presentaciones! URL: <?php echo current_url(); ?>");
            });
        }
        
        function get_presentaciones_dentro(){
            var id_articulo = $('#id_articulo').val();
            var fila=0;
            var clase = '';

            $.ajax({
                url: "<?php echo base_url().'catalogo/ajax/get_presentaciones_dentro_paquete'; ?>",
                type: 'post',
                dataType: 'json',
                data: {'id_articulo': id_articulo}
            }).done(function(presentaciones){
                //alert(precios);
                $('#presentaciones-paquete').html('<tr class="ui-widget-header">'+
                '<td style="width: 70%;">Presentación</td>'+
                '<td style="width: 15%;">Código</td>'+
                '<td style="width: 15%;">Cantidad</td>'+
                '</tr>');
                $.each(presentaciones,function(key,val){
                    if(fila % 2 == 0)
                        clase = 'fila-alterna';
                    else
                        clase='';
                    $('#presentaciones-paquete').append('<tr class="'+clase+'" id_articulo_paquete="'+val.id_articulo+'" nombre="'+val.nombre+'" cantidad="'+val.cantidad+'">'+
                                            '<td>'+val.nombre+'</td>'+
                                            '<td>'+val.codigo_subproducto+val.codigo+'</td>'+
                                            '<td>'+val.cantidad+'</td>'+
                                            '</tr>');
                    fila++;
                });
                //alert(presentaciones);
            }).fail(function(){
                    alert("Error al buscar las presentaciones! URL: <?php echo current_url(); ?>");
            });
        }
        
        function desactiva_inputs(){
            $('#datos input').attr('disabled','true');
            $('#cantidad').val('');
            //$('#nombre-presentacion').val('');
        }
        
        $('#buscar-paquete').click(function(){
            desactiva_inputs();
            $('#paquetes').html('');
            $('#presentaciones').html('');
            $('#presentaciones-paquete').html('');
            get_presentaciones();
        });
        
        $('#paquetes').on('click','tr[class!="ui-widget-header"]',function(){
            //alert($(this).attr('id_articulo'));
            $('#id_articulo').val($(this).attr('id_articulo'));
            
            $('#paquetes tr[class!="ui-widget-header"]').css('font-weight','normal');
            $(this).css('font-weight','bold');
            get_presentaciones_fuera();
            get_presentaciones_dentro();
        });
    
        $('#buscar-presentacion').click(function(){
            desactiva_inputs();
            get_presentaciones_fuera();
        });
        
        
        $('#presentaciones').on('click','tr[class!="ui-widget-header"]',function(){
            var id_articulo_paquete = $(this).attr('id_articulo_paquete');
            var id_articulo = $('#id_articulo').val();
            
            $.ajax({
                url: "<?php echo base_url().'catalogo/ajax/set_presentacion_paquete'; ?>",
                type: 'post',
                dataType: 'text',
                data: {'id_articulo': id_articulo, 'id_articulo_paquete': id_articulo_paquete}
            }).done(function(){
                get_presentaciones_fuera();
                get_presentaciones_dentro();
            }).fail(function(){
                alert("Error al agregar la presentación.");
            });
        });
        
        $('#presentaciones-paquete').on('click','tr[class!="ui-widget-header"]',function(){
            $('#presentaciones-paquete tr[class!="ui-widget-header"]').css('font-weight','normal');
            $(this).css('font-weight','bold');
            $('#id_articulo_paquete').val($(this).attr('id_articulo_paquete'));
            $('#cantidad').removeAttr('disabled').val($(this).attr('cantidad')).focus();
            $('#guarda-cantidad').removeAttr('disabled');
            //$('#cantidad').removeAttr('disabled');
        });
        
        $('#presentaciones-paquete').on('dblclick','tr[class!="ui-widget-header"]',function(){
            var id_articulo = $('#id_articulo').val();
            var id_articulo_paquete = $('#id_articulo_paquete').val();
            
            desactiva_inputs();
            
            $.ajax({
                url: "<?php echo base_url().'catalogo/ajax/delete_presentacion_paquete'; ?>",
                type: 'post',
                dataType: 'text',
                data: {id_articulo: id_articulo, id_articulo_paquete: id_articulo_paquete}
            }).done(function(){
                get_presentaciones_fuera();
                get_presentaciones_dentro();
            }).fail(function(){
                alert("Error al quitar la presentación.");
            });
        });
        
        $('#guarda-cantidad').click(function(){
            var id_articulo_paquete = $('#id_articulo_paquete').val();
            var id_articulo = $('#id_articulo').val();
            var cantidad = $('#cantidad').val();
            
            $.ajax({
                url: "<?php echo base_url().'catalogo/ajax/set_cantidad_presentacion_paquete'; ?>",
                type: 'post',
                dataType: 'text',
                data: {id_articulo: id_articulo, id_articulo_paquete: id_articulo_paquete, cantidad: cantidad}
            }).done(function(){
                //get_presentaciones_fuera();
                desactiva_inputs();
                get_presentaciones_dentro();
            }).fail(function(){
                alert("Error al guardar la cantidad.");
            });
        });
    });

</script>