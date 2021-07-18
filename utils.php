
<?php

$thresholdMap = array(
  "first_name" => 70,
  "last_name" => 70,
  "display_name" => 70,
  "user_email" => 100,
  "telephone" => 100,
  "user_login" => 100,
  "metier" => 70,
);

$fieldTypeMap = array(
  "first_name" => FieldTypes::STANDARD,
  "last_name" => FieldTypes::STANDARD,
  "display_name" => FieldTypes::STANDARD,
  "user_email" => FieldTypes::STANDARD,
  "telephone" => FieldTypes::COSTUM,
  "user_login" => FieldTypes::STANDARD,
  "metier" => FieldTypes::COSTUM,
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

abstract class FieldTypes
{
    const STANDARD = 0;
    const COSTUM = 1;
    // etc.
}

// list of available metiers in dropdown list
$METIERS = array(
  "Etudiant",
  "Développeur web",
  "Développeur back-end",
  "Autre",
);

// list of fields in search form
$fields = array(
  "first_name",
  "last_name",
  "metier",
  "user_email",
  "user_login",
  "display_name",
  "telephone",
);

// field id of costum field in wp_bp_xprofile_data
$costumFieldsId = array(
  "metier" => 4,
  "telephone" => 5,
);

?>