<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="../root.css">
<!-- Link to external CSS file -->
<link rel="stylesheet" type="text/css" href="styles.css">
<link rel="stylesheet" type="text/css" href="../root.css"/>
<!-- Link to the JavaScript file -->
<script src="actions.js"></script>

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
            /* Make each clip have a box */
            background: var(--color-bg-secondary);
            padding: 2em;
            border-radius: 10px;
            border-color: var(--color-bg-primary);
            border-style: solid;
            border-width: 2px;
            box-shadow: 6px 6px black;

        }
        .audio-item:hover{
            background: var(--color-bg-primary);
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

        /* like/dislike button styles based on status */
        .liked {
            color:lightblue;
        }
        .notLiked {
            color:red;
        }
        .disliked {
            color:lightblue;
        }
        .notDisliked {
            color:red;
        }

        .clip-popup {
            background-color: black;
        }
        .clip-popup:hover{
            background-color: black;
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

<h1 class="nav-bar">
    <center>Discover</center>
</h1>

<div id='content-container' class="audio-container">

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
        include '../../includes/scripts.php';

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

    <div style="padding-top:20%">
    </div>



    <script src="upload_button.js"></script>

    <script>
        function openClipMenu(domId){
            let clip_element = document.getElementById(domId);

            clip_element.classList.add("popup", "open-popup", "clip-popup")

            let clickHandler = function(event){
                // only close the popup if you click outside of it
                if (!clip_element.contains(event.target)){
                    clip_element.classList.remove("popup", "open-popup", "clip-popup");
                }
            };

            setTimeout(function(){window.addEventListener("click", clickHandler, {once: true})}, 20);
        }

        clipNumber = 0;
        window.onload = function(){
            clipNumber = 0;
        }

        // make ajax request to load more clips
        let xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            document.getElementById('content-container').innerHTML += this.responseText;
            console.log("Loaded 15 more clips");
            clipNumber += 15;
        }
        xhttp.open("GET", "load_clips.php?clip_number=" + clipNumber);
        xhttp.send();

        window.addEventListener("scroll",
            function () {
                if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 50){
                    // make ajax request to load more clips
                    let contentContainer = document.getElementById("content-container");

                    let xhttp = new XMLHttpRequest();
                    xhttp.onload = function() {
                        // make sure that we do not repeat any clip ids (or it will reset the clip progress when 
                        var tempDiv = document.createElement("div");
                        tempDiv.innerHTML = this.responseText;

                        for (let currentElement of tempDiv.children){
                            if (!document.getElementById(currentElement.getAttribute('id'))){
                                contentContainer.innerHTML += currentElement.outerHTML;
                            }
                        }

                        clipNumber += 15;
                    }
                    xhttp.open("GET", "load_clips.php?clip_number=" + clipNumber);
                    xhttp.send();
                }


            }
        );

    </script>

</div>
</body>
</html>

