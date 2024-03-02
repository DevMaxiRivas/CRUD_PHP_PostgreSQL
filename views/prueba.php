<?php
require __DIR__.'/../template/header.php';
// Procesamiento de Filtro

// Verificamos si se enviaron datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once __DIR__."/../routes/bootstrap.php";
    $conn = new DataBase();
    $limit = 100;

    $parameters = $_POST;

    // Leemos variables para saber en que BD y en que Tabla hacer la consulta 
    $table = htmlspecialchars(array_pop($parameters));
    $db = htmlspecialchars(array_pop($parameters));

    $sql = 
        "SELECT *
        FROM {$table}
        WHERE ";    

    $parameters2 = array();

    foreach ($parameters as $key => $value) {
        if($parameters[$key]) {
            array_push($parameters2, $key ." = :". $key);
        } else {
            unset($parameters[$key]);
        }
    }
    $sql .= implode(" AND ", $parameters2) . ";";

    if($parameters != []){
        // Obtenemos las columnas de la tabla verificando que no sean del tipo bytea ni oid

        $columns = $conn->exec_query_db(
            $db,
            "SELECT column_name 
            FROM information_schema.columns 
            WHERE 
                table_name = :table
                AND data_type NOT IN ('bytea','oid');",
            ['table' => $table]                     
        );
        
        // Otenemos 100 filas
        $query = "SELECT " . $columns[0]['column_name'];
        foreach ($columns as $col){
            $query = $query.", {$col['column_name']}";
        }


        // AQUI HAY QUE INSERTAR LAS CONDICIONES!!!!

        $query .= " FROM {$table} WHERE ". implode(" AND ", $parameters2) . " LIMIT {$limit};";
        echo "<br><br>".$query;
        
        $rows = $conn->exec_query_db($db,$query, $parameters);

        if ($columns && $rows) {
            // Creamos la tabla una vez consultemos a la BD obteniendo las columnas y las filas de la tabla
            echo "
            <div class='row' style=' height: 30em;width: 40em;overflow: auto;'>
                <table class='table table-sm table-bordered table-striped table-hover'>
                    <thead style='position: sticky; top: 0;'>";
                    
            // Creamos cabezal de la tabla, colocando como columnas todas las columnas de la tabla elegida
            echo "<tr>";
            foreach ($columns as $column) {
                echo "<th>{$column['column_name']}</th>";
            }
            echo "</tr>";
            
            // Cerramos la etiqueta thead
            echo '</thead>';

            // Cargamos el body de la tabla con las 100 primeras filas de la tabla seleccionada
            echo "<tbody id='tbody-rows'>";

            foreach ($rows as $row) {
                echo "<tr>";
                // Recorremos las columnas obteniendo asi el valor correspondiente para cada fila
                // Cada vez que vamos a recorrer las columnas debemos reiniciar el puntero mediante pg_result_seek

                foreach ($columns as $column) {
                    echo "<td>{$row[$column['column_name']]}</td>";
                }
                echo "</tr>";
            }
            // Una vez lleno el body, procedemos a cerrar las etiquetas
            echo '</tbody></table></div>';
        }
        else{
            // Si algunas de las consultas fallaron, se le notificara al usuario
            echo "
                <div class='alert alert-danger' style='heigth:5em;'>
                    <p>
                        No se pudo obtener las columnas y/o las filas de la Tabla
                    </p>
                </div>";
        }        
    } else {
        // Si la variable db o table no fue proporcionada tambien le notificara al usuario
        echo "
            <div class='alert alert-danger' style='heigth:5em;'>
                <p>
                    Falta de datos para realizar filtración
                </p>
            </div>";
    }
}

?>
