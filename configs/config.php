<?php

$configFile = __DIR__ . "/credenciales.txt";
if (!file_exists($configFile)) {
    die("Error: El archivo de configuración $configFile no existe.");
}

// Se lee el archivo de configuración
$config = parse_ini_file($configFile);

// Se obtienen las credenciales de la base de datos desde el archivo de configuración
$host = $config['host'];
$port = $config['port'];
$user = $config['user'];
$password = $config['password'];


// Definir constantes para su uso posterior en el código
define("DB_HOST", $host);
define("DB_PORT", $port);
define("DB_USERNAME", $user);
define("DB_PASSWORD", $password);

?>