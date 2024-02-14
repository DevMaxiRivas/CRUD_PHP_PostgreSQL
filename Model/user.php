<?php
include_once "Database.php";

class User extends Database{
    private $nombre;
    private $username;


    public function userExists($user, $pass){
        $query = $this->exec_query_db(
            'compras',
            'SELECT * 
            FROM users 
            WHERE 
                username = :user AND password = :pass ;',
            ['user' => $user, 'pass' => md5($pass)]
        );

        if($query){
            return true;
        }else{
            return false;
        }
    }

    public function setUser($user){
        $query = $this->exec_query_db(
            'compras',
            'SELECT * 
            FROM users
            WHERE username = :user ;',
            ['user' => $user]
        );
        
        foreach ($query as $currentUser) {
            $this->nombre = $currentUser['nombre'];
            $this->username = $currentUser['username'];
        }
    }

    public function getNombre(){
        return $this->nombre;
    }
}

?>