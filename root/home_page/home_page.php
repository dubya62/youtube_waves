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
<<<<<<< HEAD
=======
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

>>>>>>> a04ee9d (Uploading clips now creates the appropriate entry in the database and returns the newly created clip_id. Fixed the merge conflict ?)
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

<<<<<<< HEAD
    <input type='button' onclick='window.location="/logout.php";' value='logout'/>
=======
    <input type='button' onclick='window.location="../logout.php";' value='logout'/>
>>>>>>> a04ee9d (Uploading clips now creates the appropriate entry in the database and returns the newly created clip_id. Fixed the merge conflict ?)
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
<<<<<<< HEAD
    <?php
        include '../../includes/scripts.php';

        function createClip($conn, $clip_id){
            echo "<div class='audio-item' id='clip-" . $clip_id . "' onclick='openClipMenu(\"clip-" . $clip_id . "\")'>
                <img src='photos/" . $clip_id . "' alt='Thumbnail' class='thumbnail'>
                <div class='audio-title'>" . getClipName($conn, $clip_id) . "</div>
                <audio controls class='audio-player'>
                    <source src='audios/" . $clip_id . ".mp3' type='audio/mp3'>
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


        function createClips($clip_ids){
            $conn = initDb();

            # create each clip
            foreach ($clip_ids as $clip_id){
                createClip($conn, $clip_id);
            }

            closeDb($conn);

        }

        createClips(array("1", "2", "3", "4"));

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
=======
    <div class="audio-item">
        <img src="images-3.jpeg" alt="Thumbnail 1" class="thumbnail">
        <div class="audio-title">Moo Deng Scream</div>
        <audio controls class="audio-player">
            <source src="audios/audio4.mp3" type="audio/mp3">
            Your browser does not support the audio element.
        </audio>

        <div class="button-container">
            <!-- LIKE Button -->
            <button class="btn-23" onclick="incrementLike('like-counter-1')">
                <span class="text">LIKE</span>
                <span class="marquee">LIKE</span>
            </button>
            <p id="like-counter-1">0</p>  <!-- Like counter -->
            
            <!-- DISLIKE Button -->
            <button class="btn-23" onclick="incrementDislike('dislike-counter-1')">
                <span class="text">DISLIKE</span>
                <span class="marquee">DISLIKE</span>    
            </button>
            <p id="dislike-counter-1">0</p> <!-- Dislike counter -->
        </div>
        
            <!-- COMMENT Button -->
            <div class="comment-container">
                <button class="btn-23" onclick="openCommentPopup('comment-popup-1')">
                    <span class="text">RANT</span>
                    <span class="marquee">RANT</span>
                </button>
            </div>
        
            <div class="popup" id="comment-popup-1">
                <h2>Start your RANT here!</h2>
                <textarea id="comment-textbox-1" placeholder="Type your rant..."></textarea>
                <button type="button" onclick="submitComment('comment-textbox-1', 'comments-container-1')">Submit</button>
                <button type="button" onclick="closeCommentPopup('comment-popup-1')">Cancel</button>
        
                <div class="comment-thread">
                    <h2>Rants</h2>
                    <div id="comments-container-1"></div>
                </div>
            </div>

    </div>

    <div class="audio-item">
        <img src="images-4.jpeg" alt="Thumbnail 2" class="thumbnail">
        <div class="audio-title">Pesto Packing ASMR</div>
        <audio controls class="audio-player">
            <source src="audios/audio1.mp3" type="audio/mp3">
            Your browser does not support the audio element.
        </audio>

        <div class="button-container">
            <!-- LIKE Button -->
            <button class="btn-23" onclick="incrementLike('like-counter-2')">
                <span class="text">LIKE</span>
                <span class="marquee">LIKE</span>
            </button>
            <p id="like-counter-2">0</p>  <!-- Like counter -->
            
            <!-- DISLIKE Button -->
            <button class="btn-23" onclick="incrementDislike('dislike-counter-2')">
                <span class="text">DISLIKE</span>
                <span class="marquee">DISLIKE</span>    
            </button>
            <p id="dislike-counter-2">0</p> <!-- Dislike counter -->
        </div>
    
        <!-- COMMENT Button -->
        <div class="comment-container">
            <button class="btn-23" onclick="openCommentPopup('comment-popup-2')">
                <span class="text">RANT</span>
                <span class="marquee">RANT</span>
            </button>
        </div>

            <!-- Popup for Rant Submission -->
            <div class="popup" id="comment-popup-2">
                <h2>Start your RANT here!</h2>
                <textarea id="comment-textbox-2" placeholder="Type your rant..."><</textarea>
                <button type="button" onclick="submitComment('comment-textbox-2', 'comments-container-2')">Submit</button>
                <button type="button" onclick="closeCommentPopup('comment-popup-2')">Cancel</button>

                <!-- Comment section to display the comment thread inside the popup -->
                <div class="comment-thread">
                    <h2>Rants</h2>
                    <div id="comments-container-2"></div>
                </div>
            </div>
    </div>

    <div class="audio-item">
        <img src="images-5.jpeg" alt="Thumbnail 3" class="thumbnail">
        <div class="audio-title">...You gonna finish that?</div>
        <audio controls class="audio-player">
            <source src="audios/audio3.mp3" type="audio/mp3">
            Your browser does not support the audio element.
        </audio>

        <div class="button-container">
            <!-- LIKE Button -->
            <button class="btn-23" onclick="incrementLike('like-counter-3')">
                <span class="text">LIKE</span>
                <span class="marquee">LIKE</span>
            </button>
            <p id="like-counter-3">0</p>  <!-- Like counter -->
            
            <!-- DISLIKE Button -->
            <button class="btn-23" onclick="incrementDislike('dislike-counter-3')">
                <span class="text">DISLIKE</span>
                <span class="marquee">DISLIKE</span>    
            </button>
            <p id="dislike-counter-3">0</p> <!-- Dislike counter -->
        </div>
    
        <!-- COMMENT Button -->
        <div class="comment-container">
            <button class="btn-23" onclick="openCommentPopup('comment-popup-3')">
                <span class="text">RANT</span>
                <span class="marquee">RANT</span>
            </button>
        </div>

            <!-- Popup for Rant Submission -->
            <div class="popup" id="comment-popup-3">
                <h2>Start your RANT here!</h2>
                <textarea id="comment-textbox-3" placeholder="Type your rant..."><</textarea>
                <button type="button" onclick="submitComment('comment-textbox-3', 'comments-container-3')">Submit</button>
                <button type="button" onclick="closeCommentPopup('comment-popup-3')">Cancel</button>

                <!-- Comment section to display the comment thread inside the popup -->
                <div class="comment-thread">
                    <h2>Rants</h2>
                    <div id="comments-container-3"></div>
                </div>
            </div>
    </div>

    
    <div class="audio-item">
        <img src="china-skala.gif" alt="Thumbnail 3" class="thumbnail">
        <div class="audio-title">🤨</div>
        <audio controls class="audio-player">
            <source src="audios/audio5.mp3" type="audio/mp3">
            Your browser does not support the audio element.
        </audio>

        <div class="button-container">
            <!-- LIKE Button -->
            <button class="btn-23" onclick="incrementLike('like-counter-4')">
                <span class="text">LIKE</span>
                <span class="marquee">LIKE</span>
            </button>
            <p id="like-counter-4">0</p>  <!-- Like counter -->
            
            <!-- DISLIKE Button -->
            <button class="btn-23" onclick="incrementDislike('dislike-counter-4')">
                <span class="text">DISLIKE</span>
                <span class="marquee">DISLIKE</span>    
            </button>
            <p id="dislike-counter-4">0</p> <!-- Dislike counter -->
        </div>
    
        <!-- COMMENT Button -->
        <div class="comment-container">
            <button class="btn-23" onclick="openCommentPopup('comment-popup-4')">
                <span class="text">RANT</span>
                <span class="marquee">RANT</span>
            </button>
        </div>

            <!-- Popup for Rant Submission -->
            <div class="popup" id="comment-popup-4">
                <h2>Start your RANT here!</h2>
                <textarea id="comment-textbox-4" placeholder="Type your rant..."><</textarea>
                <button type="button" onclick="submitComment('comment-textbox-4', 'comments-container-4')">Submit</button>
                <button type="button" onclick="closeCommentPopup('comment-popup-4')">Cancel</button>

                <!-- Comment section to display the comment thread inside the popup -->
                <div class="comment-thread">
                    <h2>Rants</h2>
                    <div id="comments-container-4"></div>
                </div>
            </div>

    </div>

    <div class="audio-item">
        <img src="images-7.jpeg" alt="Thumbnail 3" class="thumbnail">
        <div class="audio-title">Can I pet that dog?</div>
        <audio controls class="audio-player">
            <source src="audios/audio6.mp3" type="audio/mp3">
            Your browser does not support the audio element.
        </audio>

        <div class="button-container">
            <!-- LIKE Button -->
            <button class="btn-23" onclick="incrementLike('like-counter-5')">
                <span class="text">LIKE</span>
                <span class="marquee">LIKE</span>
            </button>
            <p id="like-counter-5">0</p>  <!-- Like counter -->
            
            <!-- DISLIKE Button -->
            <button class="btn-23" onclick="incrementDislike('dislike-counter-5')">
                <span class="text">DISLIKE</span>
                <span class="marquee">DISLIKE</span>    
            </button>
            <p id="dislike-counter-5">0</p> <!-- Dislike counter -->
        </div>
    
        <!-- COMMENT Button -->
        <div class="comment-container">
            <button class="btn-23" onclick="openCommentPopup('comment-popup-5')">
                <span class="text">RANT</span>
                <span class="marquee">RANT</span>
            </button>
        </div>

            <!-- Popup for Rant Submission -->
            <div class="popup" id="comment-popup-5">
                <h2>Start your RANT here!</h2>
                <textarea id="comment-textbox-5" placeholder="Type your rant..."><</textarea>
                <button type="button" onclick="submitComment('comment-textbox-5', 'comments-container-5')">Submit</button>
                <button type="button" onclick="closeCommentPopup('comment-popup-5')">Cancel</button>

                <!-- Comment section to display the comment thread inside the popup -->
                <div class="comment-thread">
                    <h2>Rants</h2>
                    <div id="comments-container-5"></div>
                </div>
            </div>

    </div>

    <div class="audio-item">
        <img src="capybara-square-1.jpg.optimal.jpg" alt="Thumbnail 3" class="thumbnail">
        <div class="audio-title">Capybara Stream Sound Bytes</div>
        <audio controls class="audio-player">
            <source src="audios/audio2.mp3" type="audio/mp3">
            Your browser does not support the audio element.
        </audio>

        <div class="button-container">
            <!-- LIKE Button -->
            <button class="btn-23" onclick="incrementLike('like-counter-6')">
                <span class="text">LIKE</span>
                <span class="marquee">LIKE</span>
            </button>
            <p id="like-counter-6">0</p>  <!-- Like counter -->
            
            <!-- DISLIKE Button -->
            <button class="btn-23" onclick="incrementDislike('dislike-counter-6')">
                <span class="text">DISLIKE</span>
                <span class="marquee">DISLIKE</span>    
            </button>
            <p id="dislike-counter-6">0</p> <!-- Dislike counter -->
        </div>
    
        <!-- COMMENT Button -->
        <div class="comment-container">
            <button class="btn-23" onclick="openCommentPopup('comment-popup-6')">
                <span class="text">RANT</span>
                <span class="marquee">RANT</span>
            </button>
        </div>

            <!-- Popup for Rant Submission -->
            <div class="popup" id="comment-popup-6">
                <h2>Start your RANT here!</h2>
                <textarea id="comment-textbox-6" placeholder="Type your rant..."><</textarea>
                <button type="button" onclick="submitComment('comment-textbox-6', 'comments-container-6')">Submit</button>
                <button type="button" onclick="closeCommentPopup('comment-popup-6')">Cancel</button>

                <!-- Comment section to display the comment thread inside the popup -->
                <div class="comment-thread">
                    <h2>Rants</h2>
                    <div id="comments-container-6"></div>
                </div>
            </div>

    </div>
</div>
<div>
<<<<<<< HEAD:root/like_dislike_comment/Comment-test/home_page.html
    <button class="upload-button" type="submit">+</button>
=======

    <?php
        include '../../includes/scripts.php';
>>>>>>> a04ee9d (Uploading clips now creates the appropriate entry in the database and returns the newly created clip_id. Fixed the merge conflict ?)
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

    <script>
        function openClipMenu(dom_id){
            let clip_element = document.getElementById(dom_id);
        }

    </script>

</div>
</body>
</html>

