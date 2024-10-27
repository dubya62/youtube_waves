<?php

include '../../includes/scripts.php';

$clip_id = $_GET["clip_id"];

$conn = initDb();


class CommentEntry{
    public $id;
    public $author;
}


// get all comments for this clip_id and echo them (in html format)

// get a single comment from saved file
function getComment($comment_id, $author_name){
    return "<div class='comment'>" . $author_name . " SAYS:<embed src=comments/" . $comment_id . "></embed></div>";
}

// get all comments from an array
function getAllComments($id_array){
    $result = "";
    foreach($id_array as $id){
        $result .= getComment($id->id, $id->author);
    }
    return $result;
}

// get an array of all comments for this clip
function getClipComments($conn, $clip_id){
    $stmt = $conn->prepare("SELECT c.id, u.username FROM comments c, users u WHERE c.author=u.id AND clip_id=?");

    $stmt->bind_param("s", $clip_id);

    $stmt->execute();

    $stmt->bind_result($result, $author);

    $res = [];
    while ($stmt->fetch()){
        $curr = new CommentEntry();
        $curr->id = $result;
        $curr->author = $author;
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
