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

// Function to submit a comment for a specific audio item and reply to a specific comment
function submitComment(textboxId, containerId, parentId = null) {
    const commentText = parentId
        ? document.querySelector(`#${parentId} .reply-textbox`).value
        : document.getElementById(textboxId).value;

    if (commentText.trim()) {
        const comment = document.createElement('div');
        comment.classList.add('comment');
        comment.textContent = commentText;

        if (!parentId) {
            comment.id = `comment-${Date.now()}`;

            // Add a reply button for main comments
            const replyButton = document.createElement('button');
            replyButton.classList.add('reply-button');
            replyButton.textContent = 'Reply';
            replyButton.onclick = () => toggleReplyTextbox(comment.id);
            comment.appendChild(replyButton);

            // Add a container for replies
            const replyContainer = document.createElement('div');
            replyContainer.classList.add('reply-container');
            comment.appendChild(replyContainer);
        }

        // Append the comment to the correct container
        const targetContainer = parentId
            ? document.querySelector(`#${parentId} .reply-container`)
            : document.getElementById(containerId);
        targetContainer.appendChild(comment);

        // Clear and hide the reply textbox and button after submission
        if (parentId) {
            const replyTextbox = document.querySelector(`#${parentId} .reply-textbox`);
            const submitReplyButton = document.querySelector(`#${parentId} .submit-reply-button`);
            replyTextbox.value = ''; // Clear the textbox
            replyTextbox.style.display = 'none'; // Hide the textbox
            submitReplyButton.style.display = 'none'; // Hide the submit button
        } 
        else {
            document.getElementById(textboxId).value = '';
        }
    }
}

// Function to toggle reply textbox for each comment
function toggleReplyTextbox(commentId) {
    let replyTextbox = document.querySelector(`#${commentId} .reply-textbox`);
    let submitReplyButton = document.querySelector(`#${commentId} .submit-reply-button`);

    if (!replyTextbox) {
        replyTextbox = document.createElement('textarea');
        replyTextbox.classList.add('reply-textbox');
        replyTextbox.placeholder = 'Type your reply...';

        submitReplyButton = document.createElement('button');
        submitReplyButton.classList.add('submit-reply-button');
        submitReplyButton.textContent = 'Submit Reply';
        submitReplyButton.onclick = () => submitComment(null, null, commentId);

        const commentElement = document.getElementById(commentId);
        commentElement.appendChild(replyTextbox);
        commentElement.appendChild(submitReplyButton);
    }
    
    // Toggle display
    replyTextbox.style.display = replyTextbox.style.display === 'none' ? 'block' : 'none';
    submitReplyButton.style.display = submitReplyButton.style.display === 'none' ? 'block' : 'none';
}

// Search comments within the comment thread 
function searchComments(inputId, containerId) {
    const searchTerm = document.getElementById(inputId).value.toLowerCase();
    const comments = document.getElementById(containerId).getElementsByClassName('comment');
    
    Array.from(comments).forEach(comment => {
        if (comment.textContent.toLowerCase().includes(searchTerm)) {
            comment.style.display = ""; // Show matching comment
        } 
        else {
            comment.style.display = "none"; // Hide non-matching comment
        }
    });
}