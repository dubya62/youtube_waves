<?php 

include '../../includes/scripts.php';

// action of 1 = like 
// action of 0 = dislike 
// comment_id = the comment id 
$action = $_GET["action"];
$comment_id = $_GET["comment_id"];

$conn = initDB();

if ($action == 0) {
    // dislike
    // if comment is disliked, undislike; otherwise dislike 
    if (isCommentDislikedByCookie($conn, $comment_id)) {
        unDislikeComment($conn, $comment_id);
        echo "-0";
    }
    else {
        dislikeComment($conn, $comment_id);
        echo "0";
    }
}
else if ($action == 1) {
    // like 
    // if comment is liked, unlike; otherwise like 
    if (isCommentLikedByCookie($conn, $comment_id)) {
        unLikeComment($conn, $comment_id);
        echo "-1";
    }
    else {
        likeComment($conn, $comment_id);
        echo "1";
    }
}

closeDb($conn);

?>
