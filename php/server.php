<?php
// Incluir NuSoap
require_once('classes/nusoap/nusoap.php');

// Crear una instancia del soap server
$server = new soap_server();

// Inicializar el soporte para WSDL
$server->configureWSDL('holawsdl', 'urn:holawsdl');

// Registrar el método
$server->register('hola',               // nombre método
    array('nombre' => 'xsd:string'),    // parámetros de entrada
    array('return' => 'xsd:string'),    // parámetros de salida
    'urn:holawsdl',                     // namespace
    'urn:holawsdl#hola',                // soapaction
    'rpc',                              // estilo
    'encoded',                          // uso
    'Saludar a quien se desee'          // documentación
);

// Definir el método como una función PHP
/**
 * Saludar a una persona
 *
 * @param string $nombre
 * @return string
 */
function hola($nombre) {
        return 'Hola, ' . $nombre;
}

// Usar la petición (en caso de existir) para invocar al servicio
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';

$server->service($HTTP_RAW_POST_DATA);

?>
