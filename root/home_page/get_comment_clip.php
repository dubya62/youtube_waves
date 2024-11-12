

<?php
include '../../includes/scripts.php';

$conn = initDb();

$comment_id = $_GET['comment_id'];

echo getCommentClip($conn, $comment_id);

closeDb($conn);


?>
