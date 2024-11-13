<?php
include '../../includes/scripts.php';

$clip_id = $_POST["clip_id"];
$comment = $_POST["comment"];
$parent = $_POST["parent"];
$imageURL = null; // Initialize the image URL

$conn = initDb();

// Function to create a database entry for the comment
function createCommentDatabaseEntry($conn, $clip_id, $parent){
    $user_id = getUserIdByCookie($conn);
    addUserSentimentToClip($conn, $user_id, $clip_id, 3);

    if ($parent == "-1") {
        $stmt = $conn->prepare("INSERT INTO comments (author, clip_id, parent) VALUES (?, ?, null)");
        $stmt->bind_param("ss", $user_id, $clip_id);
    } else {
        $stmt = $conn->prepare("INSERT INTO comments (author, clip_id, parent) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $user_id, $clip_id, $parent);
    }
    $stmt->execute();

    return mysqli_insert_id($conn);
}

// Save the comment text
$comment_id = createCommentDatabaseEntry($conn, $clip_id, $parent);
$commentFilePath = "comments/" . $comment_id;
file_put_contents($commentFilePath, $comment);

// Handle image upload
if (isset($_FILES["comment_image"]) && $_FILES["comment_image"]["error"] === UPLOAD_ERR_OK) {
    $imageTmpPath = $_FILES["comment_image"]["tmp_name"];
    $imageExtension = strtolower(pathinfo($_FILES["comment_image"]["name"], PATHINFO_EXTENSION));
    $imageFileName = "comments/images/" . $comment_id . "." . $imageExtension;

    // Move uploaded file to the comments/images folder
    if (move_uploaded_file($imageTmpPath, $imageFileName)) {
        $imageURL = $imageFileName; // Set the image URL to be returned
    } else {
        echo json_encode(["error" => "Failed to save image"]);
        exit;
    }
}

closeDb($conn);

// Return comment text and image URL to client as JSON
echo json_encode([
    "message" => "Comment with image uploaded successfully",
    "imageURL" => $imageURL
]);
?>
