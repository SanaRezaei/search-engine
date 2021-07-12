<?php
require( plugin_dir_path( __FILE__ ) . 'database.php');

function displayUser($id) {
    $db = new Database();
    $user = $db->getCurrentUser();

    $url = 'https://www.lepopclub.fr/membres-3/sana/messages/compose/?r=kamil';
    echo '<div class="card" style="border: 5px solid gray; width:220px";>';
    echo '<div class="card-body">';
    echo '<div class="d-flex flex-column align-items-center text-center">';
    echo '<img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="" class="rounded-circle" width="150" style="  margin: auto;';
    echo 'display: block;">';
    echo '<div class="mt-3">';
    echo '<h4 style="text-align: center;">' . $user['display_name'] .  '</h4>';
    echo '<p class="text-secondary mb-1" style="text-align: center;">@johnny</p>';
    echo '<button class="GFG" style="  margin: auto;';
    echo 'display: block;"';
    echo 'onclick="window.location.href = "www.google.com";">';
    echo 'Message';
    echo '</button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
 
?>