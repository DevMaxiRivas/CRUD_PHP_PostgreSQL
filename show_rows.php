<?php
                    require __DIR__.'/template/header.php';
                    if(isset($_GET['db']) && isset($_GET['name'])){
                        echo "<h5 class='card-title'>Primeras 100 filas de ".$_GET['name']."</h5>";
                    }
                    else{
                        echo "<h5 class='card-title'>No se pueden mostrar las filas</h5>";
                    }

                    // Importamos los archivos necesarios para realizar una conexíon
                    require_once __DIR__."/inc/bootstrap.php";
                    $conn = new DataBase();
                    
                    // Limitamos el nro de filas a 100
                    $limit = 100;
                    if(isset($_GET['db']) && isset($_GET['name'])){
                        // Leemos variables pasadas por url para saber en que BD y en que Tabla hacer la consulta 
                        $db = htmlspecialchars($_GET['db']);
                        $table = htmlspecialchars($_GET['name']);

                        // Obtenemos las columnas de la tabla verificando que no sean del tipo bytea ni oid
                        $query = "select column_name 
                                  from information_schema.columns 
                                  where 
                                    table_name = '{$table}'
                                    and data_type not in ('bytea','oid');";
                        $result1 = $conn->exec_query_db($query, $db);

                        // Otenemos 100 filas
                        $cols = $conn->exec_query_db($query, $db);
                        $query = "select ".pg_fetch_assoc($cols)['column_name'];
                        while (($col = pg_fetch_assoc($cols))){
                            $query = $query.", {$col['column_name']}";
                        }
                        $query = $query." from {$table} limit {$limit};";
                        $result2 = $conn->exec_query_db($query, $db);
                            
                        if ($result1 && $result2) {
                            // Creamos la tabla una vez consultemos a la BD obteniendo las columnas y las filas de la tabla
                            echo "
                            <div class='row' style=' height: 30em;width: 40em;overflow: auto;'>
                                <table class='table table-sm table-bordered table-striped table-hover'>
                                    <thead style='position: sticky; top: 0;'>";
                                    
                            // Creamos cabezal de la tabla, colocando como columnas todas las columnas de la tabla elegida
                            echo "<tr>";
                            while ($column = pg_fetch_assoc($result1)) {
                                echo "<th>{$column['column_name']}</th>";
                            }
                            echo "</tr>";
                            
                            // Cerramos la etiqueta thead
                            echo '</thead>';

                            // Cargamos el body de la tabla con las 100 primeras filas de la tabla seleccionada
                            echo "<tbody id='tbody-rows'>";
                            while (($row = pg_fetch_array($result2))) {
                                echo "<tr>";
                                // Recorremos las columnas obteniendo asi el valor correspondiente para cada fila
                                // Cada vez que vamos a recorrer las columnas debemos reiniciar el puntero mediante pg_result_seek
                                pg_result_seek($result1, 0);
                                for($i = 0 ; $i<intdiv(count($row),2) ; $i++){
                                    $column = pg_fetch_assoc($result1);
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
                                    Ocurrio un error al conectarse a la BD, ingrese nombre de la BD y de una tabla
                                </p>
                            </div>";
                    }

                ?>
                <div class="row mb-3">
                    <?php
                        if(isset($_GET['db']) && isset($_GET['name'])){
                            echo "<a id='btnvolver-".htmlspecialchars($_GET['db'])."' href='#' class='btn btn-primary col-12 col-sm-5 m-1'>Volver</a>";
                        }
                        else{
                            echo "<a href='index.php' class='btn btn-primary col-12 col-sm-5 m-1'>Inicio</a>";
                        }   
                    ?>
                    
                </div>
            </div>
        </div>
    <script src="./js/script-rows.js"></script>
<?php
    require __DIR__.'/template/footer.php'
?>