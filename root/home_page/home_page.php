<!DOCTYPE html> <html lang="en">
<head>
<link rel="stylesheet" href="../root.css">
<!-- Link to external CSS file -->
<link rel="stylesheet" type="text/css" href="styles.css">
<!-- Link to the JavaScript file -->
<script src="actions.js" ></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube Waves</title>
    <style>
        body {
            height: 100%;
            font-family: Roboto, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--color-bg-secondary);
            align-items: center;
            justify-content: center;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: var(--color-bg-primary);
        }
        .nav-bar {
            align-items: center;
            color: var(--color-green);
            background-color: var(--color-shadow);
            padding: 10px;
        }
        .search-bar input {
            width: 300px;
            padding: 5px;
            font-size: 16px;
            border-radius: 15px;    
        }
        .footer {
            margin-top: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background-color: var(--color-bg-primary);
        }
        .clickable {
            cursor: pointer;
        }
        .upload-button {
            position: fixed;
            right: 20px;
            bottom: 20px;
            padding: 8px 20px;
            font-size: 36px;
            border-radius: 15px;
            background-color: var(--color-orange);
            color: var(--color-text-primary);
            cursor: pointer;
        }
        .arrow {
            width: 40px;
            height: 60px;
            background-color: var(--color-gray);
            color: var(--color-text-secondary);
            cursor: pointer;
            border-radius: 20%;
            vertical-align: center;
        }
        .audio-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .audio-item {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
            width: 33%;
        }
        .thumbnail {
            width: 100px;
            height: 100px;
            margin-bottom:20px;
            cursor: pointer;
        }
        .audio-title {
            font-size: 18px;
            margin-bottom: 10px;
            color: var(--color-text-secondary);
        }
        .audio-player {
            width: 300px;
        }
        .otherPopup {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.6);
        }

        .popup-content {
            color: var(--color-text-secondary);
            background-color: var(--color-bg-primary);
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 300px;

        }

        .close {
            color: var(--color-hover-orange);
            transition: color 0.3s ease, transform 0.3s ease;
            float: right;
            font-size: 24px;
            cursor: pointer;
        }
        .close:hover {
            color: var(--color-orange); 
            transform: scale(1.2);
        }

        .message {
            margin-top: 20px;
            font-size: 18px;
            color: var(--color-text-secondary);
        }


    </style>
</head>
<body>

<header>

    <div>
        <img src="logo.png" alt="Logo" style="width: 100px; height: 60px">
    </div>

    <div class="search-bar">
        <!-- Search Form -->
        <form method="GET">
            <input type="text" name="query" placeholder="Search for something..." required>
            <button type="submit">Search</button>
        </form>

        <?php
        // Check if the 'query' parameter is set in the URL
        if (isset($_GET['query'])) {
            // Get the search query from the form input
            $search_query = htmlspecialchars($_GET['query']);

            // Redirect to search page with the query as a URL parameter
            // Replace 'search_page.php' with your actual search page
            header("Location: ../search/search.php?query=" . urlencode($search_query));
            exit(); // Make sure to exit after the redirect to prevent further code execution
        }
        ?>
    </div>

        <form action="" method="GET">
            <input type="text" name="search" placeholder="Search audio files...">
            <button class="clickable" type="submit">Search</button>
        </form>
    </div>


    <input type='button' onclick='window.location="/logout.php";' value='logout'/>
    <!--On click of profile icon, redirect to profile page-->
        <div class="clickable" onclick="window.location.href='/profile/profile.php'">
            <img src="profile_icon.png" alt="Profile" style="width: 40px; height: 40px;">
        </div>
        
    </div>
</header>
<h1 class="nav-bar">
    <center>Discover</center>
</h1>
<div class="audio-container">
    <?php
        include '../../includes/scripts.php';

        function createClip($conn, $clip_id){
            echo "<div class='audio-item' id='clip-" . $clip_id . "' onclick='openClipMenu(\"clip-" . $clip_id . "\")'>
                <img src='images/" . $clip_id . "." . getImageExtension($conn, $clip_id) . "' alt='Thumbnail' class='thumbnail'>
                <div class='audio-title'>" . getClipName($conn, $clip_id) . "</div>
                <audio controls class='audio-player'>
                    <source src='audios/" . $clip_id . "." . getClipExtension($conn, $clip_id) . "' type='audio/mp3'>
                    Your browser does not support the audio element.
                </audio>

                <div class='button-container'>
                    <!-- LIKE Button -->
                    <button class='btn-23' onclick='incrementLike(\"like-counter-". $clip_id . "\")'>
                        <span class='text'>LIKE</span>
                        <span class='marquee'>LIKE</span>
                    </button>
                    <p id='like-counter-" . $clip_id . "'>0</p>  <!-- Like counter -->
                    
                    <!-- DISLIKE Button -->
                    <button class='btn-23' onclick='incrementDislike(\"dislike-counter-" . $clip_id . "\")'>
                        <span class='text'>DISLIKE</span>
                        <span class='marquee'>DISLIKE</span>    
                    </button>
                    <p id='dislike-counter-" . $clip_id . "'>0</p> <!-- Dislike counter -->
                </div>
                
                    <!-- COMMENT Button -->
                    <div class='comment-container'>
                        <button class='btn-23' onclick='openCommentPopup()'>
                            <span class='text'>RANT</span>
                            <span class='marquee'>RANT</span>
                        </button>
                
                    </div>
                        

                </div>";

        }


        function createClips($conn, $clip_ids){

            # create each clip
            foreach ($clip_ids as $clip_id){
                createClip($conn, $clip_id);
            }

        }

        $currentClipNumber = 0;

        function getNextClipBatch($batchSize, $currentClipNumber){
            $conn = initDb();

            # get a batch of clip_ids
            $clip_ids = getClipBatch($conn, $currentClipNumber, $batchSize);

            # display the clips on the home page
            createClips($conn,  $clip_ids);

            closeDB($conn);
        }

        # start with displaying a batch of at most 30 clips for now
        getNextClipBatch(30, $currentClipNumber);
        $currentClipNumber += 30;

    ?>

    <!-- COMMENT Textbox Popup-->
    <div class="popup" id="comment-popup">
        <h2>Start your RANT here!</h2>
        <textarea id="comment-textbox" name="Comments" placeholder="Type your rant..."></textarea>
        <button type="button" onclick="submitComment()">Submit</button>
        <button type="button" onclick="closeCommentPopup()">Cancel</button>
    </div>

    <!-- Popup for Rant Submission -->
    <div class="popup" id="popup">
        <h2>Your RANT has been submitted!</h2>
        <button type="button" onclick="betterClosePopup()">OK</button>
    </div>


</div>
<div>

    <?php
        // handle uploads
        // Mapping MIME types to file extensions
        $audioMimeToExt = [
            'audio/mpeg' => 'mp3',
            'audio/wav' => 'wav',
            'audio/x-wav' => 'wav',
            'audio/mp4' => 'm4a',
            'audio/ogg' => 'ogg',
        ];

        $imageMimeToExt = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
        ];

        if (isset($_POST["name"])){
            if (isset($_FILES["audio"]["name"])){
                if (isset($_FILES["image"]["name"])){
                    if (isset($_POST["tags"])){
                        // we have a valid upload.
                        // we need to create a database entry for it
                        $conn = initDb();
                        
                        $clipId = createClipEntry($conn, $_POST["name"], $_POST["tags"]);
                        

                        // Store the audio file in the audio folder with the name of the clip id
                        // Handle audio file upload
                        $audioMimeType = $_FILES['audio']['type'];

                        if (array_key_exists($audioMimeType, $audioMimeToExt)) {
                            $audioExt = $audioMimeToExt[$audioMimeType];
                            $audioTmpPath = $_FILES['audio']['tmp_name'];
                            $audioFileName = $clipId . "." . $audioExt;
                            $audioUploadPath = '../home_page/audios/' . $audioFileName;

                            // save the extension in the database
                            setClipExtension($conn, $clipId, $audioExt);
                        
                            // Move the audio file
                            move_uploaded_file($audioTmpPath, $audioUploadPath);
                        } else {
                            echo "Invalid audio file type. Accepted types are: mp3, wav, m4a, ogg.";
                        }
                        // Store the image file in the image folder with the name of the clip id
                        // Handle image file upload
                        $imageMimeType = $_FILES['image']['type'];
                        if (array_key_exists($imageMimeType, $imageMimeToExt)) {
                            $imageExt = $imageMimeToExt[$imageMimeType];
                            $imageTmpPath = $_FILES['image']['tmp_name'];
                            $imageFileName = $clipId . "." . $imageExt;
                            $imageUploadPath = '../home_page/images/' . $imageFileName;
                            
                            // save the image extension in the database
                            setImageExtension($conn, $clipId, $imageExt);
                            
                            // Move the image file
                            move_uploaded_file($imageTmpPath, $imageUploadPath);
                        } else {
                            echo "Invalid image file type.";
                            exit();
                        }

                        closeDb($conn);

                    }
                }
            }
        }
    ?>

    <button id="upload-button" class="upload-button" type="button">+</button>

    <div id="popupForm" class="otherPopup">
        <div class="popup-content">
            <span class="close">&times;</span>
            <form method="post" id="uploadForm" enctype="multipart/form-data" onsubmit="setTimeout(function {window.location.reload();}, 10);">
                <h2 style="color: var(--color-text-primary)">Create New Post</h2>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required><br><br>

                <label for="audio">Upload Audio:</label>
                <input type="file" id="audio" name="audio" accept="audio/*" required><br><br>

                <label for="image">Upload Photo/GIF:</label>
                <input type="file" id="image" name="image" accept="image/*,image/gif" required><br><br>

                <label for="tags">Tags:</label>
                <input type="text" id="tags" name="tags"><br><br>

                <input class="clickable" type="submit" value="upload">
            </form>
        </div>
    </div>

    <script src="upload_button.js"></script>

    <script>
        function openClipMenu(dom_id){
            let clip_element = document.getElementById(dom_id);
        }

    </script>

</div>
<?php include '../navigationBar/navigationBar.php'; ?>
</body>
<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> 7ad51b7dfc51dc9541d2cc5ec60341fbca82798b
