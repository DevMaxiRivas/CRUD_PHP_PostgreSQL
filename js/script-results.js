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

function edit_row(process) {
    // Consulta de cierre de conexión
    var answer = confirm("¿Seguro que quiere editar la fila?");

    if (answer) {
        var xhr = new XMLHttpRequest();
        // Se utiliza XMLHttpRequest para enviar datos a la URL del servidor: close_connection.php
        xhr.open("POST", "../close_connection.php", true);
        
        // Indicamos al servidor que los datos enviados en el cuerpo de la solicitud
        // se codifican en un formato de URL codificado        
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        
        // Función que se ejecutará cada vez que cambie el estado de la solicitud. Se verifica si la 
        // solicitud está completa (readyState == 4) y si la respuesta del servidor
        // es exitosa (status == 200).
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                location.reload();
            }
        };
        // Envio al servidor la información de la variable process sobre el identificador "process". 
        xhr.send("process=" + process);
    } else {
        alert("Operación cancelada.");
    }

}

function delete_row2(data) {
    // Consulta de cierre de conexión
    var answer = confirm("¿Seguro que quiere eliminar la fila?");

    if (answer) {
        var xhr = new XMLHttpRequest();
        // Se utiliza XMLHttpRequest para enviar datos a la URL del servidor: close_connection.php
        xhr.open("POST", "../delete_row.php", true);
        
        // Indicamos al servidor que los datos enviados en el cuerpo de la solicitud
        // se codifican en un formato de URL codificado        
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        
        // Función que se ejecutará cada vez que cambie el estado de la solicitud. Se verifica si la 
        // solicitud está completa (readyState == 4) y si la respuesta del servidor
        // es exitosa (status == 200).
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                location.reload();
                // window.location.href = "../delete_row.php";
            }
        };
        // Envio al servidor la información de la variable process sobre el identificador "process". 
        xhr.send("parameters=" + data);
    } else {
        alert("Operación cancelada.");
    }

}
function delete_row(data) {
    // Consulta de cierre de conexión
    var answer = confirm("¿Seguro que quiere eliminar la fila?");

    if (answer) {
                
        // Configurar la URL de destino
        var url = "../delete_row.php";

        // Configurar la solicitud fetch POST
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(function(response) {
            // Redirigir a la página de destino
            // window.location.href = url;
            // location.reload();
            console.log("Funciono");
        })
        .catch(function(error) {
            console.error('Error al enviar datos:', error);
        });
    } else {
        alert("Operación cancelada.");
    }

}

