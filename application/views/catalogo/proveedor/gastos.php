<div id="contenido">
    
        <table class="tabla-filtros">
            <tr class="ui-widget-header">
                <td colspan="2" class="filtro-titulo">Filtros de busqueda de proveedores</td>
            </tr>
            <tr>
                <td class="filtro-nombre">Proveedor</td>
                <td class="filtro-dato">
                    <input type="text" name="razon_social" id="razon_social" />
                </td>
            </tr>
            <tr>
                <td colspan="2"><button id="buscar-proveedor">Buscar</button></td>
            </tr>
        </table>
        <div class="ui-widget-content">
            <div style="height: 10em; overflow-y: auto; margin-bottom: 10px;">
                <table id="proveedores" style="width: 100%;" class="tabla-listado tabla-seleccionable">

                </table>
                <input type="hidden" id="id_proveedor" />
            </div>
        </div>
    <div style="height: 1em;"></div>
    <table class="tabla-filtros">
        <tr class="ui-widget-header">
            <td colspan="2" class="filtro-titulo">Filtros de busqueda de gastos</td>
        </tr>
        <tr>
            <td class="filtro-nombre">Gasto</td>
            <td class="filtro-dato">
                <input type="text" name="nombre-gasto" id="nombre-gasto" />
            </td>
        </tr>
        <tr>
            <td class="filtro-nombre">Mostrar</td>
            <td class="filtro-dato">
                <input type="radio" name="mostrar" value="todos" checked />Todos
                <input type="radio" name="mostrar" value="asignados" />Asignados
            </td>
        </tr>
        <tr>
            <td colspan="2"><button id="buscar-gasto">Buscar</button></td>
        </tr>
    </table>
    <div style="text-align: right;">Para asignar o quitar un gasto haz click sobre él.</div>
    <div class="ui-widget-content">
        <div style="height: 25em; overflow-y: auto; margin-bottom: 10px;">
            <table id="gastos" style="width: 100%;" class="tabla-listado tabla-seleccionable">

            </table>
            <input type="hidden" id="id_gasto" />
        </div>
        <div>* <b>Negritas</b> = asignados al proveedor.</div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        
        function get_proveedores(){
            var fila=0;
            var clase = '';
            
            $.ajax({
                url: "<?php echo base_url().'catalogo/ajax/get_proveedores'; ?>",
                type: 'post',
                data: {razon_social: $('#razon_social').val()},
                dataType: 'json'
            }).done(function(proveedores){
                //alert(clientes);
                $('#proveedores').html('<tr class="ui-widget-header">'+
                '<td style="width: 35%;">Razón social</td>'+
                '<td style="width: 35%;">Nombre comercial</td>'+
                '<td style="width: 30%;">Contacto</td>'+
                '</tr>');
                $.each(proveedores,function(key,val){
                    if(fila % 2 == 0)
                        clase = 'fila-alterna';
                    else
                        clase='';
                    $('#proveedores').append('<tr class="'+clase+'" id_proveedor="'+val.id_proveedor+'" razon_social="'+val.razon_social+'">'+
                                            '<td>'+val.razon_social+'</td>'+
                                            '<td>'+val.nombre_comercial+'</td>'+
                                            '<td>'+val.contacto+'</td>');
                    fila++;
                });
            }).fail(function(){
                    alert("Error al buscar los proveedores! URL: <?php echo current_url(); ?>");
            });
        }
        
        function get_gastos(){
            var id_proveedor = $('#id_proveedor').val();
            var nombre = $('#nombre-gasto').val();
            var mostrar = $('input[name="mostrar"]:checked').val();
            var fila=0;
            var clase = '';
            var style= '';
            var asignado = 0;
            //alert(id_linea);
            $.ajax({
                url: "<?php echo base_url().'catalogo/ajax/get_gastos_por_proveedor'; ?>",
                type: 'post',
                dataType: 'json',
                data: {'id_proveedor': id_proveedor, 'nombre': nombre, 'mostrar': mostrar}
            }).done(function(gastos){
                //alert(precios);
                $('#gastos').html('<tr class="ui-widget-header">'+
                '<td style="width: 100%;">Gasto</td>'+
                '</tr>');
                $.each(gastos,function(key,val){
                    if(fila % 2 == 0)
                        clase = 'fila-alterna';
                    else
                        clase='';
                    if(val.id_proveedor){
                        style = 'font-weight: bold;';
                        asignado = 1;
                    }
                    else{
                        style = '';
                        asignado = 0;
                    }
                    $('#gastos').append('<tr class="'+clase+'" style="'+style+'" id_gasto="'+val.id_gasto+'" nombre="'+val.descripcion+'" asignado="'+asignado+'">'+
                                            '<td>'+val.descripcion+'</td>'+
                                            '</tr>');
                    fila++;
                });
            }).fail(function(){
                    alert("Error al buscar los gastos! URL: <?php echo current_url(); ?>");
            });
        }
        
        function desactiva_inputs(){
            $('#nombre-gasto').val('');
        }
        
        $('#buscar-proveedor').click(function(){
            desactiva_inputs();
            $('#gastos').html('');
            get_proveedores();
        });
        
        $('#proveedores').on('click','tr[class!="ui-widget-header"]',function(){
            //alert($(this).attr('id_articulo'));
            $('#id_proveedor').val($(this).attr('id_proveedor'));
            
            $('#proveedores tr[class!="ui-widget-header"]').css('font-weight','normal');
            $(this).css('font-weight','bold');
            get_gastos();
        });
    
        $('#buscar-gasto').click(function(){
            //desactiva_inputs();
            get_gastos();
        });
        
        $('#gastos').on('click','tr[class!="ui-widget-header"]',function(){
            var id_gasto = $(this).attr('id_gasto');
            var id_proveedor = $('#id_proveedor').val();
            
            if($(this).attr('asignado') == 1)
            {    
                $.ajax({
                    url: "<?php echo base_url().'catalogo/ajax/unset_gasto_proveedor'; ?>",
                    type: 'post',
                    dataType: 'text',
                    data: {'id_proveedor': id_proveedor, 'id_gasto': id_gasto}
                }).done(function(){
                    get_gastos();
                }).fail(function(){
                    alert("Error al quitar el gasto.");
                });
            }else{
                $.ajax({
                    url: "<?php echo base_url().'catalogo/ajax/set_gasto_proveedor'; ?>",
                    type: 'post',
                    dataType: 'text',
                    data: {'id_proveedor': id_proveedor, 'id_gasto': id_gasto}
                }).done(function(){
                    get_gastos();
                }).fail(function(){
                    alert("Error al agregar el gasto.");
                });
            }
        });
    });

</script>