<?php
use function writecrow\Lemmatizer\lemmanize;



  $location_terms = array("capital", "city", "country", "cities", "countries", "state", "tourist", "waterfall", "take place", "body of water", "river", "lake", "ocean", "sea", "highest point", "mountain", "border", "desert", "north", "south", "west", "east", "forest", "continent", "address", "building", "originate", "site");
  $date_terms = array("date", 'month', "day", "year", "period", "season", "week", "century", "birthdate");
  $numeric_terms = array("size", "speed", "price");
  $human_terms = array("inventor", "company", "starred", "actress", "actor", "painter", "founder", "athlete", "man", "woman", "discovered", "car", "mayor", "president", "singer", "composer", "occupation", "creator", "explorer", "organization", "writer", "school", "president", "son", "mother", "father", "daughter", "brother", "sister", "leader", "lawyer", "model", "agency", "dictator", "manufacturer" , "novelist", "college", "star", "army", "game", "sport", "character", "girl", "boy", "title", "professor", "cook", "author", "husband", "wife", "child", "hero", "poet", "poem", "song", "movie", "novel", "judge");

function question_classification($question) {

  if (preg_match('/^(when|What time|In what year|In which year|On what date|What was the date|On what year|What year|What date|On what day)/i', $question)) {
    return "Date";
  }elseif (preg_match('/^(who)/i', $question)) {
    return "Human";
  }elseif (preg_match('/^(how many|how much|how long|how big|how tall|how old|how far|how high|how loud|how cold|how hot|how deep|What percentage|What are the chances|At what age|what ratio|What is the probability|how often|how fast)/i', $question)) {
    return "Number";
  }elseif  (preg_match('/^(where)/i', $question)) {
    return "Location";
  }else{
    return "Unkown";
  }
}

$months = array(
  'January', 'February', 'March', 'April', 'May', 'June', 'July',
  'August', 'September', 'October', 'November', 'December'
);

function hasNumber($string) {
  return preg_match('/\d/', $string) === 1;
}

function hasDifficultDate($string){
  global $months;
  $position = -1;
  foreach ($months as $month) {
    if (stripos($string, $month) !== false) {
      $position = stripos($string, $month);
      for($i = $position; ;$i++){
        if($string[$i] == " "){
          break;
        }
      }
      $i++;
      $n = $string[$i] . $string[$i+1];
      if (ctype_digit($n)) {
        return true;
      }
    }
  }
  return false;

}
function containsDate($string) {
  $pattern1 = '/\d{2}\/\d{2}\/\d{4}/';
  $pattern2 = '/\d{2}\.\d{2}\.\d{4}/';
  $pattern3 = '/\d{2}-\d{2}-\d{4}/';
  if (preg_match($pattern1, $string) || preg_match($pattern2, $string) || preg_match($pattern3, $string) or hasDifficultDate($string)) {
    return true;
  }else{
    return false;
  }
}

function containsYear($string) {
  $pattern = '/\b\d{4}\b/';
  return preg_match($pattern, $string) ? 'The string contains a year.' : 'The string does not contain a year.';
}

function containsMonth($string) {
  global $months;
  foreach ($months as $month) {
    if (stripos($string, $month) !== false) {
      return true;
    }
  }

  return false;
}

function containsDay($string) {
  $daysOfWeek = array(
    'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'
  );

  foreach ($daysOfWeek as $day) {
    if (stripos($string, $day) !== false) {
      return true;
    }
  }

  return false;
}


function date_Question_Answering($question, $text_to_search){
  $answer_array = array();
  foreach ($text_to_search as $key => $value) {
      if (containsDate($key)){
       $answer_array[$key] = 3;
      }else if (containsYear($key)){
        $answer_array[$key] = 2.5;
        if (strpos($question,"year") !== false) {
          $answer_array[$key] = 3;
        }
      }else if (containsMonth($key)){
        $answer_array[$key] = 2;
        if (strpos($question,"month") !== false) {
          $answer_array[$key] = 3;
        }
      }else if (containsDay($key)) {
        $answer_array[$key] = 1.5;
        if (strpos($question,"day of the week") !== false) {
          $answer_array[$key] = 3;
        }
      }else if(hasNumber($key)){
        $answer_array[$key] = 1;
      }else{
        $answer_array[$key] = 0;
      }
    
  }
  return $answer_array;
}

function contains_At_Least_2_Upercases($string){
  $pattern = '/\b[A-Z]\w*\b\s+\b[A-Z]\w*\b/';
  if (preg_match($pattern, $string)) {
    return true;
  } else {
    return false;
  }
}

function contains_At_Least_One_Uppercase($string){
  $pattern = '/\b[A-Z]\w*\b/';
  if (preg_match($pattern, $string)) {
    return true;
  } else {
    return false;
  }

}

function human_Question_Answering($question, $text_to_search){
  $answer_array = array();
  foreach ($text_to_search as $key => $value) {
    if (contains_At_Least_2_Upercases($key)) {
      $answer_array[$key] = 3;
    }else if (contains_At_Least_One_Uppercase($key)){
      $answer_array[$key] = 1.5;
    }else{
      $answer_array[$key] = 0;
    }
  
  }
  return $answer_array;
}

function at_Least_A_Number($string){
  $pattern = '/\d/';
  if (preg_match($pattern, $string)){
    return true;
  }else{
    return false;
  }
}

function number_Question_Answering($question, $text_to_search){
  $answer_array = array();
  foreach($text_to_search as $key => $value){
    if (at_Least_A_Number($key)){
      $answer_array[$key] = 3;
    }else{
      $answer_array[$key] = 0;
    }
  }
  return $answer_array;
}

function location_Question_Answering($question, $text_to_search){
  $answer_array = array();
  foreach($text_to_search as $key => $value){
    if (contains_At_Least_One_Uppercase($key)){
      $answer_array[$key] = 3;
    }else{
      $answer_array[$key] = 0;
    }
  }
  return $answer_array;
}

function unknown_Question_Answering($question, $text_to_search){
  $answer_array = array();
  foreach($text_to_search as $key => $value){
    $answer_array[$key] = 1;
  }
  return $answer_array;
}

function question_Answering($question, $text_to_search){
  $answer_array = array();
  if (question_classification($question) == "Date"){
    $answer_array = date_Question_Answering($question, $text_to_search);
  }else if (question_classification($question) == "Human") {
    $answer_array = human_Question_Answering($question, $text_to_search);
  }else if (question_classification($question) == "Number"){
    $answer_array = number_Question_Answering($question, $text_to_search);
  }else if(question_classification($question) == "Location"){
    $answer_array = location_Question_Answering($question, $text_to_search);
  }else{
    $answer_array = unknown_Question_Answering($question, $text_to_search);
  }

  arsort($answer_array);
  return $answer_array;
}

function get_Date_Terms($preprocessed_text, $preprocessed_question){
  global $date_terms;
  $bigger_date_terms = array_merge($date_terms, array("born", "die", "live", "published", "became", "invented", "birthday", "introduced", "developed", "begin", "established"));
  $bigger_date_terms_lem = array();
  foreach($bigger_date_terms as $term){
    $bigger_date_terms_lem[] = lemmanize($term);
  }
  $imp_terms = array_intersect($bigger_date_terms_lem, $preprocessed_question);
  $terms_array = array_intersect($preprocessed_text, $imp_terms);
  return count($terms_array);
}

function get_Uppercase_Terms($question, $text){
  $pattern = '/\b[A-Z]\w*\b/';
  preg_match_all($pattern, $question, $matches);
  $values = array_values($matches[0]);
  $count = 0;
  foreach($values as $value){
      if (strpos($text, $value) !== false) {
        $count++;
      }
  }
  return $count;

}

function get_Human_Terms($preprocessed_text, $preprocessed_question){
  global $human_terms;
  $human_terms_lem = array();
  foreach($human_terms as $term){
    $human_terms_lem[] = lemmanize($term);
  }
  $imp_terms = array_intersect($human_terms_lem, $preprocessed_question);
  $terms_array = array_intersect($preprocessed_text, $imp_terms);
  return count($terms_array);
}

function get_Number_Terms($preprocessed_text, $preprocessed_question){
  global $numeric_terms;
  $number_terms_len = array();
  foreach($numeric_terms as $term){
    $number_terms_len[] = lemmanize($term);
  }
  $imp_terms = array_intersect($number_terms_len, $preprocessed_question);
  $terms_array = array_intersect($preprocessed_text, $imp_terms);
  return count($terms_array);
}

function get_Extra_Terms($question, $text){
  if (preg_match('/^(how many|how much)/i', $question)){
    $terms = explode(" ", $question);
    $term_imp = $terms[2];
  }else{
    $i = 2;
    $terms = explode(" ", $question);
    while(in_array($terms[$i], ["this", "the", "was"])){
      $i = $i + 1;
    }
    $term_imp = $terms[$i];
  }
  if (stripos($text, $term_imp)){
    return 2;
  }else{
    return 0;
  }
}

function get_Location_Terms($preprocessed_text, $preprocessed_question){
  global $location_terms;
  $location_terms_lem = array();
  foreach($location_terms as $term){
    $location_terms_lem[] = lemmanize($term);
  }
  $imp_terms = array_intersect($location_terms_lem, $preprocessed_question);
  $terms_array = array_intersect($preprocessed_text, $imp_terms);
  return count($terms_array);
}

function get_Important_terms_count($preprocessed_text, $preprocessed_question, $question_type, $question, $text){
  $terms_count = 0;
  if ($question_type == "Date"){
    $terms_count = get_Date_Terms($preprocessed_text, $preprocessed_question);
    $terms_count += get_Uppercase_Terms($question, $text);
  }else if ($question_type == "Human"){
    $term_count  = get_Human_Terms($preprocessed_text, $preprocessed_question);
  }else if ($question_type == "Number")
  {
    $term_count  = get_Number_Terms($preprocessed_text, $preprocessed_question);
    $term_count += get_Uppercase_Terms($question, $text);
    $term_count += get_Extra_Terms($question, $text);
  }else if ($question_type == "Location"){
    $term_count = get_Location_Terms($preprocessed_text, $preprocessed_question);
  }else{
    $term_count = 1;
    $term_count += get_Uppercase_Terms($question, $text);
  }
  return $terms_count;
}




?>