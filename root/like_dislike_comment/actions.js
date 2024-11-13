let likeCount = 0;
let dislikeCount = 0;

// Function to increment LIKE count
function incrementLike() {
    likeCount++;
    document.getElementById('like-counter').textContent = likeCount;
}

// Function to increment DISLIKE count
function incrementDislike() {
    dislikeCount++;
    document.getElementById('dislike-counter').textContent = dislikeCount;
}

// Popup for Rant submission
let popup = document.getElementById('popup');

// Function to open the submission popup
function openPopup() {
    popup.classList.add("open-popup");
}

// Function to close the submission popup
function closePopup() {
    popup.classList.remove("open-popup");
}

// Comment popup
let commentPopup = document.getElementById('comment-popup');

// Function to open the comment popup
function openCommentPopup() {
    commentPopup.classList.add("open-popup");
}

// Function to close the comment popup
function closeCommentPopup() {
    commentPopup.classList.remove("open-popup");
}

// Function to submit the comment
function submitComment() {
    // Reset the comment textbox
    document.getElementById('comment-textbox').value = '';
    // You can handle the comment submission here, e.g., saving the comment.
    closeCommentPopup();
    openPopup();  // Show the submission success popup
}

// Share popup for sharing the clips
function shareClip() {
    openPopup();  
}
