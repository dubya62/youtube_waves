let profileInfo = {
    id: 1,
    username: "UserDude",
    password: "dontlookatthis",
    description: "This is my profile description",
    subscriptions: [
        {id:2, subscription: 1}, 
        {id:3, subscription: 2}, 
    ],
    liked: [

    ],
    clips: [
        {id: 1, title: "Clip 1", length:"3:45"},
        {id: 2, title: "Clip 2", length:"5:12"},
        {id: 3, title: "Clip 3", length:"2:33"},
    ]
}

window.addEventListener("load", function() {
    listClips();
});

// Add all of user's clips to profile page from JSON
function listClips() {
    let listDiv = document.getElementById("clip-list");
    let clipList = profileInfo.clips;
    // Add each to list on profile.php
    for (clip in clipList) {
        let clipDiv = document.createElement("div");
        clipDiv.classList.add("clip-list-item");
        // Add id for filtering later
        clipDiv.id = `clip-${clipList[clip].id}`;

        // Put title and time in div
        let clipTitle = document.createElement("p");
        clipTitle.innerHTML = clipList[clip].title;
        let clipTime = document.createElement("p");
        clipTime.innerHTML = clipList[clip].length;

        // Append all divs to page
        clipDiv.appendChild(clipTitle);
        clipDiv.appendChild(clipTime);
        listDiv.appendChild(clipDiv);
    }
    
}

// Function to change active tab on profile page
let viewClipsActive = () => {
    let viewClips = document.getElementById("show-clips");
    ¡

    viewClips.classList.add("active");
    viewSubs.classList.remove("active");
    viewLiked.classList.remove("active");
}