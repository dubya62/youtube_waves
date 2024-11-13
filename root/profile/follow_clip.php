<?php

include '../../includes/scripts.php';

// clip_id = the clip id
$clip_id = $_GET["clip_id"];

$conn = initDb();

// get the user id of the owner
$owner = getClipOwner($conn, $clip_id);

// get the user id of the current user
$user_id = getUserIdByCookie($conn);

// dislike
// if clip is disliked, undislike; otherwise dislike
if (checkIfFollowingUser($conn, $user_id, $owner)){
    unfollowUser($conn, $user_id, $owner);
    echo "-1";
} else {
    followUser($conn, $user_id, $owner);
    echo "1";
}


closeDb($conn);

?>
