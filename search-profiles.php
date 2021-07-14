<?php 
require( plugin_dir_path( __FILE__ ) . 'database.php');
require( plugin_dir_path( __FILE__ ) . 'display-result.php');
require( plugin_dir_path( __FILE__ ) . 'utils.php');

function search_profiles($name, $metier, $strategy = null) { 
    if ($strategy == null){
      $strategy = SearchStrategy::Or;
    }

    $db = new Database();
    $users = get_users();
    $nameResult = array();
    global $SIMILARITY_THRESHOLD;
    foreach($users as $user){
      similar_text(
        strtolower($name),
        strtolower($user->user_firstname), $scoreName);
        // echo "<br> user score for  " . $name . " and " . $user->user_firstname. " is: " . $score;
        if ($scoreName > $SIMILARITY_THRESHOLD ){
          $nameResult[$user->id] = strtolower($user->user_firstname);
        }
    }
  
    // get metier result
    $sql = "SELECT user_id,value FROM wp_bp_xprofile_data"; 
    $rows = $db->query($sql, [strtolower($metier)]);
    $metierResult = array();
    foreach($rows as $row){
      similar_text(
        strtolower($metier),
        strtolower($row['value']), $scoreMetier);
      // echo "<br> metier score for  " . $metier . " and " . $row['value'] . " is: " . $score;
      if ($scoreMetier > $SIMILARITY_THRESHOLD ){
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

?>