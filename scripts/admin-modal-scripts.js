document.addEventListener("DOMContentLoaded", function () {
    // Sidebar code
    const toggleSidebarButton = document.getElementById("toggleSidebarButton");
    const closeSidebarButton = document.getElementById("closeSidebarButton");
    const sidebar = document.querySelector(".sidebar");

    toggleSidebarButton.addEventListener("click", function () {
        sidebar.style.left = "0";
        closeSidebarButton.style.display = "block";
    });

    closeSidebarButton.addEventListener("click", function () {
        sidebar.style.left = "-250px";
        closeSidebarButton.style.display = "none";
    });

    const sidebarButtons = [
        document.getElementById("home-button"),
        document.getElementById("equipment-button"),
        document.getElementById("user-button"),
        document.getElementById("borrowing-button"),
        document.getElementById("settings-button"),
        document.getElementById("logout-button")
    ];

    sidebarButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            sidebar.style.left = "-250px";
            closeSidebarButton.style.display = "none";
        });
    });

    // Modals code
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
        modalContainers.forEach(container => container.style.display = "none");
        const modal = document.getElementById(modalId);
        modal.style.display = "block";
    }

    // Function to show the default or stored modal
    function showStoredModal() {
        const storedModalId = localStorage.getItem("currentModalId");
        removeActiveClassFromButtons();

        if (storedModalId && modalButtons[storedModalId]) {
            const button = document.getElementById(storedModalId);
            button.classList.add("active");
            showModalById(modalButtons[storedModalId]);
        } else {
            const homeButton = document.getElementById("home-button");
            homeButton.classList.add("active");
            showModalById("home-modal");
        }
    }

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
            removeActiveClassFromButtons();
            button.classList.add("active");
            localStorage.setItem("currentModalId", buttonId);
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
        localStorage.removeItem("currentModalId");
        document.getElementById("logout-modal").style.display = "none";
        showStoredModal();
    });

    window.addEventListener("click", (event) => {
        if (event.target === document.querySelector(".modal-container")) {
            modalContainers.forEach(container => container.style.display = "none");
            localStorage.removeItem("currentModalId");
            removeActiveClassFromButtons();
        }
    });

    showStoredModal(); // Call the function to show the default or stored modal
});
