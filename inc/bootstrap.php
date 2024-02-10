<?php
define("PROJECT_ROOT_PATH", __DIR__ . "/../");
// incluimos el archivo principal de configuracion 
require_once PROJECT_ROOT_PATH . "/inc/config.php";

// incluimos el Controlador base para la API
require_once PROJECT_ROOT_PATH . "/controller/api/BaseController.php";

// incluimos el Controlador de la API para la tabla Customer
require_once PROJECT_ROOT_PATH . "/controller/api/CustomerController.php";

// incluimos el archivo del modelo base
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

// incluimos el archivo del modelo de cliente 
require_once PROJECT_ROOT_PATH . "/Model/CustomerModel.php";

// Definimos el nivel de error
error_reporting(E_ERROR);
?>