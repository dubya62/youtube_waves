<?php
include '../../includes/scripts.php';

$clip_id = $_POST["clip_id"];
$comment = $_POST["comment"];
$parent = $_POST["parent"];

// create the proper database entry for the comment and return its id
function createCommentDatabaseEntry($conn, $clip_id, $parent){
    // get the user id to set as author
    $user_id = getUserIdByCookie($conn);

    // since we are commenting, increase user sentiment to this clip
    addUserSentimentToClip($conn, $user_id, $clip_id, 3);

    if ($parent == "-1"){
        $stmt = $conn->prepare("INSERT INTO comments (author, clip_id, parent) VALUES (?, ?, null)");
        $stmt->bind_param("ss", $user_id, $clip_id);
    } else {
        $stmt = $conn->prepare("INSERT INTO comments (author, clip_id, parent) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $user_id, $clip_id, $parent);
    }


    $stmt->execute();

    return mysqli_insert_id($conn);
}

function replaceTimestamps($comment, $clip_id){
    // look through the comment for something in the form \d+:\d\d
    // underline and change color and make onclick skip to that point in the audio clip
    $pattern = "/\d+:\d{0, 2}/i";
    //$comment = preg_replace($pattern, "<strong onclick='jumpToTime(\"\0\", " . $clip_id . ")'>\0</strong>", $comment);
    $comment = preg_replace($pattern, "\0 stuff", $comment);


    return $comment;
}

// create a file with the comment's data in it
function createCommentFile($comment_id, $comment, $clip_id){
    $the_file = fopen("comments/" . $comment_id, "w") or die ("Could not save comment!");

    $comment = replaceTimestamps($comment, $clip_id);

    echo "Created comment " . $comment;

    fwrite($the_file, $comment);
    fclose($the_file);
}


$conn = initDb();

$comment_id = createCommentDatabaseEntry($conn, $clip_id, $parent);
createCommentFile($comment_id, $comment, $clip_id);

closeDb($conn);



?>
