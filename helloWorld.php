<?php
/**
 * Hello World
 *
 * @package     ProfileSearch
 * @author      Sana REZAEI
 *
 * @wordpress-plugin
 * Plugin Name: Profile Search for lepopclub
 * Description: This plugin prints "Hello World" inside an admin page.
 * Text Domain: helloWorld
 * License:     GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

add_shortcode('profile_search','display_hello_world_page');
function display_hello_world_page() {
    echo 'Profile Search... ...';
    get_search_form();
    get_users();
    $blogusers = get_users( 'role=subscriber' );
    // Array of stdClass objects.
    foreach ( $blogusers as $user ) {
      echo '<span>' . esc_html( $user->Name ) . '</span>';
    }

    $users = get_users( );
    echo "<br>users size: " . count($users);
    foreach($users as $user){
        echo "<br>user id: " . $user->id;
        echo "<br>user name: " . $user->user_login;
        echo "<br>user first name: " . $user->user_firstname;
        echo "<br>user last name: " . $user->user_lastname;
        echo "<br>user display name: " . $user->display_name;
        echo "<br>user email: " . $user->user_email;
        echo "<br>user metier: " . $user->metier;
        echo "<br> user meta: ";
        // $all_meta_for_user = get_user_meta( $user->id );
        // print_r( $all_meta_for_user );
        echo "<br>";
    }
}
function hello_world_admin_menu() {
  add_menu_page(
        'Hello World',// page title
        'Hello World',// menu title
        'manage_options',// capability
        'hello-world',// menu slug
        'display_hello_world_page' // callback function
    );
}
add_action('admin_menu', 'hello_world_admin_menu');
// add_search_form2() {
//   get_search_form();
// }

  