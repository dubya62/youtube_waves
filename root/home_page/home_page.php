<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="../root.css">
<!-- Link to external CSS file -->
<link rel="stylesheet" type="text/css" href="styles.css">
<!-- Link to the JavaScript file -->
<script src="actions.js" defer></script>

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
        .search-bar input {
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
    </style>
</head>
<body>

<header>

    <div>
        <img src="logo.png" alt="Logo" style="width: 100px; height: 60px">
    </div>

    <div class="search-bar">
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
<h1 style="color: var(--color-green)">
    <center>Discover Page</center>
</h1>
<div class="audio-container">
    <?php
        include '../../includes/scripts.php';

        function createClip($clip_id){
            $conn = initDb();
            echo "<div class='audio-item'>
                <img src='photos/" . $clip_id . "' alt='Thumbnail' class='thumbnail'>
                <div class='audio-title'>" . getClipName($conn, $clip_id) . "</div>
                <audio controls class='audio-player'>
                    <source src='audios/" . $clip_id . "' type='audio/mp3'>
                    Your browser does not support the audio element.
                </audio>

                <div class='button-container'>
                    <!-- LIKE Button -->
                    <button class='btn-23' onclick='incrementLike('like-counter-1')'>
                        <span class='text'>LIKE</span>
                        <span class='marquee'>LIKE</span>
                    </button>
                    <p id='like-counter-1'>0</p>  <!-- Like counter -->
                    
                    <!-- DISLIKE Button -->
                    <button class='btn-23' onclick='incrementDislike('dislike-counter-1')'>
                        <span class='text'>DISLIKE</span>
                        <span class='marquee'>DISLIKE</span>    
                    </button>
                    <p id='dislike-counter-1'>0</p> <!-- Dislike counter -->
                </div>
                
                    <!-- COMMENT Button -->
                    <div class='comment-container'>
                        <button class='btn-23' onclick='openCommentPopup()'>
                            <span class='text'>RANT</span>
                            <span class='marquee'>RANT</span>
                        </button>
                
                    </div>
                        

                </div>";
            closeDb($conn);

        }

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
        if (isset($_POST["name"])){
            if (isset($_POST["audio"])){
                if (isset($_POST["image"])){
                    if (isset($_POST["tags"])){
                        // we have a valid upload.
                        // we need to create a database entry for it
                        $conn = initDb();
                        
                        createClipEntry($conn, $_POST["name"], $_POST["tags"]);
                        
                        closeDb($conn);

                        // TODO: create a file to store the clip in
                        
                    }
                }
            }
        }

    ?>

    <button id="upload-button" class="upload-button" type="button">+</button>

    <div id="popupForm" class="otherPopup">
        <div class="popup-content">
            <span class="close">&times;</span>
            <form method="post" id="uploadForm">
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


</div>
</body>
</html>
