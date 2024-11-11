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
        {title: "Blank Playlist", clipsIds: []},
        {title: "Me", clipsIds: [1, 2, 3, 4, 5]},
    ]
}

//Causes clips and playlists to be listed on profile page load
window.addEventListener("load", function() {
    listClips();
    listPlaylists();
});

// Function to handle tab switching and content display
function showTab(tab) {
    // Update tab navigation
    document.getElementById("clips-tab").classList.remove("is-active");
    document.getElementById("playlists-tab").classList.remove("is-active");
    document.getElementById(`${tab}-tab`).classList.add("is-active");

    // Update content visibility
    document.getElementById("clips").classList.remove("is-active");
    document.getElementById("playlists").classList.remove("is-active");
    document.getElementById(tab).classList.add("is-active");
}
// Add all of user's clips to profile page from JSON
function listClips() {
    const clipList = document.getElementById("clip-list");
    clipList.innerHTML = "";  // Clear any existing content

    let clips = profileInfo.clips;

    // Add each clip to list on profile.php
    clips.forEach(clip => {
        const clipItem = document.createElement("article");
        clipItem.classList.add("clip-item");

        // Media left (Play Icon)
        const mediaLeft = document.createElement("div");
        mediaLeft.classList.add("play-icon-div");
        const playButton = document.createElement("span");
        playButton.classList.add("clip-play");
        playButton.innerHTML = "▶️";  // Play icon
        mediaLeft.appendChild(playButton);

        // Media content (Clip Title and Time)
        const mediaContent = document.createElement("div");
        mediaContent.classList.add("media-info");

        // Title
        const title = document.createElement("div");
        title.classList.add("clip-title");
        title.textContent = clip.title;
        mediaContent.appendChild(title);

        // Time
        const time = document.createElement("div");
        time.classList.add("clip-time");
        time.textContent = clip.length;
        mediaContent.appendChild(time);

        // Append mediaLeft and mediaContent to clipItem
        clipItem.appendChild(mediaLeft);
        clipItem.appendChild(mediaContent);

        // Append clipItem to clipList
        clipList.appendChild(clipItem);
    });
}

function listPlaylists() {
    let listDiv = document.getElementById("playlists-list");
    let playlistList = profileInfo.playlists;

    // Clear the playlist list before adding new ones
    listDiv.innerHTML = '';

    // Create a row container for the cards
    let rowDiv = document.createElement("div");
    rowDiv.classList.add("row", "gy-4");  // Bootstrap row with gutter between cards

    // Add each playlist as a card
    for (let playlist in playlistList) {
        // Create a column for each card (3 cards per row)
        let colDiv = document.createElement("div");
        colDiv.classList.add("col-md-4", "d-flex");

        // Create a Bootstrap card
        let cardDiv = document.createElement("div");
        cardDiv.classList.add("card", "flex-fill");

        // Playlist Title (Card Header)
        let cardHeader = document.createElement("div");
        cardHeader.classList.add("card-header", "text-center");
        let playlistTitle = document.createElement("h5");
        playlistTitle.classList.add("playlist-name");
        playlistTitle.innerHTML = playlistList[playlist].title;
        cardHeader.appendChild(playlistTitle);

        // Playlist Image (Card Body)
        let cardBody = document.createElement("div");
        cardBody.classList.add("card-body", "p-0");
        let playlistImage = document.createElement("img");
        playlistImage.src = "../img/bara.jpg";  // Placeholder image
        playlistImage.classList.add("img-fluid", "rounded-bottom");

        // Append title and image to the card
        cardDiv.appendChild(cardHeader);
        cardDiv.appendChild(cardBody);
        cardBody.appendChild(playlistImage);

        // Append card to column and column to row
        colDiv.appendChild(cardDiv);
        rowDiv.appendChild(colDiv);
    }

    // Append the row to the listDiv
    listDiv.appendChild(rowDiv);
}

// Function to change active tab on profile page
let viewClipsActive = () => {
    let viewClips = document.getElementById("clips-tab");
    let viewPlaylists = document.getElementById("playlists-tab");
    let clipDiv = document.getElementById("clips");
    let playlistDiv = document.getElementById("playlists");

    viewClips.classList.add("active");
    viewPlaylists.classList.remove("active");
    clipDiv.style.display = "block";
    playlistDiv.style.display = "none";
}

// Function to change active tab on profile page
let viewPlaylistsActive = () => {
    let viewClips = document.getElementById("clips-tab");
    let viewPlaylists = document.getElementById("playlists-tab");
    let clipDiv = document.getElementById("clips");
    let playlistDiv = document.getElementById("playlists");

    viewPlaylists.classList.add("active");
    viewClips.classList.remove("active");
    clipDiv.style.display = "none";
    playlistDiv.style.display = "grid";
}
