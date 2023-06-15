<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Retrieve the data sent by the Chrome extension
$requestData = file_get_contents('php://input');
$data = json_decode($requestData);
$result = $data->query;
echo $result;
?>