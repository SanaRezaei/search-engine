<?php
/**
 * Lepppclub Search Engine
 *
 * @package     ProfileSearch
 * @author      Sana REZAEI
 *
 * @wordpress-plugin
 * Plugin Name: Profile Search for lepopclub users
 * Description: This plugin provides a costumized search for user profiles (short code: profile_search)
 * Text Domain: index
 * License:     GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

require_once( plugin_dir_path( __FILE__ ) . 'search-profiles.php');
require_once( plugin_dir_path( __FILE__ ) . 'utils.php');

add_shortcode('profile_search','search_profile_main');
function search_profile_main() {
  html_form_code();
  global $METIERS;
  
  
  // echo "<br>" . do_shortcode( '[youzify_account_avatar]' );
  if ($_POST){
    $searchType = SearchStrategy::And;
    if ($_POST['radio-search-type'] == 'No'){
      $searchType = SearchStrategy::Or;
    }
    $data = array(
      "first_name" => $_POST['cf_first_name'],
      "last_name" => $_POST['cf_last_name'],
      "metier" => $_POST['cf_metier'],
      "user_email" => $_POST['cf_user_email'],
      "user_login" => $_POST['cf_user_login'],
      "display_name" => $_POST['cf_display_name'],
      "telephone" => $_POST['cf_telephone'],
      "search_strategy" => $searchType,
    );
    try{
        search_profiles($data);
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
  echo '<div id="search_form_div" style="border: 5px outset gray; background-color: lightblue; text-align: left;">';
  echo '<h2>Search Profiles</h2>';
  echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
  // user first name label and field
  echo '<p>';
  echo 'First name<br />';
  echo '<input type="text" name="cf_first_name" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["cf_first_name"] ) ? esc_attr( $_POST["cf_first_name"] ) : '' ) . '" size="20" />';
  echo '</p>';
  // user last name label and field
  echo '<p>';
  echo 'Last name<br />';
  echo '<input type="text" name="cf_last_name" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["cf_last_name"] ) ? esc_attr( $_POST["cf_last_name"] ) : '' ) . '" size="20" />';
  echo '</p>';
  // user display name label and field
  echo '<p>';
  echo 'Display name<br />';
  echo '<input type="text" name="cf_display_name" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["cf_display_name"] ) ? esc_attr( $_POST["cf_display_name"] ) : '' ) . '" size="20" />';
  echo '</p>';
  // user email label and field
  echo '<p>';
  echo 'Email<br />';
  echo '<input type="email" name="cf_user_email" placeholder="john.doe@example.com" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="' . ( isset( $_POST["cf_user_email"] ) ? esc_attr( $_POST["cf_user_email"] ) : '' ) . '" size="30" />';
  echo '</p>';
  // user telephone number label and field
  echo '<p>';
  echo 'Telephone number<br />';
  echo '<input type="text" name="cf_telephone" placeholder="0102030405" pattern="[0-9]{10}" value="' . ( isset( $_POST["cf_telephone"] ) ? esc_attr( $_POST["cf_telephone"] ) : '' ) . '" size="30" />';
  echo '</p>';
  // user login label and field
  echo '<p>';
  echo 'user login (id)<br />';
  echo '<input type="text" name="cf_user_login" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["cf_user_login"] ) ? esc_attr( $_POST["cf_user_login"] ) : '' ) . '" size="30" />';
  echo '</p>';
  // dropdown list of metiers
  echo '<p>';
  echo 'Metier<br />';
  echo '<select id="cf_metier" name="cf_metier">';
  echo '<option disabled selected value> -- select an option -- </option>';
  foreach($METIERS as $value){
    echo '<option value=' . $value . '>' . $value . '</option>';
  }
  echo '</select>';
  echo '</p>';
  // search method
  echo '<br>';
  echo '<div>';
  echo '<p>Return results matching all (non-empty) fields?</p>';
  echo '<label>';
  echo '<input type="radio" name="radio-search-type" value="Yes" checked/>';
  echo 'Yes ';
  echo '</label>';
  echo '<label>';
  echo '<input type="radio" name="radio-search-type" value="No" />';
  echo 'No';
  echo '</label>';
  echo '</div>';
  echo '';
  // submit button
  echo "<br></br>";
  echo '<p><input type="submit" name="cf_submitted" value="Search users" style="text-align: center;"/></p>';
  echo '</form>';
  echo '</div>';
}
?>