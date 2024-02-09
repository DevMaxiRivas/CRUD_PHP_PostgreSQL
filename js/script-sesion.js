function end_process(process) {
    // Consulta de cierre de conexión
    var answer = confirm("¿Seguro que quiere cerrar la conexión " + process + " ?");

    if (answer) {
        var xhr = new XMLHttpRequest();
        // Se utiliza XMLHttpRequest para enviar datos a la URL del servidor: close_connection.php
        xhr.open("POST", "close_connection.php", true);
        
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
