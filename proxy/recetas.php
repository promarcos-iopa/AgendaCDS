<?php

// Configuración del endpoint remoto
$api_url = 'http://186.64.123.171/rebsol_info/public/api/recetas';

// Determinar el método HTTP
$method = $_SERVER['REQUEST_METHOD'];

// Inicializar cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
curl_setopt($ch, CURLOPT_URL, $api_url);

// Si es un método POST o PUT, pasar el cuerpo de la solicitud
if ($method === 'POST' || $method === 'PUT') {
    $post_data = file_get_contents('php://input');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

    // Pasar el tipo de contenido de la solicitud
    if (isset($_SERVER['CONTENT_TYPE'])) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: ' . $_SERVER['CONTENT_TYPE']]);
    }
}

// Pasar parámetros GET directamente
if ($method === 'GET' && !empty($_GET)) {
    $query_string = http_build_query($_GET);
    curl_setopt($ch, CURLOPT_URL, $api_url . '?' . $query_string);
}

// Ejecutar la solicitud al servidor remoto
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Devolver la respuesta al cliente
http_response_code($http_code);
header('Content-Type: application/json'); // Ajusta según el tipo de contenido esperado
echo $response;
