<?php
    // Cargamos los recursos necesarios e incluimos las acciones para controlar a clientes
    require __DIR__ . "/inc/bootstrap.php";
    // require __DIR__ . "/Model/CustomerModel.php";
    
    $objFeedController = new CustomerController();
    $uri = $objFeedController->getUriSegments();
    
    // Si luego de obtener el array:
    //      * No encuentra valor en $uri[3]
    //      * Encuentra un valor diferente a 'customer' en $uri[3] 
    //      * No encuentra valor en $uri[4]
    // termina el script y redirecciona a pagina no encontrada
    if (!isset($uri[3]) || (isset($uri[3]) && $uri[3] != 'customer') || !isset($uri[4])) {
        header("HTTP/1.1 404 Not Found");
        exit();
    }

    // Caso contrario, construye el nombre del método que se llamará 
    // en CustomerController. Toma el quinto segmento de la URI (índice 4 en el array $uri)
    // y le agrega '_action'.
    $strMethodName = $uri[4] . '_action';

    // en base al valor $uri[4] se llamara a algunos de los siguientes metodos:
    //      * metodo id_action 
    //      * metodo name_action
    //      * metodo __call (metodo magico que se ejecuta cuando llamamos a uno no definido)
    $objFeedController->{$strMethodName}();
?>