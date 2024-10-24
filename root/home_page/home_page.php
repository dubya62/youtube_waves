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


    <div class="audio-item">
        <img src="images-3.jpeg" alt="Thumbnail 1" class="thumbnail">
        <div class="audio-title">Moo Deng</div>
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
                <button class="btn-23" onclick="openCommentPopup()">
                    <span class="text">RANT</span>
                    <span class="marquee">RANT</span>
                </button>
        
            </div>
                

    </div>

    <div class="audio-item">
        <img src="images-4.jpeg" alt="Thumbnail 2" class="thumbnail">
        <div class="audio-title">Pesto ASMR</div>
        <audio controls class="audio-player">
            <source src="audios/audio2.mp3" type="audio/mp3">
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
            <button class="btn-23" onclick="openCommentPopup()">
                <span class="text">RANT</span>
                <span class="marquee">RANT</span>
            </button>
    
        </div>
            
    </div>

    <div class="audio-item">
        <img src="images-5.jpeg" alt="Thumbnail 3" class="thumbnail">
        <div class="audio-title">...You gonna finish that?</div>
        <audio controls class="audio-player">
            <source src="audios/audio1.mp3" type="audio/mp3">
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
            <button class="btn-23" onclick="openCommentPopup()">
                <span class="text">RANT</span>
                <span class="marquee">RANT</span>
            </button>
    
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
            <button class="btn-23" onclick="openCommentPopup()">
                <span class="text">RANT</span>
                <span class="marquee">RANT</span>
            </button>
    
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
            <button class="btn-23" onclick="openCommentPopup()">
                <span class="text">RANT</span>
                <span class="marquee">RANT</span>
            </button>
    
        </div>
            

    </div>

    <div class="audio-item">
        <img src="capybara-square-1.jpg.optimal.jpg" alt="Thumbnail 3" class="thumbnail">
        <div class="audio-title">Capybara Stream Sound Bytes</div>
        <audio controls class="audio-player">
            <source src="audios/audio3.mp3" type="audio/mp3">
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
            <button class="btn-23" onclick="openCommentPopup()">
                <span class="text">RANT</span>
                <span class="marquee">RANT</span>
            </button>
    
        </div>
            
    </div>
</div>
<div>

    <button id="upload-button" class="upload-button" type="submit">+</button>

    <div id="popupForm" class="otherPopup">
        <div class="popup-content">
            <span class="close">&times;</span>
            <form id="uploadForm">
                <h2 style="color: var(--color-text-primary)">Create New Post</h2>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required><br><br>

                <label for="audio">Upload Audio:</label>
                <input type="file" id="audio" name="audio" accept="audio/*" required><br><br>

                <label for="image">Upload Photo/GIF:</label>
                <input type="file" id="image" name="image" accept="image/*,image/gif" required><br><br>

                <label for="description">Description:</label>
                <input type="text" id="desc" name="desc"><br><br>

                <button class="clickable" type="submit">Submit</button>
            </form>
        </div>
    </div>

    <script src="upload_button.js"></script>


</div>
</body>
</html>
