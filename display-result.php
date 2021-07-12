<?php
function displayUser($id) {
    $db = Database::connect();
    $sql = "SELECT * FROM wp_users where ID=?"; 
    $result = $db->prepare($sql); 
    $result->execute([$id]); 
    $result = $result->fetch(); 

    $url = 'https://www.lepopclub.fr/membres-3/sana/messages/compose/?r=kamil';
    echo '<div class="card" style="border: 5px solid gray; width:220px";>';
    echo '<div class="card-body">';
    echo '<div class="d-flex flex-column align-items-center text-center">';
    echo '<img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt=' . $id . ' class="rounded-circle" width="150" style="  margin: auto;';
    echo 'display: block;">';
    echo '<div class="mt-3">';
    echo '<h4 style="text-align: center;">' . $result['user_nicename'] . '</h4>';
    echo '<p class="text-secondary mb-1" style="text-align: center;">@' . $result['display_name'] . '</p>';
    echo '<button class="btn btn-outline-primary onclick="window.open("' . $url . '","_blank")" style="  margin: auto;';    echo 'display: block;">Message</button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
 
?>