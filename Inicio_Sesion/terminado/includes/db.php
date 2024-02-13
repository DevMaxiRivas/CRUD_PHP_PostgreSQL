<?php

class DB{
    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;

    public function __construct(){
        $this->host     = 'postgres';
        $this->db       = 'compras';
        $this->user     = 'postgres';
        $this->password = "postgres";
    }

    function connect(){
    try {
        // Cadena de conexión para PostgreSQL
        $connection = "pgsql:host=" . $this->host . ";dbname=" . $this->db . ";";
        
        // Opciones específicas de PostgreSQL
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        // Creamos una instancia de PDO para PostgreSQL
        $pdo = new PDO($connection, $this->user, $this->password, $options);

        return $pdo;
    } catch (PDOException $e) {
        // En caso de error, imprimimos el mensaje
        print_r('Error connection: ' . $e->getMessage());
    }   
}

}






?>