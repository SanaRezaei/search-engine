<?php 
require_once( plugin_dir_path( __FILE__ ) . 'database.php');
require_once( plugin_dir_path( __FILE__ ) . 'display-result.php');
require_once( plugin_dir_path( __FILE__ ) . 'utils.php');
echo "<style>";
include_once('style.css');
echo "<\style>";

class ProfileSearch {

  private $data;

  function __construct($data) {
    $this->data = $data;
  }
  /**
   * search profiles based on a given array of fields name and value
   * @param array $data input associative array contating fieldName->fieldValue
   */
  function execute() { 
      if (!$this->atLeastOneFieldSelected($this->data)){
        return;
      }
      $strategy = $this->data['search_strategy'];

      global $search_fields;
      global $fieldTypeMap;
      $results = array();
      foreach($search_fields as $field){
        if (!empty($this->data[$field])){
          $fieldResult = array();
          if ($fieldTypeMap[$field] == FieldTypes::STANDARD){
            $fieldResult = $this->searchStandardField($field, $this->data[$field]);
          }
          else {
            $fieldResult = $this->searchCostumField($field, $this->data[$field]);
          }
          if (empty($results) && !empty($fieldResult)){
              $results = $fieldResult;
          }
          else if ($strategy == SearchStrategy::And){
            foreach ($fieldResult as $id => $score){
              if (array_key_exists($id, $results)) {
                $results[$id] = $results[$id] + $score;
              }
            }
          }
          else if ($strategy == SearchStrategy::Or){
            foreach ($fieldResult as $id => $score){
              if (array_key_exists($id, $results)) {
                $results[$id] = $results[$id] + $score;
              }
              else {
                $results[$id] = $fieldResult[$id];
              }
            }
          }
        }
      }
      arsort($results);
      displayUsers($results);
  }
  private function atLeastOneFieldSelected(array $data): bool {
    global $search_fields;
    foreach($search_fields as $field){
      if (!empty($data[$field])) 
        return true;
    }
    return false;
  }

  /**
   * search function taking standard field (available in wp_users table)
   * @return array array of users matching the given field value (array of WP_User object)
   */
  private function searchStandardField(string $field_name, $field_value){
    $users = get_users();
    // array of matched user IDs
    $result = array();

    foreach($users as $user){
      $matchResult = $this->isMatch($field_name, $field_value, $user->$field_name);
      if ($matchResult != -1){
        $result[$user->id] = $matchResult;
      }
    }
    return array_unique($result);
  }

  /**
   * search function taking standard field (available in wp_users table)
   * @return array array of users matching the given field value (array of WP_User object)
   */
  private function searchCostumField($field_name, $field_value){
    global $wpdb;
    global $costumFieldsId;
    $sql = "SELECT user_id,value FROM " . $wpdb->prefix . "bp_xprofile_data where field_id='" . $costumFieldsId[$field_name] . "'"; 
    $rows = $wpdb->get_results($sql, ARRAY_A);
    $result = array();
    foreach($rows as $row){
      $matchResult = $this->isMatch($field_name, $field_value, $row['value']);
      if ($matchResult != -1){
        $result[$row['user_id']] = $matchResult;
      }
    }
    $result = array_unique($result);
    return $result;
  }

  /**
   * for field type of $field_name, checks if two input values can be considered as match
   * @return integer -1 if not matched, score if matched
   */
  private function isMatch($field_name, $value1, $value2){
    global $thresholdMap;
    $res = -1;
    if ($thresholdMap[$field_name] < 100){
      similar_text(
        strtolower($value1),
        strtolower($value2), $score);
        if ($score >= $thresholdMap[$field_name]){
          $res = $score;
        }
    }
    else if ($value1 == $value2) {
      $res = 100;
    }
    return $res;
  }

}

function printBuddyPressXProfileData() {
  global $wpdb;
  $table_name = $wpdb->prefix . 'bp_xprofile_data';
  $sql = "SELECT field_id,user_id,value FROM $table_name";
  $result = $wpdb->get_results($sql, ARRAY_A);
  foreach($result as $row){
    printArray($row);
  }
}

?>