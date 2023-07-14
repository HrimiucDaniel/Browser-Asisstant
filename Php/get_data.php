<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

error_reporting(E_ERROR | E_PARSE);

require 'search/google-search-results.php';
require 'search/restclient.php';
include  'search/search.php';
include  'answering/index.php';
include 'verify_play.php';
include 'get_text_from_url.php';
include 'search/get_video.php';

$context = stream_context_create(
  array(
      "http" => array(
          "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
      )
  )
);


// Retrieve the data sent by the Chrome extension
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Wait for POST requests
  $requestData = file_get_contents('php://input');
  $data = json_decode($requestData);
  $result = $data->query;
   if (verifyPlay($result) == true){
   $answer = get_Json_From_Api_y($result);
    echo $answer;
   }else{
   $sites = get_Json_From_Api($result);
    $text = get_paragraphs_from_url($sites);
    $answer = get_answer($result, $text);
    echo $answer;
  }
}
?>