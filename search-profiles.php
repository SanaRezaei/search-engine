<?php 
require( plugin_dir_path( __FILE__ ) . 'database.php');

function search_profiles($name, $metier) {
    $db = Database::connect();

    $users = get_users();
    $nameFound = false;
    $nameAndId = array();
    foreach($users as $user){
        // echo "<br>user id: " . $user->id;
        // echo "<br>user name: " . $user->user_login;
        // echo "<br>user first name: " . $user->user_firstname;
        // echo "<br>user last name: " . $user->user_lastname;
        // echo "<br>user display name: " . $user->display_name;
        // echo "<br>user email: " . $user->user_email;
        // echo "<br>user metier: " . $user->metier;
        // echo "<br> user meta: ";
        // $all_meta_for_user = get_user_meta( $user->id );
        // print_r( $all_meta_for_user );
        // echo "<br>";

        if ($user->user_firstname == $name ){
          $nameAndId[$user->id] = $user->user_firstname;
          $nameFound = true;
          // echo "<br>user found: " . $user->user_firstname . " " . $user->user_lastname; 
        }

    }
    foreach($nameAndId as $id => $name) {
      // echo "<br> searching metier for " . $name;
      $sql = "SELECT user_id,value FROM wp_bp_xprofile_data where value=? and user_id=?"; 
      $result = $db->prepare($sql); 
      $result->execute([$metier,$id]); 
      $result = $result->fetch(); 
      foreach($result as $resultItem) {
        if (!empty($nameAndId[$resultItem['user_id']])) {
          echo "<br>user found: " . $nameAndId[$resultItem['user_id']];
        }   
      }
    }
}

?>