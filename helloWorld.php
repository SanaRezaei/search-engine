<?php
/**
 * Hello World
 *
 * @package     HelloWorld
 * @author      Sana REZAEI
 *
 * @wordpress-plugin
 * Plugin Name: Hello World
 * Description: This plugin prints "Hello World" inside an admin page.
 * Text Domain: helloWorld
 * License:     GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

add_shortcode('hello_world','display_hello_world_page');
function display_hello_world_page() {
    echo 'Hello World!';
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

  