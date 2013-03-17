<?php
    //$uri = $this->uri->segment_array();
    
?>
<script>
    // Widget para los input donde se debe ingresar una hora (ej. 14:00)
    $.widget( "ui.timespinner", $.ui.spinner, {
        options: {
            // seconds
            step: 600 * 3000,
            // hours
            page: 60
        },
 
        _parse: function( value ) {
            if ( typeof value === "string" ) {
                // already a timestamp
                if ( Number( value ) == value ) {
                    return Number( value );
                }
                return +Globalize.parseDate( value );
            }
            return value;
        },
 
        _format: function( value ) {
            return Globalize.format( new Date(value), "t" );
        }
    });
    
    // Función para resaltar filas alternas en las tablas que tengan la clase "tabla-listado"
    function aplica_estilo_listado(){
        // Para resaltar un fila si y una no.
        // Solo para class="tabla-listado"
        var fila = 0;
        $('.tabla-listado tr').each(function(){
            if(fila % 2 == 0){
                $(this).addClass('fila-alterna');
            }
            fila++;
        });
    }
    
    //Función para borrar los campos de un formulario
    function clear_form(ele) {
        $(ele).find(':input').each(function() {
            switch(this.type) {
                case 'password':
                case 'text':
                case 'textarea':
                    $(this).val('');
                    break;
                case 'checkbox':
                case 'radio':
                    this.checked = false;
            }
        });
    }
    
    $(document).ready(function(){

        Globalize.culture( 'es-MX' );

        // Obtiene la fecha actual
        var d = new Date();
        var month = d.getMonth()+1;
        var day = d.getDate();
        var hour = d.getHours();
        var minutes = d.getMinutes();

        var fecha = d.getFullYear() + '-' +
            (month<10 ? '0' : '') + month + '-' +
            (day<10 ? '0' : '') + day;
        
        var hora = (hour<10 ? '0' : '') + hour + ':' +
            (minutes<10 ? '0' : '') + minutes;
        
        $('.fecha').datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true
        });
        // Los input con class="fecha" se utilizan con el widget datepicker
        $('.fecha').each(function(){
            if($(this).val() == "")
                $(this).datepicker("setDate", fecha); 
        });
        
        // Los input con la clase "hora" se utilizan para seleccionar la hora
        $('.hora').timespinner();
        $('.hora').val(hora);
        
        // Funciones de jQuery UI
        // Aplica el estilo a los botones y el calendario a los input de clase fecha.
        $('button,input[type="submit"],input[type="button"],#contenido a, .submenu div a[href!="#"]').button();

        // Función para validar los campos de los formularios
        // Solo valida los formularios que no tengan la clase "ajax" (ej. class="ajax")
        $('form:not(.ajax)').validate();
        
        // Se verifica si el menú debe estar visible o no
        $.ajax({
                url: "<?php echo base_url().'catalogo/ajax/session_obten_valor/menu_visible'; ?>",
                type: 'post',
                dataType: 'text'
            }).done(function(resultado){
                if(resultado == 1){
                    $('#menu-visible').attr('checked','checked');
                    $('#contenido,#top').css('margin-left','148px');
                }else{
                    $('#menu').css('margin-left','-150px');
                    $('#contenido,#top').css('margin-left','0px');
                    /*$('#menu').stop().animate({'marginLeft':'-140px'},200);
                    $('#contenido,#top').stop().animate({'marginLeft':'0px'},200);*/
                }
            }).fail(function(){
                alert("Error al cambiar el estado del menú!");
            });

        // Botón que muestra y oculta el menú
        $('#botonMenu').click(
            function () {
                if($('#menu').css('margin-left') == '-150px'){
                    $('#menu').show();
                    $('#menu').stop().animate({'marginLeft':'-2px'},200);
                    $('#contenido,#top').stop().animate({'marginLeft':'148px'},200);
                    //$('#top').stop().animate({'marginLeft':'98px'},200);
                }else{
                    $('#menu').stop().animate({'marginLeft':'-150px'},200);
                    $('#contenido,#top').stop().animate({'marginLeft':'0px'},200,function(){
                        $('#menu').hide();
                    });
                }

            }
        );
        
        /* Menu
            navigationFilter activa la opción del menú que corresponda a la URL en el navegador,
            la función php substr_count se utiliza para cortar la cadena hasta el método, eliminando
            los parametros en caso de que existan.
        */
        $('.menu,.submenu').accordion({head:'h3', collapsible: true, active: true, autoHeight: false, container: false, navigation: true, 
            navigationFilter: function(){
                return this.href.toLowerCase() == '<?php echo base_url(); echo substr_count(uri_string(),'/') > 2 ? substr(uri_string(),0, strrpos(uri_string(),'/')) : uri_string(); ?>';
            }
        });
        $('a[href="<?php echo base_url(); echo substr_count(uri_string(),'/') > 2 ? substr(uri_string(),0, strrpos(uri_string(),'/')) : uri_string(); ?>"]').css('font-weight','bold');
        
        $('.acordion').accordion({head:'h3', collapsible: true, active: false});
        
        // Checkbox para cambiar el estado del menú: visible/oculto
        $('#menu-visible').click(function(){
            var visible = 0;
            if($(this).attr('checked')){
                visible = 1;
            }
            $.ajax({
                url: "<?php echo base_url().'catalogo/ajax/session_registra_valor'; ?>",
                type: 'post',
                dataType: 'text',
                data: {'menu_visible': visible}
            }).fail(function(){
                alert("Error al cambiar el estado del menú!");
            });
        });
        
        aplica_estilo_listado();
    });
</script>
</body>
</html>