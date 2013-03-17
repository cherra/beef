<div id="contenido">
        <?php echo form_open('',array('class'=>'ajax','id'=>'form_busqueda')); ?>
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
                <td class="filtro-nombre">Folio o factura</td>
                <td class="filtro-dato">
                    <input type="text" name="folio_factura" id="folio_factura" />
                </td>
            </tr>
            <tr>
                <td class="filtro-nombre">Desde</td>
                <td class="filtro-dato">
                    <input type="text" class="fecha" name="desde" id="desde" value="<?php echo date('Y-m-d'); ?>" required="required"/>
                </td>
            </tr>
            <tr>
                <td class="filtro-nombre">Hasta</td>
                <td class="filtro-dato">
                    <input type="text" class="fecha" name="hasta" id="hasta" value="<?php echo date('Y-m-d'); ?>" required="required"/>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" name="mostrar" value="sinposfechados"/>
                    <input type="submit" id="buscar-cliente" value="Buscar" />
                </td>
            </tr>
        </table>
    <?php echo form_close(); ?>
    <div style="margin-left: auto; margin-right: 1px;">Haz click sobre los folios que se incluirán en el cheque.</div>
        <div class="ui-widget-content">
            <div style="height: 25em; overflow-y: auto; margin-bottom: 10px;">
                <table id="folios" class="tabla-listado tabla-seleccionable">

                </table>
            </div>
            <div>
                <table id="totales" style="width: 100%;">
                    
                </table>
            </div>
        </div>
    <div style="margin-left: auto; margin-right: 1px; margin-top: 10px;">Formulario para capturar los datos del cheque:</div>
        <div class="ui-widget-content" style="height: 22em; overflow-y: auto;">
            <?php echo form_open('',array('class'=>'ajax', 'id'=>'form_cheque')); ?>
            <input type="hidden" name="monto" id="monto" value="0"/>
            <table id="captura_cheque" class="tabla-captura" style="display: none;">
                <tr>
                    <td style="width: 15%;"><label>Total:</label></td>
                    <td style="width: 35%;"><label id="total_cheque" style="font-weight: bold;"></label></td>
                    <td style="width: 15%;"><label>Facturas:</label></td>
                    <td style="width: 35%;"><label id="facturas"></label></td>
                </tr>
                <tr>
                    <td style="width: 15%;"><label for="num_doc">No. de cheque:</label></td>
                    <td style="width: 35%;"><input type="text" name="num_doc" id="num_doc" required="required"/></td>
                    <td style="width: 15%;"><label for="id_concepto_pago">Concepto:</label></td>
                    <td style="width: 35%;">
                        <select name="id_concepto_pago" id="id_concepto_pago">
                            <?php
                                foreach ($conceptos as $concepto){
                                    ?>
                                    <option value="<?php echo $concepto->id_concepto_pago; ?>"><?php echo $concepto->concepto_pago; ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="hora">Hora:</label></td>
                    <td><input type="text" class="hora" name="hora" id="hora" required="required"/></td>
                    <td><label for="monto_deposito">Depósito:</label></td>
                    <td><input type="text" name="monto_deposito" id="monto_deposito" required="required"/></td>
                </tr>
                <tr>
                    <td><label for="fecha_pago">Fecha de pago:</label></td>
                    <td><input type="text" class="fecha" name="fecha_pago" id="fecha_pago" required="required"/></td>
                    <td><label for="fecha_deposito">Fecha de depósito:</label></td>
                    <td><input type="text" class="fecha" name="fecha_deposito" id="fecha_deposito"/></td>
                </tr>
                <tr>
                    <td><label for="id_usuario">Cobrador:</label></td>
                    <td>
                        <select name="id_usuario" id="id_usuario">
                            <?php
                                foreach ($usuarios as $usuario){
                                    ?>
                                    <option value="<?php echo $usuario->id_usuario; ?>"><?php echo $usuario->id_usuario." ".$usuario->nombre; ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </td>
                    <td><label for="observaciones">Observaciones:</label></td>
                    <td>
                        <textarea name="observaciones" id="observaciones" rows="2"></textarea>
                    </td>
                </tr>
                <tr>
                    
                </tr>
                <tr>
                    <td colspan="4">
                        <input type="submit" value="Guardar" id="guardar_cheque"/>
                    </td>
                </tr>
            </table>
            <?php echo form_close(); ?>
        </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        
        function get_folios(){
            //var fila=0;
            //var clase = '';
            var saldo = 0;
            var saldoTotal = 0;
            var total = 0;
            var abonado = 0;
            var dias_cobro = new Array();
            var loader;
            var datos = '';
            loader = new ajaxLoader($('#contenido'));
            
            $.ajax({
                url: "<?php echo base_url().'ingresos/cobranza/get_cuentas_pendientes'; ?>",
                type: 'post',
                data: $('#form_busqueda').serialize(),
                dataType: 'json'
            }).done(function(folios){
                //alert(clientes);
                $('#folios').html('<tr class="ui-widget-header">'+
                '<td style="width: 6%; text-align: center;">Núm.</td>'+
                '<td style="width: 38%; text-align: center;">Nombre</td>'+
                '<td style="width: 10%; text-align: center;">Fecha</td>'+
                '<td style="width: 8%; text-align: center;">Folio</td>'+
                '<td style="width: 8%; text-align: center;">Factura</td>'+
                '<td style="width: 10%; text-align: center;">Total</td>'+
                '<td style="width: 10%; text-align: center;">Abonado</td>'+
                '<td style="width: 10%; text-align: center;">Saldo</td>'+
                '</tr>');
                $.each(folios,function(key,val){
                    saldo = Number(val.TotalVenta) - Number(val.TotalAbonos);
                    saldoTotal += saldo;
                    abonado += Number(val.TotalAbonos);
                    total += Number(val.TotalVenta);
                    /*if(fila % 2 == 0)
                        clase = 'fila-alterna';
                    else
                        clase='';*/
                    datos += '<tr id_cliente="'+val.id_cliente+'" nombre="'+val.nombre+'" id_venta="'+val.id_venta+'" num_factura="'+val.num_factura+'" saldo="'+$.fn.numberFormat(saldo, 2, '.', '')+'" title="Ruta: '+val.descripcion+'">'+
                                            '<td align="center">'+val.id_cliente+'</td>'+
                                            '<td>'+val.nombre+'</td>'+
                                            '<td align="center">'+val.fecha+'</td>'+
                                            '<td align="center">'+val.id_venta+'</td>'+
                                            '<td align="center">'+val.num_factura+'</td>'+
                                            '<td align="right">'+$.fn.numberFormat(val.TotalVenta, 2)+'</td>'+
                                            '<td align="right">'+$.fn.numberFormat(val.TotalAbonos, 2)+'</td>'+
                                            '<td align="right">'+$.fn.numberFormat(saldo, 2)+'</td></tr>';
                    //fila++;
                });
                $('#folios').append(datos);
                $('#totales').html('<tr>'+
                                        '<td style="width: 70%; text-align: right;">Totales</td>'+
                                        '<td style="width: 10%; text-align: right;">'+$.fn.numberFormat(total, 2)+'</td>'+
                                        '<td style="width: 10%; text-align: right;">'+$.fn.numberFormat(abonado, 2)+'</td>'+
                                        '<td style="width: 10%; text-align: right;">'+$.fn.numberFormat(saldoTotal, 2)+'</td>'+
                                    '</tr>');
                aplica_estilo_listado();
                loader.remove();
                
            }).fail(function(){
                    alert("Error al buscar los clientes! URL: <?php echo current_url(); ?>");
            });
        }
        
        function calcula_totales(){
            // Calculo de totales
            var fila = 0;
            var total = 0;
            $('#facturas').html('');
            $('#folios tr').each(function(){
                if($(this).hasClass('fila-seleccionada')){
                    total += Number($(this).attr('saldo'));
                    $('#facturas').append($(this).attr('num_factura')+', ');
                }
            });
            $('#monto').val(total);
            $('#total_cheque').html($.fn.numberFormat(total,2));
            $('#monto_deposito').val($.fn.numberFormat(total,2,'.',''));
            $('#id_concepto_pago').change();
        }
        
        function registrar_cheque(){
            var cadena = "";
            var r = confirm('¿Deseas guardar el cheque?');
            if(r == true){
                
                loader = new ajaxLoader($('#contenido'));
                
                var folios = new Array(1);
                var i = new Number(0);

                // Se almacenan los folios seleccionados en un array para enviarlos por POST
                $("#folios tr").each(function(){
                    if($(this).hasClass("fila-seleccionada")){
                        folios[i] = $(this).attr("id_venta");
                        i++;
                    }
                });
                
                $.ajax({
                    url: "<?php echo base_url().'ingresos/cobranza/registrar_cheque'; ?>",
                    type: 'post',
                    data: $('#form_cheque').serialize()+'&'+$.param({folios: folios}),
                    dataType: 'text'
                }).done(function(cheque){
                    if(cheque >= 1){
                        alert("Cheque registrado!");
                    }
                    get_folios();
                    $('#captura_cheque').css('display','none');
                    loader.remove();
                }).fail(function(){
                    alert("Error al registrar el cheque! URL: <?php echo current_url(); ?>");
                    loader.remove();
                });
            }
        }
        
        $('#form_busqueda').validate({
            submitHandler: function(form){
                get_folios();
                //alert($('form.ajax').serialize());
            }
        });
        
        $('#folios').on('click','tr[class!="ui-widget-header"]',function(){
            //alert($(this).attr('id_articulo'));
            $('#id_cliente').val($(this).attr('id_cliente'));
            
            $('#captura_cheque').css('display','block');
            //$('#id_lista').val($(this).attr('id_lista'));
            //$('#id_lista').change();
            
            //$('#clientes tr[class!="ui-widget-header"]').css('font-weight','normal');
            /* Al seleccionar/desseleccionar una fila se suma o resta al total del cheque*/
            if($(this).hasClass('fila-seleccionada')){
                $(this).removeClass('fila-seleccionada');
            }else{
                $(this).addClass('fila-seleccionada');
            }
            calcula_totales();
            //$('#monto_deposito').val($(this).attr('saldo'));
            //$('#id_venta').val($(this).attr('id_venta'));
            //$('#id_concepto_pago').change();
            // Se listan los abonos (si los hay)
            //listar_abonos($(this).attr('id_venta'));
        });
        
        $('#form_cheque').validate({
            submitHandler: function(form){
                registrar_cheque();
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