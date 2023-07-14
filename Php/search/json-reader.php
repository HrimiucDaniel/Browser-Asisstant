<?php
function read_from_json($json){
// $file_path = $path;

// // Read the contents of the file into a string
// $json_string = file_get_contents($file_path);

// Parse the JSON string into a PHP object
$data = json_decode($json, true);

// Access the "link" of the second element in the "organic_results" array
$links = array();
for ($i = 0; $i <= 4; $i++){
$link = $data['organic_results'][$i]['link'];
$links[] = $link;
}
return $links; // Output: https://www.coffeebean.com/
}
?>