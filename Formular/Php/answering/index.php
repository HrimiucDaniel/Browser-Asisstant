<?php

use function writecrow\Lemmatizer\get_word_match;
use function writecrow\Lemmatizer\preprocess;

require ('simple_html_dom.php');
require ('text_search.php');
require ('qa_answering.php');

function remove_wiki($text){
  $result = preg_replace('/\[[^\]]+\]/', '', $text);
  return $result;
}
function get_answer($query, $site){
  $html = file_get_html($site);

  //echo $html->find('title', 0)->plaintext;

  $list = $html->find('p');

  $text = array();
  $initial_query = $query;



  $counter = 0;
  foreach($list as $element){
    if (strpos($element->plaintext, ".") !== false) {
      if (in_array($element->plaintext, $text) !== true) {
        $text[]= $element->plaintext;
        $counter = $counter + 1;
      //  echo $counter . " " . $element->plaintext;
      //   echo "<br>";
      //   echo "<br>";
      }

    }
    if ($counter >= 20) {
      break;
    }
  }

  $question_type = "Uknown";

  $question_type = question_classification($initial_query);

  $term_list = array();

  $query_list = array();

  $preprocessed_line = preprocess($initial_query);


  $count_array = array();

  $important_terms_array = array();

  foreach($preprocessed_line as $word){
    $query_list[] = $word;
  }
  $query_list = array_unique($query_list);
  //print_r($query_list);

  foreach($text as $line){
  // echo $line . "<br>";
    $preprocessed_line = preprocess($line); 
    foreach($preprocessed_line as $word){
      if ($word !== "") {
      $term_list[] = $word;
      
      }
    }
    $counter = get_word_match($query_list, $preprocessed_line);
    if ($counter != 0) {
      $counter_important_terms = get_Important_terms_count($preprocessed_line, $query_list, $question_type, $initial_query, $line);
      $count_array[$line] = $counter;
      $important_terms_array[$line] = $counter_important_terms;
    }
  // echo $counter . "<br>" . "<br>" . "<br>";
  }
  arsort($count_array);


  //  foreach ($count_array as $key => $value) {
  //    echo $key . ": " . $value . "<br>" . "<br>" . "<br>";
  //  }

  // echo "<hr>";

  $answer_array = question_Answering($initial_query, $count_array);

  //  foreach ($answer_array as $key => $value) {
  //    echo $key . ": " . $value . "<br>" . "<br>" . "<br>";
  //  }

  //  echo "<hr>";

  arsort($important_terms_array);

  //  foreach($important_terms_array as $key => $value) {
  //    echo $key . ": " . $value . "<br>" . "<br>" . "<br>";
  //  }

  // echo "<hr>";
  // echo "<hr>";
  // echo "<hr>";
  $mean_array = array();

  foreach ($count_array as $key => $value) {
    $mean_array[$key] = $count_array[$key] + $answer_array[$key] + $important_terms_array[$key];
    $mean_array[$key] /= 3;
  }

  arsort($mean_array);
  $answer = array_key_first($mean_array);
  $final_answ = remove_wiki($answer);
  return $final_answ;



 /// foreach($mean_array as $key => $value) {
    //echo $key . ": " . $value . "<br>" . "<br>" . "<br>";
//  }

}
?>