<?php
  require ('simple_html_dom.php');

  function get_paragraphs_from_url($site){

    $i = 0;
    do{
    try {
      $ok = 1;
      $html = file_get_html($site[$i]);
      $list = $html->find('p');
     } catch (Throwable $e) {
      $ok = 0;
      $i = $i + 1;
     }
     if ($list == null or sizeof($list) == 0){
      echo $i . $list[$i] . "<br>";
      $ok = 0;
      $i = $i + 1;
     }
    }while($ok == 0);




 

  $text = array();

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

  return $text;
}


?>