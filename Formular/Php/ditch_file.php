----text search

// function compute_Total_nr_term($term, $documents){
//   $count = 0;
//   foreach ($documents as $doc) {
//     $count += substr_count(strtolower($doc), strtolower($term));
//   }
//   return $count;
// }

// function computeTF_IDF_score($term, $document, $documents) {
//   $term_frequency = substr_count($document, $term);

//   $Total_nr = count($documents);

//   $IDf_nr = compute_Total_nr_term($term, $documents);

//   if ($IDf_nr == 0) {
//     $IDF = 0;
//   }else{
//     $IDF = log($Total_nr / $IDf_nr);
//   }
//   $TF_IDF = $term_frequency * $IDF;
  
//   return $TF_IDF;

// }
// function cosine_similarity($array1, $array2){
//   $product = array_sum(array_map(function ($a, $b) {
//     return $a * $b;
// }, $array1, $array2));

// $norm = sqrt(array_sum(array_map(function ($a) {
//   return $a * $a;
// }, $array1))) * sqrt(array_sum(array_map(function ($a) {
//   return $a * $a;
// }, $array2)));


// $cosine = $product / $norm;

// return $cosine;




// }

-----index


// $matrix = array();

// foreach($text as $line){
// $temp = array();
//   foreach($term_list as $term) {
//     if ($term != "")
//     $temp[] = computeTF_IDF_score($term, $line, $text);
//   }
//   $matrix[] = $temp;
// }



// $rows = count($matrix);
// $cols = count($matrix[0]);

// // Print the matrix
// for ($i = 0; $i < $rows; $i++) {
//     for ($j = 0; $j < $cols; $j++) {
//       //  echo $matrix[$i][$j] . " ";
//     }
//   //  echo "<br>";
//  //   echo "<br>";
//   //  echo "<br>";
//  //   echo "<br>"; // Move to the next line after printing each row
// }

// $query_idf = array();

// $preprocessed_line = preprocess($initial_query);

// foreach($term_list as $word){
//   if ($word != "")
// $term = computeTF_IDF_score($word, $initial_query, $text);
// $query_idf[] = $term;
// }


// $count = 0;
// foreach($text as $line) {
//  // echo $count . "." . $line . "<br>";
//   //echo cosine_similarity($matrix[$count], $query_idf) . "<br>" . "<br>" . "<br>" . "<br>";

//   $count = $count + 1;
// }





----qa_answering

// function generateNGrams($string, $n) {
//   $ngrams = [];
//   $length = mb_strlen($string);

//   for ($i = 0; $i <= $length - $n; $i++) {
//       $ngram = mb_substr($string, $i, $n);
//       $ngrams[] = $ngram;
//   }

//   return $ngrams;
// }

// function generate_date_response($question, $text){
//   $similar = array();
//   $n = 2;
//   $qgrams = generateNGrams($question, $n);
//   foreach ($text as $line) {
//     $ngrams = generateNGrams($line, $n);
//     $commonElements = array_intersect($qgrams, $ngrams);
//     $similar[$line] = count($commonElements);  
//     echo $line . "<br>" . $similar[$line] . "<br>" . "<br>";
//     //lemmization
//     //patern
//     //word match
//   }
//   // if the lines with the highest score contains date(and question contains when or date) - choose them
//   // else if the lines with the highest score contains months - and in question we have month - choose them
//   // else if the lines with the highest score contains numbers - choose them
//   // maybe something with season/week/day of the week

// }
// function question_answering($question, $text){
//   if (question_classification($question) == "Date") {
//     generate_date_response($question, $text);
//   }

// }
//question_classification("What fowl grabs the spotlight after the Chinese Year of the Monkey ?")