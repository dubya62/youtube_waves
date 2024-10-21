let likeCount = 0;
let dislikeCount = 0;

// Function to increment LIKE count
function incrementLike() {
    likeCount++;
    const likeCounter = document.getElementById('like-counter');
    likeCounter.textContent = likeCount;
    likeCounter.style.color = "red"; // Force red color
}

// Function to increment DISLIKE count
function incrementDislike() {
    dislikeCount++;
    const dislikeCounter = document.getElementById('dislike-counter');
    dislikeCounter.textContent = dislikeCount;
    dislikeCounter.style.color = "red"; // Force red color
}

// Function to open the comment popup for the rant
function openCommentPopup() {
    document.getElementById("comment-popup").classList.add("open-popup");
}

// Function to close the comment popup
function closeCommentPopup() {
    document.getElementById("comment-popup").classList.remove("open-popup");
}

// Function to submit the comment
function submitComment() {
    const commentText = document.getElementById('comment-textbox').value;
    if (commentText.trim()) {
        // Create a new comment element
        const comment = document.createElement('div');
        comment.classList.add('comment');
        comment.textContent = commentText;

        // Append the new comment to the comments container
        document.getElementById('comments-container').appendChild(comment);

        // Reset the comment textbox
        document.getElementById('comment-textbox').value = '';

        // Show the comment thread section inside the popup
        document.getElementById('comment-thread').style.display = 'block';
    }
}
