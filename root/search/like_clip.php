<?php

include '../../includes/scripts.php';

// action of 1 = like
// action of 0 = dislike
// clip_id = the clip id
$action = $_GET["action"];
$clip_id = $_GET["clip_id"];

$conn = initDb();

if ($action == 0){
    // dislike
    // if clip is disliked, undislike; otherwise dislike
    if (isDislikedByCookie($conn, $clip_id)){
        unDislikeClip($conn, $clip_id);
        echo "-0";
    } else {
        dislikeClip($conn, $clip_id);
        echo "0";
    }

} else if ($action == 1){
    // like
    // if clip is liked, unlike; otherwise like
    if (isLikedByCookie($conn, $clip_id)){
        unLikeClip($conn, $clip_id);
        echo "-1";
    } else {
        likeClip($conn, $clip_id);
        echo "1";
    }
}

closeDb($conn);

?>
