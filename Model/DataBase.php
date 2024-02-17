<?php

class Database{
    private $host;
    private $user;
    private $password;

    public function __construct(){
        $this->host     = DB_HOST;
        $this->user     = DB_USERNAME;
        $this->password = DB_PASSWORD;
    }

    function connect($db){
    try {
        // Cadena de conexión para PostgreSQL
        $connection = "pgsql:host=" . $this->host . ";dbname=" . $db . ";";
        
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
    
    function exec_query_db($db, $query, $params = []){
        $conn = $this->connect($db);
        $stmt = $conn->prepare($query);
        if($params != [])
            $stmt->execute($params);
        else
            $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>