<?php
include '../../includes/scripts.php';

if (!isset($_POST["clip_id"])) {
    exit("No clip ID specified.");
}

$clip_id = $_POST["clip_id"];
$conn = initDb();

// Function to delete the clip file and image from server
function deleteClipFiles($clip_id) {
    // File paths based on clip ID
    $audioPath = "../home_page/audios/" . $clip_id;
    $imagePath = "../home_page/images/" . $clip_id;

    // Delete audio file with any possible extension
    foreach (["mp3", "wav", "m4a", "ogg"] as $ext) {
        if (file_exists("$audioPath.$ext")) {
            unlink("$audioPath.$ext");
        }
    }

    // Delete image file with any possible extension
    foreach (["jpg", "png", "gif", "webp"] as $ext) {
        if (file_exists("$imagePath.$ext")) {
            unlink("$imagePath.$ext");
        }
    }
}

// Step 1: Delete associated comments for the clip (if you want cascading deletion)
$stmt = $conn->prepare("DELETE FROM comments WHERE clip_id = ?");
$stmt->bind_param("i", $clip_id);
$stmt->execute();
$stmt->close();

// Step 2: Delete the clip itself from the database
$stmt = $conn->prepare("DELETE FROM clips WHERE id = ?");
$stmt->bind_param("i", $clip_id);
$stmt->execute();
$stmt->close();

// Step 3: Delete associated files
deleteClipFiles($clip_id);

closeDb($conn);
echo "Clip deleted successfully";
?>
