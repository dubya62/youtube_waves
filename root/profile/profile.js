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

// Add all of user's clips to profile page from JSON
function listClips() {
    let listDiv = document.getElementById("clip-list");
    let clipList = profileInfo.clips;

    // Clear the clip list before adding new ones
    listDiv.innerHTML = '';

    // Add each clip to list on profile.php
    for (let clip in clipList) {
        // Create a container for each clip
        let clipDiv = document.createElement("div");
        clipDiv.classList.add("d-flex", "justify-content-between", "align-items-center", "mb-3", "p-3");
        clipDiv.style.width = "80vw";  // Set width to 80% of viewport
        clipDiv.style.border = "1px solid #ddd";  // Border around the item
        clipDiv.style.borderRadius = "5px";  // Rounded corners

        // Create play button and wave title container (left-aligned)
        let leftContainer = document.createElement("div");
        leftContainer.classList.add("d-flex", "align-items-center");

        // Play button
        let playButton = document.createElement("button");
        playButton.classList.add("btn", "btn-primary", "me-3");
        playButton.innerHTML = `<i class="fas fa-play"></i>`;  // FontAwesome play icon

        // Wave name (title)
        let clipTitle = document.createElement("span");
        clipTitle.innerHTML = clipList[clip].title;
        clipTitle.classList.add("wave-name", "me-3");

        // Append play button and title to the left container
        leftContainer.appendChild(playButton);
        leftContainer.appendChild(clipTitle);

        // Create time container (right-aligned)
        let clipTime = document.createElement("span");
        clipTime.innerHTML = clipList[clip].length;
        clipTime.classList.add("wave-time");

        // Append left container and time to the clipDiv
        clipDiv.appendChild(leftContainer);
        clipDiv.appendChild(clipTime);

        // Append clipDiv to the listDiv
        listDiv.appendChild(clipDiv);
    }
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
