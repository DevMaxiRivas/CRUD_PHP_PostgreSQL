/* Cada vez que se cargue el DOM se asignan 3 oyentes:
    1- Al combobox de BD para que se modifique un label cada vez que elijo una opción
    2- Al link "ver Tablas" para redireccionar al archivo show_tables con el nombre de la BD en la url
    3- Al link "ver Sesiones" para redireccionar al archivo show_sesions con el nombre de la BD en la url
*/
document.addEventListener('DOMContentLoaded', 
    function () {
        $('#label-bd-1').html('Seleccione una BD');
        
        $('#selected-db').on('change',
        function () {
            if ($(this).val() != '') {
                $('#label-bd-1').html('Base de datos elegida: <strong>' + $(this).val() + '</strong>');
            }
            else {
                $('#label-bd-1').html('Seleccione una BD');
            }
        }
        );
        
        $('#link-tables').on('click', 
        function ( e ) {
            let valor_seleccionado = $('#selected-db').val();
            if (valor_seleccionado != '') {
                $(this).attr('href', 'show_tables.php?db='+valor_seleccionado);
            }
            else {
                $(this).attr('href', '#');
            }
        }
        )

        $('#link-sessions').on('click', 
        function ( e ) {
            let valor_seleccionado = $('#selected-db').val();
            if (valor_seleccionado != '') {
                $(this).attr('href', 'show_sesions.php?db='+valor_seleccionado);
            }
            else {
                $(this).attr('href', '#');
            }
        }
    )

    }
);