// Cada vez que se cargue el DOM de la pagina se asigna un oyente al enlace para volver
// a la pagina que muestra las tablas, por eso se obtiene el nombre de la BD desde el id del link
document.addEventListener('DOMContentLoaded',
    function () {
        $('a').first().on('click',
            function() {
                db = $(this).attr('id').split('-')[1];
                name = $(this).attr('id').split('-')[2];
                $(this).attr('href','show_rows.php?db=' + db + '&name=' + name);
            }
        );
    }
);