<div id="contenido">
    <?php echo form_open('ingresos/pedidos/listado', array('id' => 'busqueda')); ?>
    <table class="tabla-filtros">
        <tr class="ui-widget-header">
            <td colspan="2" class="filtro-titulo">Filtros de búsqueda</td>
        </tr>
        <tr>
            <td class="filtro-nombre">Fecha:</td>
            <td class="filtro-dato"><input type="text" class="fecha" name="fecha" value="<?php echo isset($filtros['fecha']) ? $filtros['fecha'] : ''; ?>" /></td>
        </tr>
        <tr>
            <td class="filtro-nombre">Cliente:</td>
            <td class="filtro-dato"><input type="text" name="nombre" value="<?php echo isset($filtros['nombre']) ? $filtros['nombre'] : ''; ?>" /></td>
        </tr>
        <tr>
            <td class="filtro-nombre">Ocultar cancelados:</td>
            <td class="filtro-dato">
                <input type="checkbox" name="cancelado" id="cancelado" value="n" <?php echo isset($filtros['cancelado']) ? 'checked' : ''; ?>/>
            </td>
        </tr>
       
        <tr>
            <td colspan="2"><button type="submit">Buscar</button></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
    <div style="padding-bottom: 1em; text-align: center;"><?php echo $pagination; ?></div>
    <table class="tabla-listado" id="listado-pedidos">
        <tr class="ui-widget-header">
            <td style="width: 5%;">Folio</td>
            <td style="width: 58%;">Cliente</td>
            <td style="width: 10%;">Fecha</td>
            <td style="width: 10%">Fecha entrega</td>
            <td style="width: 7%">Ticket</td>
            <td style="width: 10%">&nbsp;</td>
        </tr>
        <?php
            foreach ($pedidos as $pedido){
        ?>
        <tr <?php if($pedido->cancelado == 's') echo 'class="ui-state-disabled"'; ?>>
            <td><?php echo $pedido->id_pedido; ?></td>
            <td><?php echo $pedido->nombre; ?></td>
            <td><?php echo $pedido->fecha; ?></td>
            <td><?php echo $pedido->FechaEntrega; ?></td>
            <td><?php echo $pedido->id_venta; ?></td>
            <td>
                <?php
                if(strlen($pedido->id_venta) == 0 && $pedido->cancelado == 'n'){
                ?>
                <a href="#" tipo="cancela" id_pedido="<?php echo $pedido->id_pedido; ?>">Cancelar</a>
                <?php
                }elseif ($pedido->cancelado == 's'){
                    echo "cancelado";
                }
                ?>
            </td>
        </tr>
        <?php
            }
        ?>
    </table>
    <div style="padding-top: 3em; text-align: center;"><?php echo $pagination; ?></div>
</div>
<script>
    $(document).ready(function(){
        $('a[tipo="cancela"]').click(function(){
            var confirmar;
            confirmar = confirm("Seguro que deseas cancelar el pedido "+$(this).attr('id_pedido')+"?");
            if(confirmar){
                loader = new ajaxLoader($('#contenido'));
                $.ajax({
                    url: "<?php echo base_url().'ingresos/pedidos/cancela'; ?>",
                    type: 'post',
                    data: {'id_pedido': $(this).attr('id_pedido')},
                    dataType: 'text'
                }).done(function(pedido){
                    if(Number(pedido) >= 1)
                        alert('Pedido cancelado con éxito!');
                    $('#busqueda').submit();
                }).fail(function(){
                    alert("Error al cancelar el pedido! URL: <?php echo current_url(); ?>");
                    loader.remove();
                });
            }
        });
    });
</script>