<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acc Name goes here</title>
    <link rel="stylesheet" href="/css/profile.css">
</head>
<body>
    <div id="acc-info">
        <h2>Account Name</h2>

        <img id="acc-img" src="../img/default-acc"/>

        <!-- NOTE: -->
        <!-- The filler divs are solely for making flex work. No functionality -->
        <div id="acc-stats">
            <div class="filler"></div>
            <div class="filler"></div>
            <div class="stat" id="followers">
                <h3>57</h3>
                <p>Followers</p>
            </div>
            <div class="stat" id="following">
                <h3>70.0k</h3>
                <p>Following</p>
            </div>
            <div class="stat" id="wavecount">
                <h3>320</h3>
                <p>Waves</p>
            </div>
            <div class="filler"></div>
            <div class="filler"></div>
        </div>
        <button id="follow-btn">Follow</button>
    </div>

    <!-- Includes navbar for clip/playlist and clips/playlists list-->
    <div id="clip-div">
        <!-- Used to select between profile's clips and playlists -->
        <div id="clip-nav-bar">
            <div id="show-clips" class="clip-nav">Clips</div>
            <div id="show-playlists" class="clip-nav">Playlists</div>
        </div>        
    </div>
</body>
</html>