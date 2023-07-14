<?php
include 'json-reader.php';

function get_Json_From_Api($query_name){
$query = [
  "q" => $query_name,
  "location" => "Austin, Texas, United States",
  "hl" => "en",
  "gl" => "us",
  "google_domain" => "google.com",
  "num" => 5,
 ];

 $search = new GoogleSearch('dfebb12534c3696a3f1c5be7b9a824a3613ba0f5b98a3e2d9891191afcf69b62');
 $result = $search->get_json($query);
 $json = json_encode($result);

 // Save the JSON string to a file
  return read_from_json($json);
}
// $data = json_decode($result, true);
 //echo json_encode($data);
?>






