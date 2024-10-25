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

    $currentClipNumber = $_GET["clip_number"];

    function getNextClipBatch($batchSize, $currentClipNumber){
        $conn = initDb();

        # get a batch of clip_ids
        $clip_ids = getClipBatch($conn, $currentClipNumber, $batchSize);

        # display the clips on the home page
        createClips($conn,  $clip_ids);

        closeDB($conn);
    }

    # start with displaying a batch of at most 30 clips for now
    getNextClipBatch(15, $currentClipNumber);

?>
