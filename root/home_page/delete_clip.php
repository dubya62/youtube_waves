<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../../includes/scripts.php';

if (!isset($_POST["clip_id"])) {
    exit("No clip ID specified.");
}

$clip_id = $_POST["clip_id"];
$conn = initDb();

// Function to delete the clip files from the server
function deleteClipFiles($clip_id) {
    $audioPath = "../home_page/audios/" . $clip_id;
    $imagePath = "../home_page/images/" . $clip_id;

    foreach (["mp3", "wav", "m4a", "ogg"] as $ext) {
        if (file_exists("$audioPath.$ext")) {
            unlink("$audioPath.$ext");
        }
    }

    foreach (["jpg", "png", "gif", "webp"] as $ext) {
        if (file_exists("$imagePath.$ext")) {
            unlink("$imagePath.$ext");
        }
    }
}

try {
    $conn->begin_transaction();

    // deleted related tags in clip_tag table 
    $stmt = $conn->prepare("DELETE FROM clip_tags WHERE clip_id = ?");
    $stmt->bind_param("i", $clip_id);
    $stmt->execute();
    $stmt->close();

    // delete comments for the clip
    $stmt = $conn->prepare("DELETE FROM comments WHERE clip_id = ?");
    $stmt->bind_param("i", $clip_id);
    $stmt->execute();
    $stmt->close();

    // delete the clip from the clips table
    $stmt = $conn->prepare("DELETE FROM clips WHERE id = ?");
    $stmt->bind_param("i", $clip_id);
    $stmt->execute();
    $stmt->close();

    // delete the clip files 
    deleteClipFiles($clip_id);

    $conn->commit();

    echo "Clip and associated data deleted successfully";
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    echo "Error deleting clip: " . $e->getMessage();
}

closeDb($conn);
?>

