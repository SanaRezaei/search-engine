<?php 
require( plugin_dir_path( __FILE__ ) . 'database.php');
require( plugin_dir_path( __FILE__ ) . 'display-result.php');
require( plugin_dir_path( __FILE__ ) . 'utils.php');

/**
 * search profiles based on a given array of fields name and value
 * @param array $data input associative array contating fieldName->fieldValue
 */
function search_profiles($data) { 
    if (empty($data)){
      return;
    }
    $strategy = $data['search_strategy'];

    global $search_fields;
    global $fieldTypeMap;
    $results = array();
    foreach($search_fields as $field){
      if (!empty($data[$field])){
        if ($fieldTypeMap[$field] == FieldTypes::STANDARD){
          $res = searchStandardField($field, $data[$field]);
        }
        else {
          $res = searchCostumField($field, $data[$field]);
        }
        if (empty($results)){
          $results = $res;
        }
        else if ($strategy == SearchStrategy::And){
          $results = array_intersect(array_values($results), array_values($res));
        }
        else if ($strategy == SearchStrategy::Or){
          $results = array_unique(array_merge(array_values($results), array_values($res)));
        }
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
  $rows = $db->query($sql, [$costumFieldsId[$field_name]]);
  $result = array();

  foreach($rows as $row){
    if (isMatch($field_name, $field_value, $row['value'])){
      array_push($result, $row['user_id']);
    }
  }
  $result = array_unique($result);
  return $result;
}

/**
 * for field type of $field_name, checks if two input values can be considered as match
 * @return bool true if match, false otherwise
 */
function isMatch($field_name, $value1, $value2){
  global $thresholdMap;
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