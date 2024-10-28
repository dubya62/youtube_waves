// Get popup elements
const openPopupBtn = document.getElementById("upload-button");
const popupForm = document.getElementById("popupForm");
const closePopup = document.querySelector(".close");

// Open popup on button click
openPopupBtn.addEventListener("click", function() {
    popupForm.style.display = "block";
});

// Close popup when 'x' is clicked
closePopup.addEventListener("click", function() {
    popupForm.style.display = "none";
    //location.reload();
});

// Close popup when clicking outside of the popup content
window.addEventListener("click", function(event) {
    if (event.target === popupForm) {
        popupForm.style.display = "none";
    }
});

// Handle form submission
document.getElementById("uploadForm").addEventListener("submit", function(event) {
    //event.preventDefault();
    alert("Wave submitted! Good Luck...");
    popupForm.style.display = "none"; // Close the popup after submission
});
