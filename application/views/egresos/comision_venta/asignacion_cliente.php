<div id="contenido">
    <?php echo form_open('',array('class'=>'ajax','id'=>'form_busqueda')); ?>
    <table class="tabla-filtros">
        <tr class="ui-widget-header">
            <td colspan="2" class="filtro-titulo">Filtros de busqueda de vendedores</td>
        </tr>
        <tr>
            <td class="filtro-nombre">Vendedor</td>
            <td class="filtro-dato">
                <input type="text" name="nombre" id="nombre" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="hidden" name="borrado" value="n" />
                <input type="submit" value="Buscar" />
            </td>
        </tr>
    </table>
    <?php echo form_close(); ?>
    <div style="margin-left: auto; margin-right: 1px;">Haz click sobre el vendedor para ver sus clientes asignado o asignarle nuevos.</div>
        <div class="ui-widget-content box_list">
            <table id="vendedores" class="tabla-listado tabla-seleccionable">

            </table>
            <input type="hidden" id="id_vendedor" value=""/>
        </div>
    <?php echo form_open('',array('class'=>'ajax','id'=>'form_busqueda_clientes_asignados')); ?>
    <table class="tabla-filtros">
        <tr class="ui-widget-header">
            <td colspan="2" class="filtro-titulo">Filtros de busqueda de clientes asignados</td>
        </tr>
        <tr>
            <td class="filtro-nombre">Cliente</td>
            <td class="filtro-dato">
                <input type="text" name="nombre_cliente" id="nombre_cliente" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="hidden" name="bloqueado" value="n" />
                <input type="submit" value="Buscar" />
            </td>
        </tr>
    </table>
    <?php echo form_close(); ?>
    
    <div style="margin-left: auto; margin-right: 1px; margin-top: 10px;">Clientes asignados. (Haz click sobre algún cliente para quitar la asignación al vendedor)</div>
    <div class="ui-widget-content box_list">
        <table id="clientes_asignados" class="tabla-listado tabla-seleccionable">

        </table>
        <input type="hidden" id="id_cliente_asignado" value="" />
    </div>
    <?php echo form_open('',array('class'=>'ajax','id'=>'form_cliente_asignado')); ?>
    <table class="tabla-captura" id="tabla_modificar_cliente" style="display: none;">
        <tr>
            <td style="width: 30%;"><label for="fecha_asignada">Fecha de asignación: </label></td>
            <td style="width: 30%;"><input type="text" class="fecha" name="fecha_asignada" id="fecha_asignada" required="required"/></td>
            <td style="width: 40%;">
                <input type="hidden" id="id_comision" name="id_comision" />
                <input type="submit" value="Cambiar"/>
            </td>
        </tr>
    </table>
    <?php echo form_close(); ?>
    
</div>
<script type="text/javascript">
    $(document).ready(function(){
        
        function get_vendedores(){
            var loader;
            var datos = '';
            loader = new ajaxLoader($('#contenido'));
            
            $.ajax({
                url: "<?php echo base_url().'egresos/comisiones_ventas/get_vendedores'; ?>",
                type: 'post',
                data: $('#form_busqueda').serialize(),
                dataType: 'json'
            }).done(function(vendedores){
                //alert(clientes);
                $('#vendedores').html('<tr class="ui-widget-header">'+
                '<td style="width: 60%; text-align: center;">Nombre</td>'+
                '<td style="width: 40%; text-align: center;">Apellido</td>'+
                '</tr>');
                $.each(vendedores,function(key,val){
                    datos += '<tr id_vendedor="'+val.id_empleado+'" nombre="'+val.nombre+'" >'+
                                            '<td align="left">'+val.nombre+'</td>'+
                                            '<td align="left">'+val.apellido+'</td></tr>';
                });
                $('#vendedores').append(datos);
                aplica_estilo_listado();
                loader.remove();
                
            }).fail(function(){
                    alert("Error al buscar los vendedores! URL: <?php echo current_url(); ?>");
            });
        }
        
        function get_clientes(){
            var datos = "";
            var loader;
            loader = new ajaxLoader($('#contenido'));
                
            $.ajax({
                url: "<?php echo base_url().'egresos/comisiones_ventas/get_clientes_asignados'; ?>",
                type: 'post',
                data: {id_vendedor: $("#id_vendedor").val(), nombre_cliente: $("#nombre_cliente").val()},
                dataType: 'json'
            }).done(function(clientes){
                $('#tabla_modificar_cliente').css('display','none');
                //alert(clientes);
                $('#clientes_asignados').html('<tr class="ui-widget-header">'+
                '<td style="width: 10%; text-align: center;">Número</td>'+
                '<td style="width: 70%; text-align: center;">Nombre</td>'+
                '<td style="width: 20%; text-align: center;">Fecha asignacion</td>'+
                '</tr>');
                $.each(clientes,function(key,val){
                    datos += '<tr id_empleado="'+val.id_empleado+'" id_cliente="'+val.id_cliente+'" id_comision="'+val.id_comision+'" fecha="'+val.fecha+'" >'+
                                            '<td align="left">'+val.id_cliente+'</td>'+
                                            '<td align="left">'+val.nombre+'</td>'+
                                            '<td align="left">'+val.fecha+'</td></tr>';
                });
                $('#clientes_asignados').append(datos);
                aplica_estilo_listado();
                loader.remove();
            }).fail(function(){
                alert("Error al obtener los clientes asignados! URL: <?php echo current_url(); ?>");
                loader.remove();
            });
        }
        
        $('#form_busqueda').validate({
            submitHandler: function(form){
                get_vendedores();
            }
        });
        
        $('#vendedores').on('click','tr[class!="ui-widget-header"]',function(){
            $('#id_vendedor').val($(this).attr('id_vendedor'));
            
            $('#vendedores tr[class!="ui-widget-header"]').removeClass('fila-seleccionada');
            $(this).addClass('fila-seleccionada');
            get_clientes();
        });
        
        $('#clientes_asignados').on('click','tr[class!="ui-widget-header"]',function(){
            $('#id_cliente_asignado').val($(this).attr('id_cliente'));
            
            $('#clientes_asignados tr[class!="ui-widget-header"]').removeClass('fila-seleccionada');
            $(this).addClass('fila-seleccionada');
            $('#fecha_asignada').val($(this).attr('fecha'));
            $('#id_comision').val($(this).attr('id_comision'));
            $('#tabla_modificar_cliente').css('display','block');
        });
        
        $('#form_busqueda_clientes_asignados').validate({
            submitHandler: function(form){
                get_clientes();
            }
        });
        
        $('#form_cliente_asignado').validate({
            submitHandler: function(form){
                var cambiar = confirm("Estas seguro(a) que quieres cambiar la fecha de asignación?");
                if(cambiar){
                    var loader;
                    var datos = '';
                    loader = new ajaxLoader($('#contenido'));

                    $.ajax({
                        url: "<?php echo base_url().'egresos/comisiones_ventas/update_fecha_asignacion'; ?>",
                        type: 'post',
                        data: {fecha: $('#fecha_asignada').val(), id_comision: $('#id_comision').val()},
                        dataType: 'json'
                    }).done(function(respuesta){
                        if(respuesta > 0){
                            alert("Fecha actualizada con éxito!");
                            get_clientes();
                        }else{
                            alert("Ocurrió un error al actualizar la fecha!")
                        }
                        loader.remove();

                    }).fail(function(){
                            alert("Error al actualizar la fecha de asignación! URL: <?php echo current_url(); ?>");
                    });
                }
            }
        });
        
    });

</script>