<?php
// Este bloque de código PHP se ejecutará en el servidor

require_once __DIR__."/routes/bootstrap.php";
// Se verifica si la solicitud es de tipo POST y si existe
// un parámetro llamado "process" en la solicitud
$conn = new DataBase();

$parameters = json_decode(file_get_contents('php://input'), true);
$archivo = fopen("texto.txt", "w") or die("No se puede abrir el archivo");

if (!empty($parameters)) {    
    
    $table = array_pop($parameters);
    $db = array_pop($parameters);

    // Generamos los parametros para eliminar la fila
    $columns = array();

    foreach ($parameters as $key => $value) {
        if($parameters[$key]) {
            array_push($columns, $key ." = :". $key);
        } else {
            unset($parameters[$key]);
        }
    }

    $texto = "";
    foreach ($parameters as $key => $value) {
        if($parameters[$key]) {
            $texto .= $key . ': ' . $parameters[$key] . " - ";
        } 
    }
    fwrite($archivo, $texto);

    try {
        $conn->exec_query_db(
            $db,
            'DELETE FROM '. $table .'
            WHERE ' . implode(" AND ", $columns) . ";"
            ,$parameters);
        fwrite($archivo, "Termino");
    } catch (Exception $e) {
        fwrite($archivo, 'Se ha producido una excepción: ' . $e->getMessage());
    }
    
    // Termina la ejecución de PHP después de procesar la solicitud AJAX
    exit();
} else {
    $texto = "Vacio";
    fwrite($archivo, $texto);
}
fclose($archivo);

?>