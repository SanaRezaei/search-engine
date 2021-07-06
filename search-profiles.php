<?php 
echo ".....hello.....";
$name = $_POST['name'];


function search_profiles($name, $metier) {
    echo "Searching profiles..";
    $name = $_POST['name'];
    echo "--- input name: " . $name;
    $name = $_POST['metier'];
    echo "--- input name: " . $metier;
    $users = get_users();
    echo "<br>users size: " . count($users);
    $found = false;
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
          $found = true;
          echo "<br>user found: " . $user->user_firstname . " " . $user->user_lastname; 
        }
    }
    if ($found == true) echo "<br>user found";
    else echo "<br> user NOT found";
    header('Location: helloWorld.php');
}

search_profiles($name);