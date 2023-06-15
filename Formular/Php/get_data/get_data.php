<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
var_dump($_POST); // Print the entire $_POST array for debugging

// Access the specific data sent from the extension
$data = $_POST['key'];
echo $data;
?>