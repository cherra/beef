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
            <td colspan="2" class="filtro-titulo">Filtros de busqueda de productos</td>
        </tr>
        <tr>
            <td class="filtro-nombre">Producto</td>
            <td class="filtro-dato">
                <input type="text" name="nombre-producto" id="nombre-producto" />
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
            <td class="filtro-nombre">Mostrar</td>
            <td class="filtro-dato">
                <input type="radio" name="mostrar" value="todos" checked />Todos
                <input type="radio" name="mostrar" value="asignados" />Asignados
            </td>
        </tr>
        <tr>
            <td colspan="2"><button id="buscar-producto">Buscar</button></td>
        </tr>
    </table>
    <div style="text-align: left;">Para asignar o quitar un producto haz click sobre él.</div>
    <div class="ui-widget-content">
        <div style="height: 25em; overflow-y: auto; margin-bottom: 10px;">
            <table id="productos" style="width: 100%;" class="tabla-listado tabla-seleccionable">

            </table>
            <input type="hidden" id="id_producto" />
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
        
        function get_productos(){
            var id_proveedor = $('#id_proveedor').val();
            var id_linea = $('option:selected','#id_linea').val();
            var nombre = $('#nombre-producto').val();
            var mostrar = $('input[name="mostrar"]:checked').val();
            var fila=0;
            var clase = '';
            var style= '';
            var asignado = 0;
            //alert(id_linea);
            $.ajax({
                url: "<?php echo base_url().'catalogo/ajax/get_productos_por_proveedor'; ?>",
                type: 'post',
                dataType: 'json',
                data: {'id_proveedor': id_proveedor, 'nombre': nombre, 'id_linea': id_linea, 'mostrar': mostrar}
            }).done(function(productos){
                //alert(precios);
                $('#productos').html('<tr class="ui-widget-header">'+
                '<td style="width: 75%;">Producto</td>'+
                '<td style="width: 25%;">Linea</td>'+
                '</tr>');
                $.each(productos,function(key,val){
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
                    $('#productos').append('<tr class="'+clase+'" style="'+style+'" id_producto="'+val.id_producto+'" nombre="'+val.nombre+'" asignado="'+asignado+'">'+
                                            '<td>'+val.nombre+'</td>'+
                                            '<td>'+val.nombre_linea+'</td>'+
                                            '</tr>');
                    fila++;
                });
            }).fail(function(){
                    alert("Error al buscar los productos! URL: <?php echo current_url(); ?>");
            });
        }
        
        function desactiva_inputs(){
            $('#nombre-producto').val('');
            $('#id_linea').val('0');
        }
        
        $('#buscar-proveedor').click(function(){
            desactiva_inputs();
            $('#productos').html('');
            get_proveedores();
        });
        
        $('#proveedores').on('click','tr[class!="ui-widget-header"]',function(){
            //alert($(this).attr('id_articulo'));
            $('#id_proveedor').val($(this).attr('id_proveedor'));
            
            $('#proveedores tr[class!="ui-widget-header"]').css('font-weight','normal');
            $(this).css('font-weight','bold');
            get_productos();
        });
    
        $('#buscar-producto').click(function(){
            //desactiva_inputs();
            get_productos();
        });
        
        
        $('#productos').on('click','tr[class!="ui-widget-header"]',function(){
            var id_producto = $(this).attr('id_producto');
            var id_proveedor = $('#id_proveedor').val();
            
            if($(this).attr('asignado') == 1)
            {    
                $.ajax({
                    url: "<?php echo base_url().'catalogo/ajax/unset_producto_proveedor'; ?>",
                    type: 'post',
                    dataType: 'text',
                    data: {'id_proveedor': id_proveedor, 'id_producto': id_producto}
                }).done(function(){
                    get_productos();
                }).fail(function(){
                    alert("Error al quitar el producto.");
                });
            }else{
                $.ajax({
                    url: "<?php echo base_url().'catalogo/ajax/set_producto_proveedor'; ?>",
                    type: 'post',
                    dataType: 'text',
                    data: {'id_proveedor': id_proveedor, 'id_producto': id_producto}
                }).done(function(){
                    get_productos();
                }).fail(function(){
                    alert("Error al agregar el producto.");
                });
            }
        });
    });

</script>