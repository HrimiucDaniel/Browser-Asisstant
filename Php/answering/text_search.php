<?php

namespace writecrow\Lemmatizer;
require('lemmatizer/src/Lemmatizer.php');



function preprocess($text){
  $text = str_replace(".", " ", $text);
  $text = str_replace("\"", " ", $text);
  $terms = explode(" ", $text);
  $lowercaseterms = array_map('strtolower', $terms);

  $simplified = array();
  foreach($lowercaseterms as $terms) {
    $pattern = '/[^\p{L}\p{N}]+/u';
    $filteredString = preg_replace($pattern, '', $terms);
    $simplified[] = $filteredString;
  }

  $stop_words = array();

  $handle = fopen('stop_words.txt', 'r');

  if ($handle) {
    // Read the file line by line
    while (($line = fgets($handle)) !== false) {
      $pattern = '/[^\p{L}\p{N}]+/u';
      $filteredString = preg_replace($pattern, '', $line);
      $stop_words[] = $filteredString;
      
    }

       // Close the file handle
        fclose($handle);
    } else {
       // Handle error opening the file
       echo "Error opening the file.";
       die();
    }


    $filteredWords = array();

    foreach ($simplified as $word) {

        // Check if the word is not a stop word
        if (!in_array($word, $stop_words)) {
            // Add the word to the filtered words array
            if ($word != ""){
            $word = Lemmatizer::getLemma($word);
            $filteredWords[] = $word;
          }

        }
    }

    return $filteredWords;

}

function lemmanize($word){
  return Lemmatizer::getLemma($word);
}

function get_word_match($array_of_words_1, $array_of_words_2){
  $commonElements = array_intersect($array_of_words_1, $array_of_words_2);
  return count($commonElements);
}

?>