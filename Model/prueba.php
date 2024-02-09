<?php
    include_once("CustomerModel.php");
    include_once("../inc/config.php");
    $prueba = new CustomerModel();
    $result = $prueba->get_customer_name("Alfreds Futterkiste");   
    foreach ($result as $currentUser) {
        echo $currentUser["customerid"];
    }
?>