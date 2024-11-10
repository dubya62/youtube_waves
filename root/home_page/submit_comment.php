<?php
include '../../includes/scripts.php';

$clip_id = $_POST["clip_id"];
$comment = $_POST["comment"];
$parent = $_POST["parent"];
$imagePath = null;

if (isset($_FILES["comment-image"]) && $_FILES["comment-image"]["error"] === UPLOAD_ERR_OK) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $fileType = mime_content_type($_FILES["comment-image"]["tmp_name"]);

    if (in_array($fileType, $allowedTypes)) {
        $imageExt = pathinfo($_FILES["comment-image"]["name"], PATHINFO_EXTENSION);
        $imageName = uniqid() . "." . $imageExt;
        $imageUploadPath = "comments/images/" . $imageName;

        if (move_uploaded_file($_FILES["comment-image"]["tmp_name"], $imageUploadPath)) {
            $imagePath = $imageUploadPath;
        } else {
            die("Error uploading image.");
        }
    } else {
        die("Invalid image type.");
    }
}

if ($imagePath) {
    $comment .= "<br><img src='" . htmlspecialchars($imagePath, ENT_QUOTES) . "' alt='Uploaded image' style='max-width:100%; border-radius:8px;'>";
}

// Existing functions to handle database entries and file storage
function createCommentDatabaseEntry($conn, $clip_id, $parent){
    $user_id = getUserIdByCookie($conn);
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
