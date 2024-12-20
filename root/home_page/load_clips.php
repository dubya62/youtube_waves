<?php
    include '../../includes/scripts.php';

    function getClipLikeClass($conn, $clip_id){
        // return either liked or notLiked
        if (isLikedByCookie($conn, $clip_id)){
            return "liked";
        }
        return "notLiked";
    }

    function getClipDislikeClass($conn, $clip_id){
        // return either disliked or notDisliked
        if (isDislikedByCookie($conn, $clip_id)){
            return "disliked";
        }
        return "notDisliked";
    }

    function getUserFollowClass($conn, $user_id, $owner){
        if (checkIfFollowingUser($conn, $user_id, $owner)){
            return "liked";
        }
        return "notLiked";
    }

    function createClip($conn, $clip_id){
        
        $owner = getClipOwner($conn, $clip_id);
        echo "<div class='audio-item' id='clip-" . $clip_id . "' onclick='openClipMenu(\"clip-" . $clip_id . "\")' style='background-image:url(\"images/" . $clip_id . "." . getImageExtension($conn, $clip_id) . "\"); background-repeat:no-repeat; background-size: cover'>
            <div class='clip-layer'>
            <br>
            <img src='../profile/images/" . $owner . "' alt='profile-picture' class='thumbnail' style='border-radius:50%' onclick='window.location=\"../profile/profile.php?user_id=" . $owner . "\"'>
            <br>
            <!-- Follow Button -->
            <div style='display:flex'> 
                <button class='btn-23' onclick='incrementFollow(" . $clip_id . "); event.stopPropagation()'> <span class='text'>Follow</span>
                    <span class='marquee'>Follow</span>
                </button>
                <p style='margin-left: 1em' class='" . getUserFollowClass($conn, getUserIdByCookie($conn), $owner) . "' id='follow-counter-" . $clip_id . "'>" . getFollowerCount($conn, $owner) . "</p>
            </div>
            <div class='audio-title'>" . getClipName($conn, $clip_id) . "</div>
            <br>
            <audio id='audio-" . $clip_id . "' controls class='audio-player' onclick='event.stopPropagation()'>
                <source src='../home_page/audios/" . $clip_id . "." . getClipExtension($conn, $clip_id) . "' type='audio/mp3'>
                Your browser does not support the audio element.
            </audio>
            <br>

            <div class='button-container'>
                <!-- LIKE Button -->
                <button class='btn-23' onclick='incrementLike(". $clip_id . "); event.stopPropagation()'>
                    <span class='text'>LIKE</span>
                    <span class='marquee'>LIKE</span>
                </button>
                <p class='" . getClipLikeClass($conn, $clip_id) . "' id='like-counter-" . $clip_id . "'>" . getClipLikes($conn, $clip_id) . "</p>  <!-- Like counter -->
                
                <!-- DISLIKE Button -->
                <button class='btn-23' onclick='incrementDislike(" . $clip_id . "); event.stopPropagation()'>
                    <span class='text'>DISLIKE</span>
                    <span class='marquee'>DISLIKE</span>    
                </button>
                <p class='" . getClipDislikeClass($conn, $clip_id) . "' id='dislike-counter-" . $clip_id . "'>" . getClipDislikes($conn, $clip_id) . "</p> <!-- Dislike counter -->
            </div>
            <br>
            
                <!-- COMMENT Button -->
                <div class='comment-container' id='comment-" . $clip_id . "'>
                    <button class='btn-23' onclick='openCommentPopup(" . $clip_id . "); convertTimestamps(); event.stopPropagation()'>
                        <span class='text'>RANT</span>
                        <span class='marquee'>RANT</span>
                    </button>         
                </div>

                <!-- SHARE Button -->
                <div class='share-container' id='share-" . $clip_id . "'>
                    <button class='btn-23' onclick='shareAudio(" . $clip_id . "); event.stopPropagation()'>
                        <span class='text'>SHARE</span>
                        <span class='marquee'>SHARE</span>
                    </button>
                </div>";
        if ($owner == getUserIdByCookie($conn)){
            echo "<!-- DELETE Button --> 
                <div class='delete-container' id='delete-" . $clip_id . "'>
                    <button class='btn-23' onclick='deleteClip(" . $clip_id . "); event.stopPropagation()'>
                        <span class='text'>DELETE</span>
                        <span class='marquee'>DELETE</span>
                    </button>
                </div>";
        }
        echo "<br></div></div>";

    }


    function createClips($conn, $clip_ids){

        # create each clip
        foreach ($clip_ids as $clip_id){
            createClip($conn, $clip_id);
        }

    }



    function getNextClipBatch($batchSize, $currentClipNumber){
        $conn = initDb();

        # get a batch of clip_ids
        $clip_ids = getClipBatch($conn, $currentClipNumber, $batchSize);

        # display the clips on the home page
        createClips($conn,  $clip_ids);

        closeDB($conn);
    }

    # start with displaying a batch of at most 30 clips for now
    if (isset($_GET["clip_number"])){
        $currentClipNumber = $_GET["clip_number"];
        getNextClipBatch(15, $currentClipNumber);
    }


?>
