<?php
class CustomerModel extends Database{
    // Metodos utilizado para consultar a la BD Northwind
    // Ambos metodos utilizan exec_query_db, el cual 
    // pertenece a la clase padre Database
    // este metodo devuelve un/ningun customer dado un id
    public function get_customer_id($id){
        $db = 'northwind';
        $query = $this->exec_query_db($db,'
            SELECT * 
            FROM customers 
            WHERE trim(customerid) = :id 
            ORDER BY customerid limit 1;
        ',['id' => $id]);

        if(count($query)){
            // Se usa PDO::FETCH_ASSOC para que se devuelva un 
            // array de arrays asociativo
            return $query;
        }
        return '';
    }
    public function get_customer_id_name($id, $name){
        $db = 'northwind';
        $query = $this->exec_query_db($db,'
            SELECT * 
            FROM customers 
            WHERE trim(customerid) = :id 
            AND trim(companyname) ILIKE :name
            ORDER BY customerid limit 1;
        ',['id' => $id, 'name' => $name]);

        if(count($query)){
            return $query;
        }
        return '';
    }
    public function get_customer_name($name){
        $db = 'northwind';
        $query = $this->exec_query_db($db,'
            SELECT * 
            FROM customers 
            WHERE trim(companyname) ILIKE :name
            ORDER BY customerid limit 1;
        ',['name' => $name]);

        if(count($query)){
            // Se usa PDO::FETCH_ASSOC para que se devuelva un 
            // array de arrays asociativo
            return $query;
        }
        return '';
    }

    

}
?>