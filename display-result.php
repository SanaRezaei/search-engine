<?php
function displayUsers($ids){
    foreach($ids as $id) {
        displayUser($id); 
    }
}

function displayUser($id) {
    $db = new Database();
    $currentUser = $db->getCurrentUser();
    $targetUser = $db->getUserById($id);
    $targetUserId = $targetUser[0]['user_login'];
    $metier = $db->getMetierByUserId($id);
    $avatarUrl = get_avatar_url($targetUserId);

    $url = 'https://www.lepopclub.fr/membres-3/' . $currentUser[0][1] . '/messages/compose/?r=' . $targetUserId;
    echo '<br>';
    echo '<div class="card" style="border: 5px solid gray; width:220px";>';
    echo '<div class="card-body">';
    echo '<div class="d-flex flex-column align-items-center text-center">';
    echo '<img src="' . $avatarUrl . '" alt="" class="rounded-circle" width="150" style="  margin: auto;';
    echo 'display: block;">';
    echo '<div class="mt-3">';
    echo '<h3 style="text-align: center;">' . $targetUser[0]['display_name'] .  '</h3>';
    echo '<p class="text-secondary mb-1" style="text-align: center; color: blue;">@' . $targetUserId . '</p>';
    echo '<p id="user_id_link" class="text-secondary mb-1" style="text-align: center;">' . $metier . '</p>';
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