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


// create a file with the comment's data in it
function createCommentFile($comment_id, $comment){
    $the_file = fopen("comments/" . $comment_id, "w") or die ("Could not save comment!");
    fwrite($the_file, $comment);
    fclose($the_file);
}


$conn = initDb();

$comment_id = createCommentDatabaseEntry($conn, $clip_id, $parent);
createCommentFile($comment_id, $comment);

closeDb($conn);



?>
