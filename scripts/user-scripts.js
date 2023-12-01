document.addEventListener("DOMContentLoaded", function () {
    // Button to toggle the sidebar
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

    const homeButton = document.getElementById("homeButton");
    const equipmentsButton = document.getElementById("equipmentsButton");
    const itemsButton = document.getElementById("itemsButton");
    const profileButton = document.getElementById("profileButton");
    const logButton = document.getElementById("logButton");
    const logoutButton = document.getElementById("logoutButton");

    const homeModal = document.getElementById("homeModal");
    const equipmentsModal = document.getElementById("equipmentsModal");
    const itemsModal = document.getElementById("itemsModal");
    const profileModal = document.getElementById("profileModal");
    const logModal = document.getElementById("logModal");
    const logoutModal = document.getElementById("logoutModal");

    // Function to hide the sidebar
    function hideSidebar() {
        sidebar.style.left = "-250px";
        closeSidebarButton.style.display = "none";
    }

    // Function to hide all modals
    function hideAllModals() {
        homeModal.style.display = "none";
        equipmentsModal.style.display = "none";
        itemsModal.style.display = "none";
        profileModal.style.display = "none";
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

    equipmentsButton.addEventListener("click", function () {
        showSpecificModal(equipmentsModal);
    });

    itemsButton.addEventListener("click", function () {
        showSpecificModal(itemsModal);
    });

    profileButton.addEventListener("click", function () {
        showSpecificModal(profileModal);
    });

    logButton.addEventListener("click", function () {
        showSpecificModal(logModal);
    });

    // Function to show the logout modal
    function showLogoutModal() {
        showSpecificModal(logoutModal);
    }

    // Function to handle logout confirmation
    function confirmLogout() {
        window.location.href = "../process/logout.php";
    }

    // Event listener for logout button
    logoutButton.addEventListener("click", showLogoutModal);

    // Event listener for logout confirm button in the logout modal
    const logoutConfirmButton = document.getElementById("logout-confirm-button");
    logoutConfirmButton.addEventListener("click", confirmLogout);

    // Event listener for logout cancel button in the logout modal
    const logoutCancelButton = document.getElementById("logout-cancel-button");
    logoutCancelButton.addEventListener("click", function () {
        showSpecificModal(homeModal); // Show the home modal on cancel
    });
});
