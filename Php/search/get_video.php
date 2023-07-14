<?php

function get_Json_From_Api_y($query){

  $first_word_index = strpos($query, " ");
  $query_usefull = substr($query, $first_word_index + 1);

  $query = [
    "engine" => "youtube",
    "search_query" => $query_usefull,
   ];
   
   $search = new GoogleSearch('dfebb12534c3696a3f1c5be7b9a824a3613ba0f5b98a3e2d9891191afcf69b62');
   $result = $search->get_json($query);
   $json = json_encode($result);
   $data = json_decode($json, true);
   $video_results = $data['video_results'][0]['link'];
return $video_results;
}

?>