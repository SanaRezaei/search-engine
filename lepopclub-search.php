<?php
/**
 * Lepopclub Search Engine
 *
 * @package     ProfileSearch
 * @author      Sana REZAEI
 *
 * @wordpress-plugin
 * Plugin Name: Profile Search for lepopclub
 * Description: This plugin prints "Hello World" inside an admin page.
 * Text Domain: index
 * License:     GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */
include "search-profiles.php";

add_shortcode('profile_search','search_profile_main');
function search_profile_main() {
  html_form_code();
  global $METIERS;
  // echo "<br>" . do_shortcode( '[youzify_account_avatar]' );
  if ($_POST){
    try{
        $name = $_POST['cf-name'];
        $metier= $METIERS[$_POST['cf-metier']];
        search_profiles($name, $metier);
    }
    catch(Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
  }
}

function profile_search_admin_menu() {
  add_menu_page(
        'Custom Profile Search',// page title
        'Profile Search',// menu title
        'manage_options',// capability
        'profile-search',// menu slug
        'search_profile_main' // callback function
    );
}
add_action('admin_menu', 'profile_search_admin_menu');

function html_form_code() {
  global $METIERS;

  echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
  echo '<p>';
  // user name label and field
  echo 'First name<br />';
  echo '<input type="text" name="cf-name" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["cf-name"] ) ? esc_attr( $_POST["cf-name"] ) : '' ) . '" size="20" />';
  echo '</p>';
  echo '<p>';
  // user last name label and field
  echo 'Last name<br />';
  echo '<input type="text" name="cf-lastName" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["cf-lastName"] ) ? esc_attr( $_POST["cf-lastName"] ) : '' ) . '" size="20" />';
  echo '</p>';
  // user email label and field
  echo '<p>';
  echo 'Email<br />';
  echo '<input type="text" name="cf-email" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["cf-email"] ) ? esc_attr( $_POST["cf-email"] ) : '' ) . '" size="30" />';
  echo '</p>';
  echo '<p>';
  // dropdown list of metiers
  echo 'Metier<br />';
  echo '<select id="cf-metier" name="cf-metier">';
  foreach($METIERS as $key => $value){
    echo '<option value=' . $key . '>' . $value . '</option>';
  }
  echo '</select>';
  echo '</p>';
  // submit button
  echo '<p><input type="submit" name="cf-submitted" value="Search users"/></p>';
  echo '</form>';
}

?>

