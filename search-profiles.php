<?php 
require( plugin_dir_path( __FILE__ ) . 'database.php');
require( plugin_dir_path( __FILE__ ) . 'display-result.php');
require( plugin_dir_path( __FILE__ ) . 'utils.php');

$metier_field_id = 4;

function search_profiles($name, $metier, $strategy = null) { 
    if ($strategy == null){
      $strategy = SearchStrategy::Or;
    }

    
    // returns array of WP_User objects
    // available properties:
    //  user_login, user_pass, user_nicename, user_email, user_url, 
    //  user_registered, user_activation_key, user_status, display_name, spam
    $nameResult = searchStandardField("first_name", $name);
    printArray($nameResult);
    // get metier result
    global $metier_field_id;
    $db = new Database();
    $sql = "SELECT user_id,value FROM wp_bp_xprofile_data where field_id=?"; 
    $rows = $db->query($sql, [$metier_field_id]);
    $metierResult = array();
    global $thresholdMap;
    foreach($rows as $row){
      similar_text(
        strtolower($metier),
        strtolower($row['value']), $scoreMetier);
      // echo "<br> metier score for  " . $metier . " and " . $row['value'] . " is: " . $score;
      if ($scoreMetier > $thresholdMap['metier'] ){
        $metierResult[$row['user_id']]=strtolower($row['value']);
      }
    }

    if ($strategy == SearchStrategy::And){
      $nameAndMetier = array_intersect(array_keys($nameResult), array_keys($metierResult));
      displayUsers($nameAndMetier);
    }
    else if ($strategy == SearchStrategy::Or){
      $nameOrMetier = array_unique(array_merge(array_keys($nameResult), array_keys($metierResult)));
      displayUsers($nameOrMetier);
    }
}
/**
 * search function taking standard field (available in wp_users table)
 * @return array array of users matching the given field value (array of WP_User object)
 */
function searchStandardField($field_name, $field_value){
  $users = get_users();
  $result = array();
  // for certain fields we accept a threshold less than 100
  // (e.g., name, family name)
  // for other fields, the exact match will be checked (e.g., telephone number)
  global $thresholdMap;

  foreach($users as $user){
    if ($thresholdMap[$field_name] < 100){
      similar_text(
        strtolower($field_value),
        strtolower($user->$field_name), $score);
        if ($score >= $thresholdMap[$field_name] ){
          $result[$user->id] = strtolower($user->$field_name);
        }
    }
    else if ($user->$field_name == $field_value){
      $result[$user->id] = $user->$field_name;
    }
  }
  return $result;
}

?>