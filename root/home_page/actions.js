
// Function to increment LIKE count
function incrementLike(clip_id) {
    // make ajax call to either like or unlike
    let likeElement = document.getElementById("like-counter-" + clip_id);
    let xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        if (this.responseText == "-1"){ // this unliked it
            // change the button color
            likeElement.classList.remove("liked");
            likeElement.classList.add("notLiked");
            likeElement.textContent = parseInt(likeElement.textContent) - 1;
        } else if (this.responseText == "1"){ // this liked it
            // change the button color
            likeElement.classList.remove("notLiked");
            likeElement.classList.add("liked");
            likeElement.textContent = parseInt(likeElement.textContent) + 1;
        }

    }
    xhttp.open("GET", "like_clip.php?action=1&clip_id=" + clip_id);
    xhttp.send();
}

// Function to increment DISLIKE count
function incrementDislike(clip_id) {
    // make ajax call to either dislike or undislike
    let dislikeElement = document.getElementById("dislike-counter-" + clip_id);
    let xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        if (this.responseText == "-0"){ // this undisliked it
            // change the button color
            dislikeElement.classList.remove("disliked");
            dislikeElement.classList.add("notDisliked");
            dislikeElement.textContent = parseInt(dislikeElement.textContent) - 1;
        } else if (this.responseText == "0"){ // this disliked it
            // change the button color
            dislikeElement.classList.remove("notDisliked");
            dislikeElement.classList.add("disliked");
            dislikeElement.textContent = parseInt(dislikeElement.textContent) + 1;
        }

    }
    xhttp.open("GET", "like_clip.php?action=0&clip_id=" + clip_id);
    xhttp.send();
}


// Function to open the submission popup
function openPopup() {
    let popup = document.getElementById('popup');
    if (popup != null){
        popup.classList.replace("popup", "open-popup");
    }
}

// Function to close the submission popup
function betterClosePopup() {
    let popup = document.getElementById('popup');
    if (popup != null){
        popup.classList.replace("open-popup", "popup");
    }
}


// Function to open the comment popup
function openCommentPopup() {
    // Comment popup
    let commentPopup = document.getElementById('comment-popup');
    if (commentPopup != null){
        commentPopup.classList.replace("popup", "open-popup");
    } else {
        console.log("oh, no!");
    }

}

// Function to close the comment popup
function closeCommentPopup() {
    // Comment popup
    let commentPopup = document.getElementById('comment-popup');
    if (commentPopup != null){
        commentPopup.classList.replace("open-popup", "popup");
    } else {
        console.log("oh, no!");
    }
}

// Function to submit the comment
function submitComment() {
    // Reset the comment textbox
    document.getElementById('comment-textbox').value = '';
    // You can handle the comment submission here, e.g., saving the comment.
    closeCommentPopup();
    openPopup();  // Show the submission success popup
}
