<?php
define("PROJECT_ROOT_PATH", __DIR__ . "/../");
// incluimos el archivo principal de configuracion 
require_once PROJECT_ROOT_PATH . "/configs/config.php";

// incluimos el archivo del modelo base
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

// incluimos el archivo del modelo user
require_once PROJECT_ROOT_PATH . "/Model/user.php";

// incluimos el archivo administrador de sesiones
require_once PROJECT_ROOT_PATH . "/includes/user_session.php";

// Definimos el nivel de error
error_reporting(E_ERROR);
?>