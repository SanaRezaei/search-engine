
<?php
function printArray($arr, $name) {
  echo "<br><strong> array " . $name . ": </strong>";
  foreach( $arr as $key => $value ){
    echo "<br>" . $key."\t=>\t".$value;
  }
}

abstract class SearchStrategy
{
    const And = 0;
    const Or = 1;
    // etc.
}

$METIERS = array(
    "etudiant" => "Etudiant",
    "web-dev" => "Développeur web",
    "back-dev" => "Développeur back-end",
    "autre" => "Autre",
);

?>