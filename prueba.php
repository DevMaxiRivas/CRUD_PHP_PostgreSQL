<?php
    require __DIR__ . "/inc/bootstrap.php";
    $prueba = new CustomerModel();
    $result = $prueba->get_customer_name("Alfreds Futterkiste");   
    foreach ($result as $currentUser) {
        echo $currentUser["customerid"];
    }
?>