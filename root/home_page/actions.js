
// function to increment Follower count
function incrementFollow(clip_id) {
    // make ajax call to either like or unlike
    let followElement = document.getElementById("follow-counter-" + clip_id);
    let xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        if (this.responseText == "-1"){ // this unliked it
            // change the button color
            followElement.classList.remove("liked");
            followElement.classList.add("notLiked");
            followElement.textContent = parseInt(followElement.textContent) - 1;
        } else if (this.responseText == "1"){ // this liked it
            // change the button color
            followElement.classList.remove("notLiked");
            followElement.classList.add("liked");
            followElement.textContent = parseInt(followElement.textContent) + 1;
        }

    }
    xhttp.open("GET", "follow_clip.php?clip_id=" + clip_id);
    xhttp.send();
}

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

// Function to increment LIKE count for a comment
function incrementLikeComment(comment_id) {
    
    let likeElement = document.getElementById("comment-like-counter-" + comment_id);
    let xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        if (this.responseText == "-1") { 
            
            likeElement.classList.remove("liked");
            likeElement.classList.add("notLiked");
            likeElement.textContent = parseInt(likeElement.textContent) - 1;
        } 
        else if (this.responseText == "1") { 

            likeElement.classList.remove("notLiked");
            likeElement.classList.add("liked");
            likeElement.textContent = parseInt(likeElement.textContent) + 1;
        }
    };
    xhttp.open("GET", "like_comment.php?action=1&comment_id=" + comment_id);
    xhttp.send();
}

// Function to increment DISLIKE count for a comment
function incrementDislikeComment(comment_id) {
    
    let dislikeElement = document.getElementById("comment-dislike-counter-" + comment_id);
    let xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        if (this.responseText == "-0") { 

            dislikeElement.classList.remove("disliked");
            dislikeElement.classList.add("notDisliked");
            dislikeElement.textContent = parseInt(dislikeElement.textContent) - 1;
        } 
        else if (this.responseText == "0") { 
            
            dislikeElement.classList.remove("notDisliked");
            dislikeElement.classList.add("disliked");
            dislikeElement.textContent = parseInt(dislikeElement.textContent) + 1;
        }
    };
    xhttp.open("GET", "like_comment.php?action=0&comment_id=" + comment_id);
    xhttp.send();
}

// Function to delete a comment
function deleteComment(comment_id) {
    if (!confirm("Are you sure you want to delete this comment?")) return; 

    let xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        if (this.status === 200) {
            
            document.getElementById("comment-" + comment_id).remove();
            console.log("Comment deleted successfully.");
        } 
        else {
            console.error("Failed to delete comment.");
        }
    };
    xhttp.onerror = function () {
        console.error("AJAX request failed for deleteComment.");
    };
    xhttp.open("POST", "delete_comment.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("comment_id=" + comment_id);
}


// Function to delete a clip 
function deleteClip(clip_id) {
    if (!confirm("Are you sure you want to delete this clip?")) return;

    let xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        if (this.status === 200) {
            document.getElementById("clip-" + clip_id).remove();
            console.log("Clip deleted successfully.");
        } 
        else {
            console.error("Failed to delete clip.");
        }
    };
    xhttp.onerror = function () {
        console.error("AJAX request failed for deleteClip.");
    };
    xhttp.open("POST", "delete_clip.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("clip_id=" + clip_id);
}



let rantIsOpen = false;

function preventEvent(event){
    if (event.target.getAttribute("id") != "comment-popup"){
        event.stopPropagation();
    }
}

let openedCommentClipId = -1;

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

async function convertTimestamps(){
    for (let i=0; i<window.frames.length; i++){
        if (window.frames[i].document.body != null){
            let commentElement = window.frames[i].document.body.children[0];

            if (commentElement != undefined){
                if (commentElement.tagName == "PRE"){
                    let commentText = commentElement.innerHTML;

                    let newText = commentText.replace(/\d+:\d{1,2}/gi, `<strong style='color:blue'><u>$&</u></strong>`);
                    window.frames[i].document.body.innerHTML = newText;

                    let strongs = window.frames[i].document.body.getElementsByTagName("strong");
                    for (let j=0; j<strongs.length; j++){
                        strongs[j].addEventListener("click", function (){
                            console.log("Hello");
                            changeTime(window.frames[i].window.location.pathname, strongs[j].children[0].innerHTML);
                        });
                    }
                }
            } else {
                await sleep(25);
                i -= 1;
            }
        }

    }
}

function changeTime(commentId, timeValue){
    let comment_id = commentId.split("/")
    comment_id = comment_id[comment_id.length-1]

    // make request to get the corresponding clipId
    let clipNumber;
    let xhttp = new XMLHttpRequest();
    xhttp.onload = function(){
        clipNumber = this.responseText.trim();
        console.log(clipNumber);
    }
    xhttp.open("GET", "get_comment_clip.php?comment_id=" + comment_id, false);
    xhttp.send();

    let splitted = timeValue.split(":");
    let convertedTimeValue = parseInt(splitted[0]) * 60 + parseInt(splitted[1]);

    document.getElementById("audio-" + clipNumber).currentTime = convertedTimeValue;
    document.getElementById("audio-" + clipNumber).play();
}

// Function to open a specific comment popup
async function openCommentPopup(clipId) {
    openedCommentClipId = clipId;
    rantIsOpen = true;
    document.getElementById("comment-popup").classList.add("open-popup");

    // make request to get the comments
    let xhttp = new XMLHttpRequest();
    xhttp.onload = function(){
        let commentsContainer = document.getElementById("comments-container");
        commentsContainer.innerHTML = this.responseText;
        eval(document.getElementById("comments-container").getElementsByTagName("script")[0].textContent);

    }
    xhttp.open("GET", "get_comments.php?clip_id=" + clipId, false);
    xhttp.send();

    document.addEventListener("click", preventEvent);
    document.addEventListener("hover", preventEvent);

    await convertTimestamps();
}

// Function to close a specific comment popup
function closeCommentPopup(clipId) {
    document.getElementById("comment-popup").classList.remove("open-popup");
    openedCommentClipId = -1;

    document.removeEventListener("click", preventEvent);
    document.removeEventListener("hover", preventEvent);
    rantIsOpen = false;

}


function submitComment(textboxId, containerId, parentId) {
    if (openedCommentClipId === -1 || openedCommentClipId === null) {
        console.log("Comment page must be open!");
        return;
    }

    const commentText = document.getElementById(textboxId).value;
    const commentImage = document.getElementById('upload-file-input').files[0]; // Retrieve the selected image file

    const formData = new FormData();
    formData.append("clip_id", openedCommentClipId);
    formData.append("comment", commentText);
    formData.append("parent", parentId);

    if (commentImage) {
        formData.append("comment_image", commentImage); // Include image in form data
    }

    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (xhttp.status === 200) {
            const response = JSON.parse(xhttp.responseText);
            const comment = document.createElement('div');
            comment.classList.add('comment');

            let commentHTML = `<p>${commentText}</p>`;
            if (response.imageURL) {
                commentHTML += `<img src="${response.imageURL}" alt="Image" style="max-width: 100%; border-radius: 10px;">`;
            }
            comment.innerHTML = commentHTML;

            document.getElementById(containerId).appendChild(comment);

            document.getElementById(textboxId).value = '';
            document.getElementById("file-upload").value = '';
            document.getElementById("upload-file-input").value = ''; // Clear file input
            document.getElementById("upload-preview-container").innerHTML = '';
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
function previewFileUpload() {
    const file = document.getElementById('upload-file-input').files[0];
    const previewContainer = document.getElementById("upload-preview-container");

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewContainer.innerHTML = `<img src="${e.target.result}" alt="Preview" style="max-width: 100%; border-radius: 10px;">`;
        };
        reader.readAsDataURL(file);
    } else {
        previewContainer.innerHTML = '';
    }
}

function openUploadPopup() {
    document.getElementById("upload-popup").classList.add("open-popup");
}

function closeUploadPopup() {
    document.getElementById("upload-popup").classList.remove("open-popup");
    document.getElementById("upload-preview-container").innerHTML = ''; 
    document.getElementById("upload-file-input").value = ''; 
}




