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

add_shortcode('profile_search','hello');
function hello() {
  html_form_code();
  if ($_POST){
    try{
        $name = $_POST['cf-name'];
        $metier= $_POST['cf-metier'];
        // $sql = "UPDATE List SET name = '{$_POST['name']}', color = '{$_POST['color']}' WHERE id={$_GET['id']}";
        // $db->query($sql);
        // header('Location: index.php');
        echo "received a search query with username: " . $name . " and metier: " . $metier;
    }
    catch(Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
  }
}

function profile_search_admin_menu() {
  add_menu_page(
        'Hello World',// page title
        'Hello World',// menu title
        'manage_options',// capability
        'hello-world',// menu slug
        'hello' // callback function
    );
}
add_action('admin_menu', 'profile_search_admin_menu');

function html_form_code() {
  echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
  echo '<p>';
  echo 'User name<br />';
  echo '<input type="text" name="cf-name" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["cf-name"] ) ? esc_attr( $_POST["cf-name"] ) : '' ) . '" size="40" />';
  echo '</p>';
  echo '<p>';
  echo 'Metier<br />';
  echo '<input type="text" name="cf-metier" value="' . ( isset( $_POST["cf-metier"] ) ? esc_attr( $_POST["cf-metier"] ) : '' ) . '" size="40" />';
  echo '</p>';
  echo '<p><input type="submit" name="cf-submitted" value="Search users"/></p>';
  echo '</form>';
}
?>

