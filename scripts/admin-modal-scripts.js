// JavaScript for modals
const modalContainers = document.querySelectorAll(".modal-container");
const modalButtons = {
    "home-button": "home-modal",
    "equipment-button": "equipment-modal",
    "user-button": "user-modal",
    "borrowing-button": "borrowing-modal",
    "settings-button": "settings-modal",
    "logout-button": "logout-modal"
};

// Function to show a modal by ID
function showModalById(modalId) {
    // Hide all modal containers
    modalContainers.forEach(container => container.style.display = "none");

    // Show the specified modal
    const modal = document.getElementById(modalId);
    modal.style.display = "block";
}

// Function to show the default or stored modal
function showStoredModal() {
    // Check if there is a stored modal ID in localStorage
    const storedModalId = localStorage.getItem("currentModalId");

    // Remove "active" class from all buttons
    removeActiveClassFromButtons();

    if (storedModalId && modalButtons[storedModalId]) {
        // Show the stored modal if it exists in the modalButtons object
        const button = document.getElementById(storedModalId);
        button.classList.add("active");
        showModalById(modalButtons[storedModalId]);
    } else {
        // Show the Home modal by default
        const homeButton = document.getElementById("home-button");
        homeButton.classList.add("active");
        showModalById("home-modal");
    }
}

// Call the function to show the default or stored modal
showStoredModal();

// Function to remove "active" class from all buttons
function removeActiveClassFromButtons() {
    for (const buttonId in modalButtons) {
        const button = document.getElementById(buttonId);
        button.classList.remove("active");
    }
}

for (const buttonId in modalButtons) {
    const button = document.getElementById(buttonId);
    const modalId = modalButtons[buttonId];

    button.addEventListener("click", () => {
        // Remove "active" class from all buttons
        removeActiveClassFromButtons();

        // Add "active" class to the clicked button
        button.classList.add("active");

        // Store the clicked modal ID in localStorage
        localStorage.setItem("currentModalId", buttonId);

        // Show the clicked modal container
        showModalById(modalId);
    });
}

// Log out confirmation buttons
const logoutConfirmButton = document.getElementById("logout-confirm-button");
const logoutCancelButton = document.getElementById("logout-cancel-button");

logoutConfirmButton.addEventListener("click", () => {
    window.location.href = "../view/index.html?toasterMessage=You%20have%20Logged%20Out%20Successfully";
});

logoutCancelButton.addEventListener("click", () => {
    // Clear the stored modal ID when canceling logout
    localStorage.removeItem("currentModalId");

    document.getElementById("logout-modal").style.display = "none";
    showStoredModal(); // Show the default or stored modal after canceling logout
});

window.addEventListener("click", (event) => {
    if (event.target === document.querySelector(".modal-container")) {
        modalContainers.forEach(container => container.style.display = "none");
        // Clear the stored modal ID when clicking outside of modals
        localStorage.removeItem("currentModalId");
        removeActiveClassFromButtons();
    }
});
