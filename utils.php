
<?php
// print an array
function printArray($arr, $name) {
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