document.addEventListener("DOMContentLoaded", function () {
    // Button to toggle the sidebar
    const toggleSidebarButton = document.getElementById("toggleSidebarButton");
    const closeSidebarButton = document.getElementById("closeSidebarButton");
    const sidebar = document.querySelector(".sidebar");

    toggleSidebarButton.addEventListener("click", function() {
        sidebar.style.left = "0";
        closeSidebarButton.style.display = "block";
    });

    closeSidebarButton.addEventListener("click", function() {
        sidebar.style.left = "-250px";
        closeSidebarButton.style.display = "none";
    });
    
    const homeButton = document.getElementById("home-button");
    const equipmentButton = document.getElementById("equipment-button");
    const userButton = document.getElementById("user-button");
    const borrowButton = document.getElementById("borrowing-button");
    const logButton = document.getElementById("settings-button");
    const logoutButton = document.getElementById("logout-button");

    const homeModal = document.getElementById("home-modal");
    const equipmentModal = document.getElementById("equipment-modal");
    const userModal = document.getElementById("user-modal");
    const borrowModal = document.getElementById("borrowing-modal");
    const logModal = document.getElementById("settings-modal");
    const logoutModal = document.getElementById("logout-modal");

    // Function to hide the sidebar
    function hideSidebar() {
        sidebar.style.left = "-250px";
        closeSidebarButton.style.display = "none";
    }

    // Function to hide all modals
    function hideAllModals() {
        homeModal.style.display = "none";
        equipmentModal.style.display = "none";
        userModal.style.display = "none";
        borrowModal.style.display = "none";
        logModal.style.display = "none";
        logoutModal.style.display = "none";
    }

    // Function to show a specific modal
    function showSpecificModal(modal) {
        hideSidebar(); // Hide the sidebar
        hideAllModals();
        modal.style.display = "block";
        // Store the active modal in localStorage
        localStorage.setItem("activeModal", modal.id);
    }

    // Show the Home modal by default, or the last active modal from localStorage
    const lastActiveModalId = localStorage.getItem("activeModal");
    if (lastActiveModalId) {
        const lastActiveModal = document.getElementById(lastActiveModalId);
        showSpecificModal(lastActiveModal);
    } else {
        showSpecificModal(homeModal);
    }

    // Event listeners for sidebar buttons
    homeButton.addEventListener("click", function () {
        showSpecificModal(homeModal);
    });

    equipmentButton.addEventListener("click", function () {
        showSpecificModal(equipmentsModal);
    });

    userButton.addEventListener("click", function () {
        showSpecificModal(itemsModal);
    });

    borrowButton.addEventListener("click", function () {
        showSpecificModal(profileModal);
    });

    logButton.addEventListener("click", function () {
        showSpecificModal(logModal);
    });

    logoutButton.addEventListener("click", function () {
        showSpecificModal(logoutModal);
    });
});
