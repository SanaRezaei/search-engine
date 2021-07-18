<?php 
require( plugin_dir_path( __FILE__ ) . 'database.php');
require( plugin_dir_path( __FILE__ ) . 'display-result.php');
require( plugin_dir_path( __FILE__ ) . 'utils.php');

/**
 * search profiles based on a given array of fields name and value
 * @param array $data input associative array contating fieldName->fieldValue
 */
function search_profiles($data, $strategy = null) { 
    printArray($data);
    if (empty($data)){
      echo "<br>data empty";
      return;
    }

    global $fields;
    global $fieldTypeMap;
    $results = array();
    foreach($fields as $field){
      echo "<br> field: " . $field;
      if (!empty($data[$field])){
        echo "<br>    checking " . $field . " with value " . $data[$field];
        if ($fieldTypeMap[$field] == FieldTypes::STANDARD){
          $res = searchStandardField($field, $data[$field]);
        }
        else {
          $res = searchCostumField($field, $data[$field]);
        }
        $results= array_unique(array_merge(array_keys($results), array_keys($res)));
      }
    }
    displayUsers($results);
}
/**
 * search function taking standard field (available in wp_users table)
 * @return array array of users matching the given field value (array of WP_User object)
 */
function searchStandardField($field_name, $field_value){
  $users = get_users();
  // array of matched user IDs
  $result = array();

  foreach($users as $user){
    if (isMatch($field_name, $field_value, $user->$field_name)){
      array_push($result, $user->id);
    }
  }
  return array_unique($result);
}

/**
 * search function taking standard field (available in wp_users table)
 * @return array array of users matching the given field value (array of WP_User object)
 */
function searchCostumField($field_name, $field_value){
  $db = new Database();
  $sql = "SELECT user_id,value FROM wp_bp_xprofile_data where field_id=?"; 
  global $costumFieldsId;
  echo "<br> costum field id: " . $costumFieldsId[$field_name];
  $rows = $db->query($sql, [$costumFieldsId[$field_name]]);
  // array of matched user IDs
  $result = array();

  foreach($rows as $row){
    if (isMatch($field_name, $field_value, $row['value'])){
      array_push($result, $row['user_id']);
    }
  }
  return array_unique($result);
}

/**
 * for field type of $field_name, checks if two input values can be considered as match
 * @return bool true if match, false otherwise
 */
function isMatch($field_name, $value1, $value2){
  global $thresholdMap;
  echo "<br> matching " . $field_name . " " . $value1 . " " . $value2;
  if ($thresholdMap[$field_name] < 100){
    similar_text(
      strtolower($value1),
      strtolower($value2), $score);
      return $score >= $thresholdMap[$field_name];
  }
  else {
    return ($value1 == $value2);
  }
}

?>