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
        {id: 1, title: "Clip 1"},
        {id: 2, title: "Clip 2"},
        {id: 3, title: "Clip 3"},
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
        // Add id for filtering later
        clipDiv.id = `clip-${clipList[clip].id}`;
        clipDiv.innerHTML = clipList[clip].title;
        listDiv.appendChild(clipDiv);
    }
    
}