<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require 'search/google-search-results.php';
require 'search/restclient.php';
include  'search/search.php';
include  'answering/index.php';
include 'verify_play.php';
include 'search/get_video.php';

// Retrieve the data sent by the Chrome extension
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $requestData = file_get_contents('php://input');
  $data = json_decode($requestData);
  $result = $data->query;
   if (verifyPlay($result) == true){
   $answer = get_Json_From_Api_y($result);
    echo $answer;
   }else{
   $site = get_Json_From_Api($result);
   $answer = get_answer($result, $site);
   echo $answer;
  }
}
?>