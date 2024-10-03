let likeCount = 0;
let dislikeCount = 0;

// function to increment the LIKE count when the user clicks on the LIKE button
function incrementLike() {
    likeCount++;
    document.getElementById('like-counter').textContent = likeCount;
}

// function to increment the DISLIKE count when the user clicks on the DISLIKE button
function incrementDislike() {
    dislikeCount++;
    document.getElementById('dislike-counter').textContent = dislikeCount;
}


let popup = document.getElementById('popup');

// function to open the popup window when the user clicks on the RANT button
function openPopup() {
    popup.classList.add("open-popup");
}

// function to close the popup window when the user clicks on the OK button 
function closePopup() {
    popup.classList.remove("open-popup");
}
