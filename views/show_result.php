<?php
// procesar_formulario.php

// Verificar si se enviaron datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formulario
    $nombre = $_POST["categoryid"];
    $email = $_POST["categoryname"];
    
    // Hacer algo con los datos, como guardarlos en la base de datos, enviar un correo electrónico, etc.
    
    // Por ejemplo, imprimir los datos recibidos
    echo "Nombre: <br>";
    echo "Email: ";
}
?>
