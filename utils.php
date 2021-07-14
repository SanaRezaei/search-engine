
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

?>