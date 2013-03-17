<div id="contenido">
    <table class="tabla-filtros">
        <tr class="ui-widget-header">
            <td colspan="2" class="filtro-titulo">Filtros de busqueda</td>
        </tr>
        <tr>
            <td class="filtro-nombre">Lista de precios</td>
            <td class="filtro-dato">
                <select name="id_lista" id="id_lista">
                    <option>Selecciona una lista...</option>
                    <?php foreach($listas as $lista){ ?>
                    <option value="<?php echo $lista->id_lista; ?>"><?php echo $lista->nombre; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="filtro-nombre">Linea de productos</td>
            <td class="filtro-dato">
                <select name="id_linea" id="id_linea">
                    <option value="0">Selecciona una linea...</option>
                    <?php foreach($lineas as $linea){ ?>
                    <option value="<?php echo $linea->id_linea; ?>"><?php echo $linea->nombre; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="filtro-nombre">Nombre de la presentación</td>
            <td class="filtro-dato">
                <input type="text" name="nombre" id="nombre" />
            </td>
        </tr>
        <tr>
            <td colspan="2"><button id="buscar">Buscar</button></td>
        </tr>
    </table>
    <div class="ui-widget-content" style="height: 50em; overflow-y: auto;">
        <table id="precios" style="width: 100%;" class="tabla-listado tabla-seleccionable">
            
        </table>
    </div>
    <div id="datos" class="ui-widget-content" style="height: 2.5em;">
        <input type="hidden" id="id_articulo" />
        <div style="position: relative; float: left; top: .5em;">Precio:</div>
        <div style="float: left;"><input type="text" name="precio" id="precio" size="6" disabled /></div>
        <div style="position: relative; float: left; top: .5em; margin-left: 2em;">Precio mínimo:</div>
        <div style="float: left;"><input type="text" name="precio_minimo" id="precio_minimo" size="6" disabled /></div>
        <div id="articulo_nombre" style="position: relative; float: left; top: .5em; left: 1em;">&nbsp;</div>
        <div style="float: right;"><input type="button" id="guarda-precio" value="Guardar"/></div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        
        function get_precios(){
            var id_lista = $('option:selected','#id_lista').val()
            var id_linea = $('option:selected','#id_linea').val()
            var nombre = $('#nombre').val();
            var fila=0;
            var clase = '';
            //alert(id_linea);
            $.ajax({
                url: "<?php echo base_url().'catalogo/ajax/get_precios/'; ?>"+id_lista+"/"+id_linea+"/"+nombre,
                type: 'post',
                dataType: 'json'
            }).done(function(precios){
                //alert(precios);
                $('#precios').html('<tr class="ui-widget-header">'+
                '<td style="width: 10%;">Código</td>'+
                '<td style="width: 70%;">Presentación</td>'+
                '<td style="width: 10%;">Precio</td>'+
                '<td style="width: 10%;">Precio mínimo</td>'+
                '</tr>');
                $.each(precios,function(key,val){
                    if(fila % 2 == 0)
                        clase = 'fila-alterna';
                    else
                        clase='';
                    $('#precios').append('<tr class="'+clase+'" id_articulo="'+val.id_articulo+'" nombre="'+val.nombre+'" codigo="'+val.codigo_subproducto+val.codigo+'" precio="'+val.precio+'" precio_minimo="'+val.precio_minimo+'">'+
                                            '<td>'+val.codigo_subproducto+val.codigo+'</td>'+
                                            '<td>'+val.nombre+'</td>'+
                                            '<td style="text-align: right;">'+val.precio+'</td>'+
                                            '<td style="text-align: right;">'+val.precio_minimo+'</td>');
                    fila++;
                });
            }).fail(function(){
                    alert("Error al buscar los precios! URL: <?php echo current_url(); ?>");
            });
        }
        
        function desactiva_inputs(){
            $('#datos input').attr('disabled','disabled');
            $('#datos input[type="text"]').val('');
            $('#articulo_nombre').html('');
        }
        
        $('#buscar').click(function(){
            desactiva_inputs();
            get_precios();
        });
        
        $('#precios').on('click','tr[class!="ui-widget-header"]',function(){
            //alert($(this).attr('id_articulo'));
            $('#id_articulo').val($(this).attr('id_articulo'));
            $('#precios tr[class!="ui-widget-header"]').css('font-weight','normal');
            $(this).css('font-weight','bold');
            $('#articulo_nombre').html($(this).attr('codigo')+'  '+$(this).attr('nombre'));
            $('#precio').val($(this).attr('precio'));
            $('#precio_minimo').val($(this).attr('precio_minimo'));
            $('#datos input').removeAttr('disabled');
            $('#precio').focus();
        });
        
        $("#guarda-precio").click(function(){
            var nombre = $('#articulo_nombre').html();
            var id_articulo = $('#id_articulo').val();
            var id_lista = $('option:selected','#id_lista').val()
            var precio = $('#precio').val();
            var precio_minimo = $('#precio_minimo').val();
            $.ajax({
                url: "<?php echo base_url().'catalogo/ajax/update_precio/'; ?>"+id_articulo+"/"+id_lista+"/"+precio+"/"+precio_minimo,
                type: 'post',
                dataType: 'text'
            }).done(function(resultado){
                get_precios();
                desactiva_inputs();
                $('#articulo_nombre').html('Precio de  '+nombre+' actualizado!')
            }).fail(function(){
                    alert("Error al actualizar el precio! URL: <?php echo current_url(); ?>");
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