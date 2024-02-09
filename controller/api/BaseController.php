<?php

//  Proporciona funcionalidades básicas comunes para controladores en una aplicación PHP.
//  Incluye métodos para obtener información sobre la URI y la cadena de consulta, así como
//  un método para enviar la salida de la API con encabezados HTTP y datos. 

class BaseController
{

    // se activa cuando se intenta llamar a un método que no existe o
    // no es accesible desde fuera de la clase. En este caso, se utiliza
    // para manejar cualquier llamada a un método que no esté definido en
    // la clase BaseController. Cuando se activa, llama al método sendOutput()
    // para enviar una respuesta con código de estado 404 (Not Found).

    public function __call($name, $arguments)
    {
        $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
    }
   

    // se utiliza para obtener los segmentos de la URI actual. La URI es la parte
    // de la URL que identifica un recurso. Este método utiliza la variable 
    // $_SERVER['REQUEST_URI'] para obtener la URI, divide dicha URI en segmentos usando 
    // el carácter / como separador, y devuelve un array conteniendo los segmentos.
    // La URI Debe seguir el siguiente formato:
    // localhost/CarpetaProyecto/api.php/customer/{id | name}?{id | name}=
    // Obteniendo al dividir la URL un array que al menos contendra:
    // ['', 'CarpetProyecto', 'api.php', 'customer']
    
    public function getUriSegments()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode( '/', $uri );
        return $uri;
    }

    
    // se utiliza para obtener los parámetros de la cadena de consulta (query string)
    // actual. La cadena de consulta es la parte de la URL después del signo de 
    // interrogación (?) y generalmente se utiliza para enviar datos al servidor. 
    // Este método utiliza $_SERVER['QUERY_STRING'] y la función parse_str() para 
    // convertir los parámetros en un array asociativo.
    
    protected function getQueryStringParams()
    {
        parse_str($_SERVER['QUERY_STRING'], $query);
        return $query;
    }


    // se utiliza para enviar la salida de la API. Permite enviar datos y encabezados HTTP.
    // Primero, elimina cualquier cookie que pueda estar presente en los encabezados. Luego, 
    // si se proporcionan encabezados HTTP, los envía usando header(). Finalmente, imprime 
    // los datos y termina la ejecución del script con exit.

    protected function sendOutput($data, $httpHeaders=array())
    {
        header_remove('Set-Cookie');
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
        echo $data;

        exit;
    }
}
?>