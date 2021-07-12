<?php 
require( plugin_dir_path( __FILE__ ) . 'database.php');
require( plugin_dir_path( __FILE__ ) . 'display-result.php');

function search_profiles($name, $metier) { 
    $db = new Database();
    $cid = get_current_user_id();
    echo "<br>current user id: " . $cid;

    $users = get_users();
    $nameAndId = array();
    foreach($users as $user){
        echo "<br> log 2";
        if ($user->user_firstname == $name ){
          $nameAndId[$user->id] = $user->user_firstname;
        }
    }
    foreach($nameAndId as $id => $name) {
      // echo "<br> searching metier for name: " . $name . ' and id: ' . $id;
      $sql = "SELECT user_id,value FROM wp_bp_xprofile_data where value=? AND user_id=?"; 
      $result = $db->query($sql, [$metier,$id]);
      foreach($result as $resultItem) {
        echo "curr user id: " . $resultItem['user_id'];
        if (!empty($nameAndId[$resultItem['user_id']])) {
          displayUser($id); 
        }   
      }
    }
}

?>