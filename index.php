<?php
    require __DIR__.'/template/header.php'
?>

        <div class="card-body border border-primary">
            <h5 class="card-title">Inicio</h5>
            <p class="card-text">Elija la base de datos con la que quiera interactuar.</p>
            <form action="#" method="get">
                <div class="mb-6 border border-primary">    
                    <select id="selected-db" class="form-select" aria-label="Default select example">
                        <option id="opt-default" value='' selected>Base de Datos...</option>
                        <?php
                            // Importamos los archivos necesarios para crear una conexión
                            require_once __DIR__."/inc/bootstrap.php";
                            $db = new DataBase();
                            $query = 'select datname from pg_database';
                            $result = $db->exec_query_db($query, 'postgres');
                            if($result){
                                // Cargamos las opciones dentro del combo-box
                                while ($row = pg_fetch_row($result)) {
                                    if ($row[0] != 'postgres' && $row[0]!='template0' && $row[0]!='template1' ) {
                                        echo "<option value='$row[0]'>$row[0]</option>";

                                    }
                                }
                                echo "
                                    </select>
                                    <hr>";
                            }
                            else{
                                // Si la consulta falla, notificamos al usuario
                                echo "
                                    </select>
                                    <div class='alert alert-danger' style='heigth:5em;'>
                                        <p>
                                            Ocurrio un error al conectarse a la BD, ingrese nombre de la BD y de una tabla
                                        </p>
                                    </div>";
                            }
                            
                        ?>
                    <label id="label-bd-1"></label>
                </div>
                <div class="row mb-3 d-flex justify-content-center border border-primary">
                    <!--Colocamos links hacia "Ver Tablas" y "Ver Sesiones" -->
                    <a id="link-tables" href='#' class="btn btn-primary col-6 col-sm-5 m-2">Ver Tablas</a>
                    <a id="link-sessions" href="#" class="btn btn-primary col-6 col-sm-5 m-2">Ver Sesiones</a>
                </div>
            </form>
        </div>
    </div>
    <script src="./js/script-index.js"></script>

<?php
    require __DIR__.'/template/footer.php'
?>