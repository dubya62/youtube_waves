<?php
include '../../includes/scripts.php';

if (!isset($_POST["comment_id"])) {
    exit("No comment ID specified.");
}

$comment_id = $_POST["comment_id"];
$conn = initDb();

// Function to recursively delete a comment and its children
function deleteCommentAndChildren($conn, $comment_id) {
    // find all children comments
    $stmt = $conn->prepare("SELECT id FROM comments WHERE parent = ?");
    $stmt->bind_param("i", $comment_id);
    $stmt->execute();
    
    $stmt->bind_result($child_id);

    $child_ids = [];
    while ($stmt->fetch()) {
        $child_ids[] = $child_id; 
    }
    $stmt->close();

    // recursively delete all children comments
    foreach ($child_ids as $child_id) {
        deleteCommentAndChildren($conn, $child_id); 
    }

    // delete comment file 
    $commentFilePath = "comments/" . $comment_id;
    if (file_exists($commentFilePath)) {
        unlink($commentFilePath);
    }

    // delete comment from the database
    $deleteStmt = $conn->prepare("DELETE FROM comments WHERE id = ?");
    $deleteStmt->bind_param("i", $comment_id);
    $deleteStmt->execute();
    $deleteStmt->close();
}

// delete parent comment and all its children
deleteCommentAndChildren($conn, $comment_id);

closeDb($conn);
echo "Comment and its replies deleted successfully";
?>
