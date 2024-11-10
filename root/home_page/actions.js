
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
        eval(document.getElementById("comments-container").getElementsByTagName("script")[0].textContent);
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


// Function to submit a comment with optional image for a specific audio item
function submitComment(textboxId, containerId, parentId) {
    if (openedCommentClipId == -1 || openedCommentClipId == null) {
        console.log("Comment page must be open!");
        return;
    }

    const commentText = document.getElementById(textboxId).value;
    const commentImage = document.getElementById('file-upload').files[0];

    // Prepare FormData for comment text and optional image
    const formData = new FormData();
    formData.append("clip_id", openedCommentClipId);
    formData.append("comment", commentText);
    formData.append("parent", parentId);

    if (commentImage) {
        formData.append("comment-image", commentImage); // Include image in the form data
    }

    // Send comment and image data to the server
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (xhttp.status === 200) {
            console.log("Comment and image sent to server");

            // Display the comment with the image in the comment thread
            let commentDisplay = commentText;
            if (commentImage) {
                const imageURL = URL.createObjectURL(commentImage);
                commentDisplay += `<br><img src="${imageURL}" alt="Image" style="max-width: 100%; border-radius: 10px;">`;
            }

            const comment = document.createElement('div');
            comment.classList.add('comment');
            comment.innerHTML = commentDisplay;

            document.getElementById(containerId).appendChild(comment);

            // Clear the input fields
            document.getElementById(textboxId).value = '';
            document.getElementById("file-upload").value = '';
            document.getElementById("preview-container").innerHTML = '';
        } else {
            console.error("Failed to send comment");
        }
    };

    xhttp.open("POST", "submit_comment.php", true);
    xhttp.send(formData);
}


// Search comments within the comment thread
function searchComments(inputId, containerId) {
    const searchTerm = document.getElementById(inputId).value.toLowerCase();
    const comments = document.getElementById(containerId).getElementsByClassName('comment');

    Array.from(comments).forEach(comment => {
        let commentText = comment.children[0].children[0].contentDocument.body.innerText;
        if (commentText.toLowerCase().includes(searchTerm)) {
            comment.children[0].style.display = "block"; // Show matching comment
        }
        else {
            comment.children[0].style.display = "none"; // Hide non-matching comment
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

/* Share audio clip */
function shareAudio(clipId) {
    const audioElement = document.querySelector(`#clip-${clipId} audio`);
    const audioURL = audioElement.querySelector("source").src;

    if (navigator.share) {
        navigator.share({
            title: 'Check out this audio clip!',
            text: 'Listen to this amazing audio clip!',
            url: audioURL
        })
        .then(() => console.log('Audio shared successfully'))
        .catch(error => console.error('Error sharing audio:', error));
    } 
    else {
        navigator.clipboard.writeText(audioURL)
            .then(() => alert('Audio link copied to clipboard!'))
            .catch(error => console.error('Error copying link:', error));
    }
}




/* i love breaking things and not fixing them 2 */
// Function to open the upload popup
function openUploadPopup() {
    document.getElementById("upload-popup").classList.add("open-popup");
}

// Function to close the upload popup
function closeUploadPopup() {
    document.getElementById("upload-popup").classList.remove("open-popup");
    // Clear the file input and preview in the popup
    document.getElementById("upload-file-input").value = '';
    document.getElementById("upload-preview-container").innerHTML = '';
}

// Function to preview the selected file within the upload popup
function previewFileUpload() {
    const fileInput = document.getElementById("upload-file-input");
    const previewContainer = document.getElementById("upload-preview-container");

    // Clear any previous preview
    previewContainer.innerHTML = '';

    if (fileInput.files && fileInput.files[0]) {
        const file = fileInput.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = 'Image preview';
            img.style.maxWidth = '100%';
            img.style.borderRadius = '10px';

            previewContainer.appendChild(img);
        };

        reader.readAsDataURL(file);
    }
}

// Function to copy the selected image to the main file input for submission
function submitImgGif() { 
    const fileInput = document.getElementById("upload-file-input");

    if (fileInput.files && fileInput.files[0]) {
        const commentFileInput = document.getElementById("file-upload");   
        commentFileInput.files = fileInput.files;

        // Display preview in the main RANT section's preview container
        const mainPreviewContainer = document.getElementById("preview-container");
        const reader = new FileReader();

        mainPreviewContainer.innerHTML = ''; // Clear previous preview

        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = 'Selected image preview';
            img.style.maxWidth = '100%';
            img.style.borderRadius = '10px';

            mainPreviewContainer.appendChild(img);
        };

        reader.readAsDataURL(fileInput.files[0]);

        // Close the upload popup
        closeUploadPopup();
    } else {
        alert('Please select an image or GIF to upload.');
    }
}




