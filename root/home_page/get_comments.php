<?php

include '../../includes/scripts.php';

$clip_id = $_GET["clip_id"];

$conn = initDb();


class CommentEntry{
    public $id;
    public $author;
    public $parent;
}


// get all comments for this clip_id and echo them (in html format)

// get a single comment from saved file
// function getComment($comment_id, $author_name, $is_child){
//     if ($is_child){
//         return "<div class='comment' id='comment-" . $comment_id . "'><div class='replyText'>" . $author_name . " REPLIED WITH:<iframe class='comment-text' src='comments/" . $comment_id . "'></iframe><button class='reply-button' onclick='toggleReplyTextbox(\\\"" . $comment_id . "\\\")'>Reply</button></div></div>";
//     } else {
//         return "<div class='comment' id='comment-" . $comment_id . "'><div>" . $author_name . " SAYS:<iframe class='comment-text' src='comments/" . $comment_id . "'></iframe><button class='reply-button' onclick='toggleReplyTextbox(\"" . $comment_id . "\")'>Reply</button></div></div>";
//     }
// }

// get a single comment from saved file with like, dislike, and reply button for the comments 
function getComment($comment_id, $author_name, $is_child) {
    
    $likeButton = "<button class='like-button' onclick='incrementLikeComment($comment_id)'>Like</button>";
    $likeCounter = "<span id='comment-like-counter-$comment_id' class='comment-like-counter'>0</span>";
    
    $dislikeButton = "<button class='dislike-button' onclick='incrementDislikeComment($comment_id)'>Dislike</button>";
    $dislikeCounter = "<span id='comment-dislike-counter-$comment_id' class='comment-dislike-counter'>0</span>";

    
    $replyButton = "<button class='reply-button' onclick='toggleReplyTextbox(\"$comment_id\")'>Reply</button>";

    
    if ($is_child) {
        return "<div class='comment' id='comment-$comment_id'>
                    <div class='replyText
                        $author_name REPLIED WITH:
                        <iframe class='comment-text' src='comments/$comment_id'></iframe>
                        $likeButton $likeCounter
                        $dislikeButton $dislikeCounter
                        $replyButton
                    </div>
                </div>";
    } else {
        return "<div class='comment' id='comment-$comment_id'>
                    <div>
                        $author_name SAYS:
                        <iframe class='comment-text' src='comments/$comment_id'></iframe>
                        $likeButton $likeCounter
                        $dislikeButton $dislikeCounter
                        $replyButton
                    </div>
                </div>";
    }
}



// get all comments from an array
function getAllComments($id_array){
    $result = "";
    $fix_children = "";
    foreach($id_array as $id){
        if (!$id->parent){
            $result .= getComment($id->id, $id->author, 0);
        } else {
            // this is a reply. add it to the script
            $fix_children .= "document.getElementById('comment-" . $id->parent . "').innerHTML += \"" . getComment($id->id, $id->author, 1) . "\"; ";
        }
    }
    // append a script that puts all of the replies at the end
    $result .= "<script>" . $fix_children . "</script>";
    return $result;
}

// get an array of all comments for this clip
function getClipComments($conn, $clip_id){
    $stmt = $conn->prepare("SELECT c.id, u.username, c.parent FROM comments c, users u WHERE c.author=u.id AND clip_id=? ORDER BY c.id");

    $stmt->bind_param("s", $clip_id);

    $stmt->execute();

    $stmt->bind_result($result, $author, $parent);

    $res = [];
    while ($stmt->fetch()){
        $curr = new CommentEntry();
        $curr->id = $result;
        $curr->author = $author;
        $curr->parent = $parent;
        $res[] = $curr;
        
    }

    return $res;
}

function getClipCommentsAsHTML($conn, $clip_id){
    $comment_ids = getClipComments($conn, $clip_id);
    return getAllComments($comment_ids);
}


$result = getClipCommentsAsHTML($conn, $clip_id);
echo $result;


closeDb($conn);

?>
