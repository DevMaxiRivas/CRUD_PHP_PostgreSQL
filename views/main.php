<?php
    require __DIR__.'/../template/header.php';
?>

        <div class="card-body ">
            <h5 class="card-title">Bienvenido <b><?php echo $user->getNombre(); ?></b></h5>
            <p class="card-text">Elija la base de datos con la que quiera interactuar.</p>
            <form action="#" method="get">
                <div class="mb-6 ">    
                    <select id="selected-db" class="form-select" aria-label="Default select example">
                        <option id="opt-default" value='' selected>Base de Datos...</option>
                        <?php
                            // Importamos los archivos necesarios para crear una conexión
                            require_once __DIR__."/../routes/bootstrap.php";
                            $db = new DataBase();
                            $result = $db->exec_query_db(
                                "postgres",
                                'SELECT datname FROM pg_database'
                            );
                            if($result){
                                // Cargamos las opciones dentro del combo-box
                                foreach ($result as $row) {
                                    if ($row['datname'] != 'postgres' && $row['datname']!='template0' && $row['datname']!='template1' ) {
                                        echo "<option value=" . $row['datname'] . ">" . $row['datname'] . "</option>";
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
                <div class="row mb-3 d-flex justify-content-center">
                    <!--Colocamos links hacia "Ver Tablas" y "Ver Sesiones" -->
                    <a id="link-tables" href='#' class="btn btn-primary col-6 col-sm-5 m-2">Ver Tablas</a>
                    <a id="link-sessions" href="#" class="btn btn-primary col-6 col-sm-5 m-2">Ver Sesiones</a>
                </div>
            </form>
        </div>
        <div class="d-flex justify-content-end">
            <a href="includes/logout.php" class="btn btn-danger" >Cerrar sesión</a>
        </div>
    </div>
    <script src="./js/script-index.js"></script>

<?php
    require __DIR__.'/../template/footer.php'
?>