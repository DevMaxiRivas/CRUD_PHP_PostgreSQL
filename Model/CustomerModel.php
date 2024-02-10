<?php
class CustomerModel extends Database{
    // Metodos utilizado para consultar a la BD Northwind
    // Ambos metodos utilizan exec_query_db, el cual 
    // pertenece a la clase padre Database
    // este metodo devuelve un/ningun customer dado un id
    public function get_customer_id($id){
        $db = 'northwind';
        $query = $this->connect($db)->prepare('
            SELECT * 
            FROM customers 
            WHERE trim(customerid) = :id 
            ORDER BY customerid limit 1;
        ');
        $query->execute(['id' => $id]);

        if($query->rowCount()){
            // Se usa PDO::FETCH_ASSOC para que se devuelva un 
            // array de arrays asociativo
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return '';
    }
    public function get_customer_id_name($id, $name){
        $db = 'northwind';
        $query = $this->connect($db)->prepare('
            SELECT * 
            FROM customers 
            WHERE trim(customerid) = :id 
            AND trim(companyname) ILIKE :name
            ORDER BY customerid limit 1;
        ');
        $query->execute(['id' => $id, 'name' => $name]);

        if($query->rowCount()){
            return $query;
        }
        return '';
    }
    public function get_customer_name($name){
        $db = 'northwind';
        $query = $this->connect($db)->prepare('
            SELECT * 
            FROM customers 
            WHERE trim(companyname) ILIKE :name
            ORDER BY customerid limit 1;
        ');
        $query->execute(['name' => $name]);

        if($query->rowCount()){
            return $query;
        }
        return '';
    }

    

}
?>