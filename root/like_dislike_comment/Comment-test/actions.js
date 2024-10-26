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

// Function to open a specific comment popup
function openCommentPopup(popupId) {
    document.getElementById(popupId).classList.add("open-popup");
}

// Function to close a specific comment popup
function closeCommentPopup(popupId) {
    document.getElementById(popupId).classList.remove("open-popup");
}

// Function to submit a comment for a specific audio item
function submitComment(textboxId, containerId) {
    const commentText = document.getElementById(textboxId).value;
    if (commentText.trim()) {
        const comment = document.createElement('div');
        comment.classList.add('comment');
        comment.textContent = commentText;

        // Append the comment to the specific comments container
        document.getElementById(containerId).appendChild(comment);

        // Clear the textbox
        document.getElementById(textboxId).value = '';
    }
}
