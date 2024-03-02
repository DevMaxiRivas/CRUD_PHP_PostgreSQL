<?php
                    require __DIR__.'/../template/header.php';
                    if(isset($_POST['db']) && isset($_POST['table'])){
                        echo "<h5 class='card-title'>Tabla ".$_POST['table']." filtrada: </h5>";
                    }
                    else{
                        echo "<h5 class='card-title'>No se pueden mostrar las filas</h5>";
                    }

                    // Importamos los archivos necesarios para realizar una conexíon
                    require_once __DIR__."/../routes/bootstrap.php";
                    $conn = new DataBase();
                    // Limitamos el nro de filas a 100
                    $limit = 100;

                    // Copiamos los parametros pasados a traves del metodo POST
                    $parameters = $_POST;

                     // Leemos variables para saber en que BD y en que Tabla hacer la consulta 
                    $table = htmlspecialchars(array_pop($parameters));
                    $db = htmlspecialchars(array_pop($parameters));

                    $parameters2 = array();

                    foreach ($parameters as $key => $value) {
                        if($parameters[$key]) {
                            array_push($parameters2, $key ." = :". $key);
                        } else {
                            unset($parameters[$key]);
                        }
                    }


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
                        $query .= " FROM {$table} WHERE ". implode(" AND ", $parameters2) . " LIMIT {$limit};";
                        $rows = $conn->exec_query_db($db,$query,$parameters);

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
                    }
                    else{
                        // Si la variable db o table no fue proporcionada tambien le notificara al usuario
                        echo "
                            <div class='alert alert-danger' style='heigth:5em;'>
                                <p>
                                    Falta de datos para realizar filtración
                                </p>
                            </div>";
                    }

                ?>
                <div class="row mb-3 d-flex justify-content-center">
                    <?php
                        if(isset($_POST['db']) && isset($_POST['table'])){

                            echo 
                            '   <div class="row mb-3 d-flex justify-content-center">
                                    <a id="btnvolver-'.htmlspecialchars($_POST['db'])."-".htmlspecialchars($_POST['table']).'" href="#" class="btn btn-primary col-6 col-sm-5 m-2">Volver</a>
                                    <a href="../index.php" class="btn btn-primary col-6 col-sm-5 m-2">Inicio</a>
                                </div>';
                        }
                        else{
                            echo "<a href='../index.php' class='btn btn-primary col-12 col-sm-5 m-1'>Inicio</a>";
                        }   
                    ?>
                    
                </div>
            </div>
        </div>
    <script src="./../js/script-results.js"></script>
<?php
    require __DIR__.'/../template/footer.php'
?>