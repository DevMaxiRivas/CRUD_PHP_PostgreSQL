<?php
// Este bloque de código PHP se ejecutará en el servidor

require_once __DIR__."/routes/bootstrap.php";
$db = 'postgres';
$conn = new DataBase();
// Se verifica si la solicitud es de tipo POST y si existe
// un parámetro llamado "process" en la solicitud
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["process"])) {
    $process = $_POST["process"];

    // Creación de query para cerrar la conexión con id process
    $conn->exec_query_db($db,"SELECT pg_terminate_backend(:process);",['process' => $process]);
    // Termina la ejecución de PHP después de procesar la solicitud AJAX
    exit();
}
?>