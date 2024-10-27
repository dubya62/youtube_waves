<?php
include '../../includes/scripts.php';

$clip_id = $_POST["clip_id"];
$comment = $_POST["comment"];

// create the proper database entry for the comment and return its id
function createCommentDatabaseEntry($conn, $clip_id){
    // get the user id to set as author
    $user_id = getUserIdByCookie($conn);

    // since we are commenting, increase user sentiment to this clip
    addUserSentimentToClip($conn, $user_id, $clip_id, 3);

    $stmt = $conn->prepare("INSERT INTO comments (author, clip_id, parent) VALUES (?, ?, null)");

    $stmt->bind_param("ss", $user_id, $clip_id);

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

$comment_id = createCommentDatabaseEntry($conn, $clip_id);
createCommentFile($comment_id, $comment);

closeDb($conn);


?>
