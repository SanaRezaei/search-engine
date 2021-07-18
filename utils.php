
<?php

$SIMILARITY_THRESHOLD = 60;
$thresholdMap = array(
  "user_login" => 100,
  "user_pass" => 100,
  "user_email" => 100,
  "user_registered" => 100,
  "display_name" => 70,
  "first_name" => 70,
  "last_name" => 70,
  "metier" => 70,
);

// print an array
function printArray($arr, $name='') {
  echo "<br><strong> array " . $name . ": </strong>";
  foreach( $arr as $key => $value ){
    echo "<br>" . $key."\t=>\t".$value;
  }
}

// And -> result contains data that match all search fields (name, metier, etc)
// Or -> result contains data that match any search field (name or metier or etc)
abstract class SearchStrategy
{
    const And = 0;
    const Or = 1;
    // etc.
}

// list of available metiers to choose from
$METIERS = array(
    "etudiant" => "Etudiant",
    "web-dev" => "Développeur web",
    "back-dev" => "Développeur back-end",
    "autre" => "Autre",
);

?>