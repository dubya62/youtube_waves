
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

let rantIsOpen = false;

function preventEvent(event){
    if (event.target.getAttribute("id") != "comment-popup"){
        event.stopPropagation();
    }
}

let openedCommentClipId = -1;

// Function to open a specific comment popup
function openCommentPopup(clipId) {
    openedCommentClipId = clipId;
    rantIsOpen = true;
    document.getElementById("comment-popup").classList.add("open-popup");

    // make request to get the comments
    let xhttp = new XMLHttpRequest();
    xhttp.onload = function(){
        document.getElementById("comments-container").innerHTML = this.responseText;
    }
    xhttp.open("GET", "get_comments.php?clip_id=" + clipId);
    xhttp.send();

    document.addEventListener("click", preventEvent);
    document.addEventListener("hover", preventEvent);

}

// Function to close a specific comment popup
function closeCommentPopup(clipId) {
    document.getElementById("comment-popup").classList.remove("open-popup");
    openedCommentClipId = -1;

    document.removeEventListener("click", preventEvent);
    document.removeEventListener("hover", preventEvent);
    rantIsOpen = false;
}


// Function to submit a comment for a specific audio item
function submitComment(textboxId, containerId, parentId) {
    if (openedCommentClipId == -1 || openedCommentClipId == null){
        console.log("Comment page must be open!");
        return;
    }
    const commentText = document.getElementById(textboxId).value;
    if (commentText.trim()) {
        const comment = document.createElement('div');
        comment.classList.add('comment');
        comment.textContent = commentText;

        // Append the comment to the specific comments container
        document.getElementById(containerId).appendChild(comment);

        // Clear the textbox
        document.getElementById(textboxId).value = '';

        // send a request to the server to create the comment
        let xhttp = new XMLHttpRequest();
        xhttp.onload = function(){
            console.log("comment sent");
        }
        xhttp.open("POST", "submit_comment.php");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        let sendString = "clip_id=" + openedCommentClipId + "&comment=" + commentText + "&parent=" + parentId;
        console.log(sendString);
        xhttp.send(sendString);

    }
}

// Search comments within the comment thread
function searchComments(inputId, containerId) {
    const searchTerm = document.getElementById(inputId).value.toLowerCase();
    const comments = document.getElementById(containerId).getElementsByClassName('comment');

    Array.from(comments).forEach(comment => {
        let commentText = comment.children[0].contentDocument.body.innerText;
        if (commentText.toLowerCase().includes(searchTerm)) {
            comment.style.display = "block"; // Show matching comment
        }
        else {
            comment.style.display = "none"; // Hide non-matching comment
        }
    });
}

// Function to toggle reply textbox for each comment
function toggleReplyTextbox(commentId) {
    let replyTextbox = document.querySelector(`#comment-${commentId} .reply-textbox`);
    let submitReplyButton = document.querySelector(`#comment-${commentId} .submit-reply-button`);

    if (!replyTextbox) {
        replyTextbox = document.createElement('textarea');
        replyTextbox.classList.add('reply-textbox');
        replyTextbox.placeholder = 'Type your reply...';
        let textBoxId = 'reply-textbox-' + commentId;
        replyTextbox.setAttribute('id', textBoxId);

        submitReplyButton = document.createElement('button');
        submitReplyButton.classList.add('submit-reply-button');
        submitReplyButton.textContent = 'Submit Reply';

        // figure out the textBoxId, containerId, and parentId
        submitReplyButton.onclick = () => submitComment(textBoxId, "comment-" + commentId, commentId);

        const commentElement = document.getElementById("comment-" + commentId);
        commentElement.appendChild(replyTextbox);
        commentElement.appendChild(submitReplyButton);
        return;
    }

    // Toggle display
    replyTextbox.style.display = replyTextbox.style.display === 'none' ? 'block' : 'none';
    submitReplyButton.style.display = submitReplyButton.style.display === 'none' ? 'block' : 'none';


}

