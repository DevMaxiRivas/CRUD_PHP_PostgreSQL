<?php
// Este bloque de código PHP se ejecutará en el servidor

require_once __DIR__."/routes/bootstrap.php";
// Se verifica si la solicitud es de tipo POST y si existe
// un parámetro llamado "process" en la solicitud
echo"Termin";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["parameters"])) {
    $conn = new DataBase();
    
    $parameters = json_decode($_POST["parameters"], true);

    $db = array_pop($parameters);
    $table = array_pop($parameters);

    // Generamos los parametros para eliminar la fila
    $columns = array();

    foreach ($parameters as $key => $value) {
        if($parameters[$key]) {
            array_push($columns, $key ." = :". $key);
        } else {
            unset($parameters[$key]);
        }
    }
    echo 'DELETE FROM $table 
    WHERE ' . implode(" AND ", $columns) . ";";

    // Eliminacion de Fila en la tabla
    $conn->exec_query_db(
        $db,
        'DELETE FROM $table 
        WHERE ' . implode(" AND ", $columns) . ";"
        ,$parameters);
    // Termina la ejecución de PHP después de procesar la solicitud AJAX
    echo"Termin";
    exit();
}
?>