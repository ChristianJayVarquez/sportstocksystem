// JavaScript for showing inner modals
const innerModalButtons = {
    "innerModalA-button": "innerModalA",
    "innerModalU-button": "innerModalU",
    "innerModal-button": "innerModal",
    "innerModalB-button": "innerModalB"
};

// Function to show an inner modal by ID
function showInnerModalById(modalId) {
    // Show the specified inner modal
    const modal = document.getElementById(modalId);
    modal.style.display = "block";
}

// Add click event listeners to the buttons
for (const buttonId in innerModalButtons) {
    const button = document.getElementById(buttonId);
    const modalId = innerModalButtons[buttonId];

    button.addEventListener("click", () => {
        // Show the corresponding inner modal
        showInnerModalById(modalId);
    });
}

// Close the inner modal when the close button is clicked
const closeButtons = document.querySelectorAll(".modal-contents .close");

closeButtons.forEach(button => {
    button.addEventListener("click", () => {
        const modal = button.closest(".modal-contents");
        modal.style.display = "none";
    });
});

// Close the inner modal when the overlay is clicked
const innerModals = document.querySelectorAll(".modal-contents");

innerModals.forEach(modal => {
    modal.addEventListener("click", (event) => {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});
