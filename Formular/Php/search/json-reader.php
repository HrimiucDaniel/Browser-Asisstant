<?php
function read_from_json($json){
// $file_path = $path;

// // Read the contents of the file into a string
// $json_string = file_get_contents($file_path);

// Parse the JSON string into a PHP object
$data = json_decode($json, true);

return $data['organic_results'][0]['link']; // John
}
?>