<?php

function displayUser($id) {
    $db = new Database();
    $user = $db->getCurrentUser();
    echo "<b> user name: " . $user['user_name'];
    

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
    echo 'onclick="window.open(\'http://www.google.com\', \'_blank\');">';
    echo 'Message';
    echo '</button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
 
?>