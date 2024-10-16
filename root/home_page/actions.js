let counters = {
    'like-counter-1': 0,
    'dislike-counter-1': 0,
    'like-counter-2': 0,
    'dislike-counter-2': 0,
    'like-counter-3': 0,
    'dislike-counter-3': 0,
    'like-counter-4': 0,
    'dislike-counter-4': 0,
    'like-counter-5': 0,
    'dislike-counter-5': 0,
    'like-counter-6': 0,
    'dislike-counter-6': 0,
};

// Function to increment LIKE count
function incrementLike(counterId) {
    counters[counterId]++;
    document.getElementById(counterId).textContent = counters[counterId];
}

// Function to increment DISLIKE count
function incrementDislike(counterId) {
    counters[counterId]++;
    document.getElementById(counterId).textContent = counters[counterId];
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