<?php

function displayUsers($ids){
    foreach($ids as $id) {
        displayUser($id); 
    }
}

function displayUser($id) {
    $db = new Database();
    $user = $db->getCurrentUser();
    $targetUser = $db->getUserById($id);
    $targetUserId = $targetUser[0]['user_login'];
    $metier = $db->getMetierByUserId($id);

    $url = 'https://www.lepopclub.fr/membres-3/' . $user[0][1] . '/messages/compose/?r=' . $targetUserId;
    echo '<div class="card" style="border: 5px solid gray; width:220px";>';
    echo '<div class="card-body">';
    echo '<div class="d-flex flex-column align-items-center text-center">';
    echo '<img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="" class="rounded-circle" width="150" style="  margin: auto;';
    echo 'display: block;">';
    echo '<div class="mt-3">';
    echo '<h4 style="text-align: center;">' . $user['display_name'] .  '</h4>';
    echo '<p class="text-secondary mb-1" style="text-align: center;">@' . $targetUserId . '</p>';
    echo '<p class="text-secondary mb-1" style="text-align: center;">' . $metier[0] . '</p>';
    echo '<button class="GFG" style="  margin: auto;';
    echo 'display: block;"';
    echo 'onclick="window.open(\'' . $url . '\',\'_blank\');">';
    echo 'Message';
    echo '</button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
 
?>