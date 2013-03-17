<div id="contenido">
        <?php echo form_open('',array('class'=>'ajax','id'=>'form_busqueda')); ?>
        <table class="tabla-filtros">
            <tr class="ui-widget-header">
                <td colspan="2" class="filtro-titulo">Filtros de busqueda de cheques posfechados</td>
            </tr>
            <tr>
                <td class="filtro-nombre">Cliente</td>
                <td class="filtro-dato">
                    <input type="text" name="nombre" id="nombre" />
                </td>
            </tr>
            <tr>
                <td class="filtro-nombre">Folio o factura</td>
                <td class="filtro-dato">
                    <input type="text" name="folio_factura" id="folio_factura" />
                </td>
            </tr>
            <tr>
                <td class="filtro-nombre">Mostrar:</td>
                <td class="filtro-dato">
                    <select name="mostrar" id="mostrar">
                        <option value="sin_depositar">Sin depositar</option>
                        <option value="depositados">Depositados</option>
                        <option value="todos">Todos</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" id="buscar-cliente" value="Buscar" /></td>
            </tr>
        </table>
    <?php echo form_close(); ?>
    <div style="margin-left: auto; margin-right: 1px;">Haz click sobre algún cheque para ver el detalle.</div>
        <div class="ui-widget-content">
            <div style="height: 25em; overflow-y: auto; margin-bottom: 10px;">
                <table id="cheques" class="tabla-listado tabla-seleccionable">

                </table>
            </div>
            <div>
                <table id="totales" style="width: 100%;">
                    
                </table>
            </div>
        </div>

    <div class="ui-widget-content" style="margin-top: 10px; height: 5em;" >
        <?php echo form_open('',array('class'=>'ajax', 'id'=>'form_depositar')); ?>
            <table id="depositar_cheque" class="tabla-captura" style="display: none;">
                <tr>
                    <td><label for="fecha_deposito">Fecha de depósito:</label></td>
                    <td><input type="text" class="fecha" name="fecha_deposito" id="fecha_deposito" /></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" id="btndepositar" value="Depositar"/></td>
                </tr>
            </table>
            <input type="hidden" name="id_cheque_posfechado" id="id_cheque_posfechado"/>
        <?php echo form_close(); ?>
    </div>
    <div style="margin-left: auto; margin-right: 1px; margin-top: 10px;">Detalle del cheque:</div>
    <div id="detalle" class="ui-widget-content" style="height: 15em; overflow-y: auto; display: none;">
        <div style="margin-left: auto; margin-right: 1px;">Listado de folios cubiertos por el cheque.</div>
        <table id="listado_folios" class="tabla-listado">
            
        </table>
    </div>
    
</div>
<script type="text/javascript">
    $(document).ready(function(){
        
        function get_cheques(){
            //var fila=0;
            //var clase = '';
            var total = 0;
            var loader;
            var datos = '';
            loader = new ajaxLoader($('#contenido'));
            
            $.ajax({
                url: "<?php echo base_url().'ingresos/cobranza/get_cheques_posfechados'; ?>",
                type: 'post',
                data: $('#form_busqueda').serialize(),
                dataType: 'json'
            }).done(function(cheques){
                //alert(clientes);
                $('#cheques').html('<tr class="ui-widget-header">'+
                '<td style="width: 10%; text-align: center;">Fecha depósito</td>'+
                '<td style="width: 50%; text-align: center;">Cliente</td>'+
                '<td style="width: 10%; text-align: center;">Fecha de pago</td>'+
                '<td style="width: 10%; text-align: center;">Núm.</td>'+
                '<td style="width: 10%; text-align: center;">Importe</td>'+
                '<td style="width: 10%; text-align: center;">Depósitado</td>'+
                '</tr>');
                $.each(cheques,function(key,val){
                    total += Number(val.monto);
                    datos += '<tr id_cheque_posfechado="'+val.id_cheque_posfechado+'" fecha_deposito="'+val.fecha_deposito+'" nombre="'+val.nombre+'" id_venta="'+val.id_venta+'" monto="'+$.fn.numberFormat(val.monto, 2, '.', '')+'">'+
                                            '<td align="center">'+val.fecha_deposito+'</td>'+
                                            '<td>'+val.nombre+'</td>'+
                                            '<td align="center">'+val.fecha_pago+'</td>'+
                                            '<td align="center">'+val.num_doc+'</td>'+
                                            '<td align="right">'+$.fn.numberFormat(val.monto, 2)+'</td>'+
                                            '<td align="center">'+val.depositado+'</td></tr>';
                });
                $('#cheques').append(datos);
                $('#totales').html('<tr>'+
                                        '<td style="width: 80%; text-align: right;">Total:</td>'+
                                        '<td style="width: 10%; text-align: right;">'+$.fn.numberFormat(total, 2)+'</td>'+
                                        '<td style="width: 10%;">&nbsp;</td>'+
                                    '</tr>');
                aplica_estilo_listado();
                loader.remove();
                
            }).fail(function(){
                    alert("Error al buscar los cheques! URL: <?php echo current_url(); ?>");
            });
        }
        
        function detalle( id_cheque_posfechado ){
            var datos = '';
        
            $.ajax({
                url: "<?php echo base_url().'ingresos/cobranza/get_folios_cheque'; ?>",
                type: 'post',
                data: {'id_cheque_posfechado': id_cheque_posfechado},
                dataType: 'json'
            }).done(function(folios){
                $('#listado_folios').html('<tr class="ui-widget-header">'+
                    '<td style="width: 10%; text-align: center;">Ticket</td>'+
                    '<td style="width: 10%; text-align: center;">Factura</td>'+
                    '<td style="width: 15%; text-align: center;">Fecha</td>'+
                    '<td style="width: 55%; text-align: center;">Cliente</td>'+
                    '<td style="width: 10%; text-align: center;">Importe</td>'+
                '</tr>');
                $.each(folios,function(key,val){
                    datos += '<tr>'+
                                '<td align="center">'+val.id_venta+'</td>'+
                                '<td align="center">'+val.factura+'</td>'+
                                '<td align="center">'+val.fecha+'</td>'+
                                '<td>'+val.nombre+'</td>'+
                                '<td align="right">'+val.monto+'</td>'+
                            '</tr>';
                });
                $('#listado_folios').append(datos);
                $('#detalle').css('display','block');
                aplica_estilo_listado();
                
            }).fail(function(){
                    alert("Error al listar los abonos! URL: <?php echo current_url(); ?>");
            });
        }
        
        function depositar(){
            loader = new ajaxLoader($('#contenido'));

            $.ajax({
                url: "<?php echo base_url().'ingresos/cobranza/depositar_cheque'; ?>",
                type: 'post',
                data: $('#form_depositar').serialize(),
                dataType: 'text'
            }).done(function(respuesta){
                //alert(respuesta);
                if(Number(respuesta) >= 1)
                    alert('Cheque marcado como depositado.');
                get_cheques();
                //$('#clientes tr[id_venta="'+$('#id_venta').val()+'"]').click();
                $('#depositar_cheque').css('display','none');
                //$('#abonos').css('display','none');
                clear_form('#form_depositar');
                loader.remove();
            }).fail(function(){
                alert("Error al registrar el cheque depositado! URL: <?php echo current_url(); ?>");
                loader.remove();
            });
        }
        
        $('#form_busqueda').validate({
            submitHandler: function(form){
                get_cheques();
                //alert($('form.ajax').serialize());
            }
        });
        
        $('#cheques').on('click','tr[class!="ui-widget-header"]',function(){
            //alert($(this).attr('id_articulo'));
            $('#id_cheque_posfechado').val($(this).attr('id_cheque_posfechado'));
            
            //$('#cheques tr[class!="ui-widget-header"]').css('font-weight','normal');
            $('#cheques tr[class!="ui-widget-header"]').removeClass('fila-seleccionada');
            $(this).addClass('fila-seleccionada');
            
            // Se listan los folios
            detalle($(this).attr('id_cheque_posfechado'));
            $('#depositar_cheque').css('display','block');
        });
        
        $('#form_depositar').validate({
            submitHandler: function(form){
                if(confirm('¿Deseas marcar marcar el cheque como depositado?')){
                    depositar();
                    $('#depositar_cheque').css('display','none');
                }
            }
        });
        
        $('#id_concepto_pago').change(function(){
            $.ajax({
                url: "<?php echo base_url().'catalogo/conceptos_pago/get_concepto_pago'; ?>",
                type: 'post',
                data: {'id_concepto_pago': $(this).val()},
                dataType: 'json'
            }).done(function(concepto_pago){
                $('#observaciones').val(concepto_pago.observaciones+' $'+$('#monto_deposito').val());
            }).fail(function(){
                alert("Error al obtener las observaciones del tipo de pago! URL: <?php echo current_url(); ?>");
            });
        });
        
        $('#monto_deposito').keyup(function(){
            $('#id_concepto_pago').change();
        });
        
        $('#id_concepto_pago').change();
    });

</script>