<?php

// Encargado del manejo de errores y de formular los archivos json que se enviaran
class CustomerController extends BaseController{
    // funcion encargada de realizar la busqueda del cliente por id
    public function id_action(){
        // Obtención del Metodo de la Solicitud
        $requestMethod = $_SERVER["REQUEST_METHOD"]; 

        // Si el Metodo es GET SEguimos procesando la solicitud, de lo contrario generamos un error
        if (strtoupper($requestMethod) == 'GET') {  
            try {
                // Iniciamos en vacio al string de Error
                $strErrorDesc = ''; 
                // Asignación del array de parametros de la URL
                $arrQueryStringParams = $this->getQueryStringParams();  
                $customerModel = new CustomerModel();   
                $id = 0;

                // si hay valor en el array asociativo con clave ¨id¨ y no esta la cadena vacia
                if (isset($arrQueryStringParams['id']) && $arrQueryStringParams['id']) { 
                    // Obtenemos el Id y generamos la consulta, trayendo la primer fila que 
                    // coincida con el id en customers
                    $id = $arrQueryStringParams['id']; 
                    $customer = $customerModel->get_customer_id($id);
                    // Recuperar la primera fila del resultado
                    $customer = $customer[0];

                    // Si no trajo ninguna Fila generará un json de tipo error como respuesta
                    if ( !$customer ) {         
                        $strErrorDesc = 'No existe cliente con id: '.$id;
                        $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                    }
                } 
                else { 
                    // si no hay valor en clave id o el valor es una cadena vacia
                    // caso .../id? | .../id?id=
                    // Tambien generará un json de tipo error como respuesta
                    $strErrorDesc = 'Debe ingresar un valor para id!';
                    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                }
                
            } catch (Error $e) {    
                // en caso de error inesperado, generará un json de tipo error como respuesta
                $strErrorDesc = 'Algo salio mal!: '. $e->getMessage();
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else { 
            // En caso de elegir cualquier Metodo no Soportado
            $strErrorDesc = 'Método no Soportado';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        // Envio de respuesta 
        $this->send_response($customer, $strErrorDesc, $strErrorHeader);
    }

    // Análogo al método anterior, pero tomando en cuenta el companyname del customer  
    public function name_action()
    {
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $strErrorDesc = '';
                $customerModel = new CustomerModel();
                $arrQueryStringParams = $this->getQueryStringParams();
                if (isset($arrQueryStringParams['name']) && $arrQueryStringParams['name']) {
                    $name = $arrQueryStringParams['name'];
                    $customer = $customerModel->get_customer_name($name);
                    $customer = $customer[0];

                    if ( !$customer ) {
                        $strErrorDesc = 'No existe cliente de nombre:'.$name;
                        $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                    }
                }
                else {
                    $strErrorDesc = 'Debe ingresar un valor para name!';
                    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                }
            } catch (Error $e) {
                $strErrorDesc = ' Algo salio mal!: '.$e->getMessage();
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Método no Soportado';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // enviamos la respuesta 
        $this->send_response($customer, $strErrorDesc, $strErrorHeader);
    }

    // Analogo al metodo id_action, pero tomando en cuenta el id y el companyname del customer
    public function id_name_action()
    {
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $strErrorDesc = '';
                $arrQueryStringParams = $this->getQueryStringParams();
                $customerModel = new CustomerModel();
                if (isset($arrQueryStringParams['id']) && $arrQueryStringParams['id'] &&
                    isset($arrQueryStringParams['name']) && $arrQueryStringParams['name']) {
                    $id = $arrQueryStringParams['id'];
                    $name = $arrQueryStringParams['name'];
                    $customer = $customerModel->get_customer_id_name($id,$name);
                    $customer = $customer[0];

                    if ( !$customer ) {
                        $strErrorDesc = 'No existe cliente con id '.$id.' y nombre '.$name.'';
                        $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                    }
                }
                else {
                    $strErrorDesc = 'Debe ingresar un valores para id y name!';
                    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                }
                
            } catch (Error $e) {
                $strErrorDesc = ' Algo salio mal!: '.$e->getMessage();
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Método no Soportado';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        } 
        $this->send_response($customer, $strErrorDesc, $strErrorHeader);
    }

    // Funcion que prepara la respuesta
    public function send_response($customer, $strErrorDesc, $strErrorHeader){
        // Se verifica el mensaje de error y en base al resultado se muestra el JSON
        if (!$strErrorDesc) {
            $this->sendOutput(
                json_encode(
                    array(
                        'status' => 'success',
                        'data' => $customer,
                        'message' => null 
                    )
                ),
                array(
                    'Content-Type: application/json',
                    'HTTP/1.1 200 OK'
                )
            );
        } else {
            $this->sendOutput(
                json_encode(
                    array(
                        'status' => 'error',
                        'data' => null,
                        'message' => $strErrorDesc 
                    )
                ), 
                array(
                    'Content-Type: application/json',
                    $strErrorHeader
                )
            );
        }
    }
}
?>