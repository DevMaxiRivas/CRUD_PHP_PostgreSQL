<?php 
    require __DIR__.'/../template/header.php';
?>
    
        <div class="card-body ">
            <h5>Iniciar sesión</h5>
            <form action="" method="POST">
                <?php
                    if(isset($errorLogin)){
                        echo $errorLogin;
                    }
                ?>
            <div class="form-group">
                <label for="exampleInputUser">Nombre de usuario:</label>
                <input type="text" name="username" class="form-control" id="exampleInputUser" aria-describedby="userHelp" placeholder="Ingrese Usuario">
                <small id="userHelp" class="form-text text-muted">Nunca compartiremos tu nombre de usuario</small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Contraseña</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Ingresa Contraseña">
            </div>
            <div class="d-flex justify-content-end">
                <input type="submit" class="btn btn-primary" value="Iniciar Sesión">
            </div>
            </form>
            <form>
        </div>
<?php
    require __DIR__.'/../template/footer.php'
?>