<div id="contenido">
    <?php echo form_open('catalogo/clientes/listado'); ?>
    <table class="tabla-filtros">
        <tr class="ui-widget-header">
            <td colspan="2" class="filtro-titulo">Filtros de búsqueda</td>
        </tr>
        <tr>
            <td class="filtro-nombre">Nombre:</td>
            <td class="filtro-dato"><input type="text" name="nombre" value="<?php echo isset($filtros['nombre']) ? $filtros['nombre'] : ''; ?>" /></td>
        </tr>
        <tr>
            <td class="filtro-nombre">Tipo de pago:</td>
            <td class="filtro-dato">
                <select name="tipo_pago">
                    <option value="">Cualquiera</option>
                    <option value="contado" <?php if(isset($filtros['tipo_pago'])){ echo $filtros['tipo_pago'] == 'contado' ? 'selected': ''; } ?>>Contado</option>
                    <option value="credito" <?php if(isset($filtros['tipo_pago'])){ echo $filtros['tipo_pago'] == 'credito' ? 'selected': ''; } ?>>Crédito</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><button type="submit">Buscar</button></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
    <div style="padding-bottom: 1em; text-align: center;"><?php echo $pagination; ?></div>
    <table class="tabla-listado" id="listado-clientes">
        <tr class="ui-widget-header">
            <td style="width: 5%;">Número</td>
            <td style="width: 65%;">Nombre</td>
            <td style="width: 10%;">Tipo de pago</td>
            <td style="width: 10%">&nbsp;</td>
            <td style="width: 10%">&nbsp;</td>
        </tr>
        <?php
            foreach ($clientes as $cliente){
        ?>
        <tr title="<?php echo $cliente->domicilio.' '.$cliente->colonia; ?>. Tels:<?php echo $cliente->telefono.', '.$cliente->telefono2; ?>">
            <td><?php echo $cliente->id_cliente; ?></td>
            <td><?php echo $cliente->nombre; ?></td>
            <td><?php echo $cliente->tipo_pago; ?></td>
            <td>
                <?php echo anchor('catalogo/clientes/modifica/'.$cliente->id_cliente, 'Modificar'); ?>
            </td>
            <td>
                <?php echo anchor('catalogo/clientes/credito/'.$cliente->id_cliente, 'Crédito'); ?>
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
        $('#listado-clientes').on('click','tr[class!="ui-widget-header"]',function(){
            $(this).css('font-weight','bold');
        });
        
        $('#listado-clientes').on('mouseleave','tr[class!="ui-widget-header"]',function(){
            $(this).css('font-weight','normal');
        });
    });

</script>
