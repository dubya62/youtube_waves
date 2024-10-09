let profileInfo = {
    id: 1,
    username: "NotACapybara",
    password: "dontlookatthis",
    description: "This is my profile description",
    subscriptions: [
        {id:2, subscription: 1}, 
        {id:3, subscription: 2}, 
    ],
    liked: [

    ],
    clips: [
        {id: 1, title: "How to be a capybara", length:"3:45"},
        {id: 2, title: "The art of balancing oranges on a head", length:"5:12"},
        {id: 3, title: "Serenity in a wooden barrel: a dialogue", length:"2:33"},
        {id: 4, title: "Why we do nothing, and why you should too", length:"8:56"},
        {id: 5, title: "Serenity in a wooden barrel: a dialogue (part 2)", length:"4:15"},
    ],
    playlists: [
        {title: "About Capybaras", clipsIds: [1, 4]},
        {title: "Ancient History", clipsIds: [2, 3, 5]},
        {title: "Blank Playlist", clipsIds: []}
    ]
}

//Causes clips and playlists to be listed on profile page load
window.addEventListener("load", function() {
    listClips();
    listPlaylists();
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
        clipTitle.classList.add("wave-name");
        let clipTime = document.createElement("p");
        clipTime.innerHTML = clipList[clip].length;
        clipTime.classList.add("wave-time");

        // Append all divs to page
        clipDiv.appendChild(clipTitle);
        clipDiv.appendChild(clipTime);
        listDiv.appendChild(clipDiv);
    }
    
}

function listPlaylists() {
    let listDiv = document.getElementById("playlists-list");
    let playlistList = profileInfo.playlists;
    // Add each to list on profile.php
    for (playlist in playlistList) {
        let playlistDiv = document.createElement("div");
        playlistDiv.classList.add("playlist-list-item");
        // Add id for filtering later
        playlistDiv.id = `playlist-${playlistList[playlist].title}`;

        // Add placeholder image
        let playlistImage = document.createElement("img");
        playlistImage.src = "../img/bara.jpg";

        // Put title in div
        let playlistTitle = document.createElement("p");
        playlistTitle.classList.add("playlist-name");
        playlistTitle.innerHTML = playlistList[playlist].title;
        console.log(playlistList[playlist].title);

        // Append all divs to page
        playlistDiv.appendChild(playlistTitle);
        playlistDiv.appendChild(playlistImage);
        listDiv.appendChild(playlistDiv);
    }
}

// Function to change active tab on profile page
let viewClipsActive = () => {
    let viewClips = document.getElementById("show-clips");
    let viewPlaylists = document.getElementById("show-playlists");
    let clipDiv = document.getElementById("clip-list");
    let playlistDiv = document.getElementById("playlists-list");

    viewClips.classList.add("active");
    viewPlaylists.classList.remove("active");
    clipDiv.style.display = "block";
    playlistDiv.style.display = "none";
}

// Function to change active tab on profile page
let viewPlaylistsActive = () => {
    let viewClips = document.getElementById("show-clips");
    let viewPlaylists = document.getElementById("show-playlists");
    let clipDiv = document.getElementById("clip-list");
    let playlistDiv = document.getElementById("playlists-list");

    viewPlaylists.classList.add("active");
    viewClips.classList.remove("active");
    clipDiv.style.display = "none";
    playlistDiv.style.display = "grid";
}
