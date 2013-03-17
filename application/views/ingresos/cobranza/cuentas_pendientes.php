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
                <td class="filtro-nombre">Ruta</td>
                <td class="filtro-dato">
                    <select name="id_ruta" id="id_ruta">
                        <option value="0">Cualquiera</option>
                        <?php
                        foreach($rutas as $ruta){
                        ?>
                            <option value="<?php echo $ruta->id_ruta_cobranza; ?>"><?php echo $ruta->descripcion; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="filtro-nombre">Días de cobro</td>
                <td class="filtro-dato">
                    <input type="checkbox" name="dias_cobro[]" id="lun" value="lun" />L<input type="checkbox" name="dias_cobro[]" id="mar" value="mar"/>M<input type="checkbox" name="dias_cobro[]" id="mie" value="mie"/>Mi<input type="checkbox" name="dias_cobro[]" id="jue" value="jue"/>J<input type="checkbox" name="dias_cobro[]" id="vie" value="vie"/>V<input type="checkbox" name="dias_cobro[]" id="sab" value="sab"/>S<input type="checkbox" name="dias_cobro[]" id="dom" value="dom"/>D
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
                <td class="filtro-nombre">Mostrar:</td>
                <td class="filtro-dato">
                    <select name="mostrar" id="mostrar">
                        <option value="no pagadas">No pagadas</option>
                        <option value="pagadas">Pagadas</option>
                        <option value="posfechados">Pos fechadas</option>
                        <option value="abonos">Solo abonos</option>
                        <option value="todas">Todas</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" id="buscar-cliente" value="Buscar" /></td>
            </tr>
        </table>
    <?php echo form_close(); ?>
    <div style="margin-left: auto; margin-right: 1px;">Haz click sobre algún folio para agregar un abono y/o ver abonos realizados.</div>
        <div class="ui-widget-content">
            <div style="height: 25em; overflow-y: auto; margin-bottom: 10px;">
                <table id="clientes" class="tabla-listado tabla-seleccionable">

                </table>
            </div>
            <div>
                <table id="totales" style="width: 100%;">
                    
                </table>
            </div>
            <input type="hidden" id="id_cliente" />
        </div>
    <div style="margin-left: auto; margin-right: 1px; margin-top: 10px;">Formulario para capturar abonos:</div>
        <div class="ui-widget-content" style="height: 19em; overflow-y: auto;">
            <?php echo form_open('',array('class'=>'ajax', 'id'=>'form_abono')); ?>
            <table id="captura_abono" class="tabla-captura" style="display: none;">
                <input type="hidden" name="id_venta" id="id_venta"/>
                <tr>
                    <td style="width: 15%;"><label for="abono">Abono:</label></td>
                    <td style="width: 35%;"><input type="text" name="abono" id="abono" required="required"/></td>
                    <td style="width: 15%;"><label for="concepto">Concepto:</label></td>
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
                    <td><label for="num_doc">Núm. de documento:</label></td>
                    <td><input type="text" name="num_doc" id="num_doc"/></td>
                </tr>
                <tr>
                    <td><label for="abono">Cobrador:</label></td>
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
                    <td><label for="fecha_deposito">Fecha de depósito:</label></td>
                    <td><input type="text" class="fecha" name="fecha_deposito" id="fecha_deposito" required="required"/></td>
                </tr>
                <tr>
                    <td colspan="2"><label for="observaciones">Observaciones:</label></td>
                    <td colspan="2">
                        <textarea name="observaciones" id="observaciones" rows="2"></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <input type="submit" value="Guardar" id="guardar_abono"/>
                    </td>
                </tr>
            </table>
            <?php echo form_close(); ?>
        </div>
    
    <div id="abonos" class="ui-widget-content" style="margin-top: 10px; height: 8em; overflow-y: auto; display: none;">
        <div style="margin-left: auto; margin-right: 1px;">Listado de abonos realizados.</div>
        <table id="listado_abonos" class="tabla-listado">
            
        </table>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        
        function get_clientes(){
            //var fila=0;
            //var clase = '';
            var saldo = 0;
            var saldoTotal = 0;
            var total = 0;
            var abonado = 0;
            var dias_cobro = new Array();
            var loader;
            var datos = '';
            var cheque = '';
            loader = new ajaxLoader($('#contenido'));
            
            $('input[name="dias_cobro[]"]:checked').each(function(){
                dias_cobro.push($(this).val());
                
            });
            
            $.ajax({
                url: "<?php echo base_url().'ingresos/cobranza/get_cuentas_pendientes'; ?>",
                type: 'post',
                data: $('#form_busqueda').serialize(),
                dataType: 'json'
            }).done(function(clientes){
                //alert(clientes);
                $('#clientes').html('<tr class="ui-widget-header">'+
                '<td style="width: 6%; text-align: center;">Núm.</td>'+
                '<td style="width: 38%; text-align: center;">Nombre</td>'+
                '<td style="width: 10%; text-align: center;">Fecha</td>'+
                '<td style="width: 8%; text-align: center;">Folio</td>'+
                '<td style="width: 8%; text-align: center;">Factura</td>'+
                '<td style="width: 8%; text-align: center;">Total</td>'+
                '<td style="width: 8%; text-align: center;">Abonos</td>'+
                '<td style="width: 8%; text-align: center;">Saldo</td>'+
                '<td style="width: 6%; text-align: center;">Cheq</td>'+
                '</tr>');
                $.each(clientes,function(key,val){
                    saldo = Number(val.TotalVenta) - Number(val.TotalAbonos);
                    saldoTotal += saldo;
                    abonado += Number(val.TotalAbonos);
                    total += Number(val.TotalVenta);
                    if(Number(val.id_cheque_posfechado) > 0){
                        cheque = 'Si';
                    }else{
                        cheque = '';
                    }
                    datos += '<tr id_cliente="'+val.id_cliente+'" nombre="'+val.nombre+'" id_venta="'+val.id_venta+'" saldo="'+$.fn.numberFormat(saldo, 2, '.', '')+'" id_cheque_posfechado="'+val.id_cheque_posfechado+'" title="Ruta: '+val.descripcion+'">'+
                                            '<td align="center">'+val.id_cliente+'</td>'+
                                            '<td>'+val.nombre+'</td>'+
                                            '<td align="center">'+val.fecha+'</td>'+
                                            '<td align="center">'+val.id_venta+'</td>'+
                                            '<td align="center">'+val.num_factura+'</td>'+
                                            '<td align="right">'+$.fn.numberFormat(val.TotalVenta, 2)+'</td>'+
                                            '<td align="right">'+$.fn.numberFormat(val.TotalAbonos, 2)+'</td>'+
                                            '<td align="right">'+$.fn.numberFormat(saldo, 2)+'</td>'+
                                            '<td align="right">'+cheque+'</td></tr>';
                });
                $('#clientes').append(datos);
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
        
        function listar_abonos( id_venta ){
            var datos = '';
        
            $.ajax({
                url: "<?php echo base_url().'ingresos/cobranza/listar_abonos'; ?>",
                type: 'post',
                data: {'id_venta': id_venta},
                dataType: 'json'
            }).done(function(abonos){
                $('#listado_abonos').html('<tr class="ui-widget-header">'+
                    '<td style="width: 15%; text-align: center;">Fecha depósito</td>'+
                    '<td style="width: 15%; text-align: center;">Fecha pago</td>'+
                    '<td style="width: 30%; text-align: center;">Cobrador</td>'+
                    '<td style="width: 10%; text-align: center;">Importe</td>'+
                    '<td style="width: 10%; text-align: center;">Doc.</td>'+
                    '<td style="width: 10%; text-align: center;">Dep.</td>'+
                    '<td style="width: 10%; text-align: center;"></td>'+
                '</tr>');
                $.each(abonos,function(key,val){
                    datos += '<tr>'+
                                '<td align="center">'+val.fecha_deposito+'</td>'+
                                '<td align="center">'+val.fecha_pago+'</td>'+
                                '<td>'+val.cobrador+'</td>'+
                                '<td align="right">'+val.abono+'</td>'+
                                '<td align="center">'+val.num_doc+'</td>'+
                                '<td align="center">'+val.depositado+'</td>'+
                            '</tr>';
                });
                $('#listado_abonos').append(datos);
                $('#abonos').css('display','block');
                aplica_estilo_listado();
                
            }).fail(function(){
                    alert("Error al listar los abonos! URL: <?php echo current_url(); ?>");
            });
        }
        
        function agregar_abono(){
            loader = new ajaxLoader($('#contenido'));

            $.ajax({
                url: "<?php echo base_url().'ingresos/cobranza/registrar_abono'; ?>",
                type: 'post',
                data: $('#form_abono').serialize(),
                dataType: 'text'
            }).done(function(abono){
                if(Number(abono) >= 1)
                    alert('Abono registrado');
                get_clientes();
                //$('#clientes tr[id_venta="'+$('#id_venta').val()+'"]').click();
                $('#captura_abono').css('display','none');
                $('#abonos').css('display','none');
                clear_form('#form_abono');
            }).fail(function(){
                alert("Error al registrar el abono! URL: <?php echo current_url(); ?>");
                loader.remove();
            });
        }
        
        $('#form_busqueda').validate({
            submitHandler: function(form){
                get_clientes();
                //alert($('form.ajax').serialize());
            }
        });
        
        $('#clientes').on('click','tr[class!="ui-widget-header"]',function(){
            //alert($(this).attr('id_articulo'));
            $('#id_cliente').val($(this).attr('id_cliente'));
            
            $('#clientes tr[class!="ui-widget-header"]').removeClass('fila-seleccionada');
            $(this).addClass('fila-seleccionada');
            
            if($(this).attr('id_cheque_posfechado') == "null"){
                $('#captura_abono').css('display','block');
                //$('#id_lista').val($(this).attr('id_lista'));
                //$('#id_lista').change();

                $('#abono').val($(this).attr('saldo'));
                $('#monto_deposito').val($(this).attr('saldo'));
                $('#id_venta').val($(this).attr('id_venta'));
                $('#id_concepto_pago').change();
                // Se listan los abonos (si los hay)
                listar_abonos($(this).attr('id_venta'));
            }else{
                $('#captura_abono').css('display','none');
            }
        });
        
        $('#form_abono').validate({
            submitHandler: function(form){
                agregar_abono();
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
        
        $('#abono').keyup(function(){ // Valido que el importe capturado no sea mayor que el adeudo
            if(Number($(this).val()) > Number($('#clientes tr[id_venta="'+$('#id_venta').val()+'"]').attr('saldo'))){
                $(this).val($('#clientes tr[id_venta="'+$('#id_venta').val()+'"]').attr('saldo'));
            }
        });
        
        $('#id_concepto_pago').change();
    });

</script>