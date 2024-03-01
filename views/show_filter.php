<?php
                    require __DIR__.'/../template/header.php';
                    if(isset($_GET['db']) && isset($_GET['name'])){
                        echo "<h5 class='card-title'>Filtrar la tabla ".$_GET['name']."</h5>";
                    }
                    else{
                        echo "<h5 class='card-title'>Ocurrio un error al intentar filtrar</h5>";
                    }                    

                    // Importamos los archivos necesarios para realizar una conexíon
                    require_once __DIR__."/../routes/bootstrap.php";
                    $conn = new DataBase();
                    // Limitamos el nro de filas a 100
                    $limit = 100;
                    if(isset($_GET['db']) && isset($_GET['name'])){
                        // Leemos variables pasadas por url para saber en que BD y en que Tabla hacer la consulta 
                        $db = htmlspecialchars($_GET['db']);
                        $table = htmlspecialchars($_GET['name']);

                        // Obtenemos las columnas de la tabla verificando que no sean del tipo bytea ni oid

                        $columns = $conn->exec_query_db(
                            $db,
                            "SELECT column_name, data_type
                            FROM information_schema.columns 
                            WHERE 
                                table_name = :table
                                AND data_type NOT IN ('bytea','oid');",
                            ['table' => $table]                     
                        );
                        
                    // Creamos un formulario con la columnas de las tablas
                        if ($columns) {
                            echo '<form action="show_result.php" method="POST">';
                            
                            foreach ($columns as $col){
                                echo 
                                    '<div class="form-group">
                                        <label for="'.$col['column_name'].'">'.$col['column_name'].'</label>
                                        <input type="text" class="form-control" id="'.$col['column_name'].'" name="'.$col['column_name'].'" placeholder="Enter '.$col['column_name'].'">
                                    </div>';
                            }


                        echo 
                            '   <input type="hidden" name="db" value="'.$db.'">
                                <input type="hidden" name="table" value="'.$table.'">

                                <div class="row mb-3 d-flex justify-content-center">
                                    <a id="btnvolver-'.$db.'-'.$table.'" href="#" class="btn btn-primary col-6 col-sm-5 m-2">Volver</a>
                                    <button type="submit" class="btn btn-success col-6 col-sm-5 m-2">Filtrar</button>
                                </div>
                            </form>';
                        }else{
                            // Si la consulta fallo, se le notificara al usuario
                            echo "
                                <div class='alert alert-danger' style='heigth:5em;'>
                                    <p>
                                        No se pudo obtener las columnas de la Tabla
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
            </div>
        </div>
    <script src="./../js/script-filter.js"></script>
<?php
    require __DIR__.'/../template/footer.php'
?>