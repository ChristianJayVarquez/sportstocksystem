document.addEventListener('DOMContentLoaded', function () {
  const toggleButton = document.querySelector('.toggle-button');
  const closeButton = document.querySelector('.close-button');
  const body = document.body;

  // Your sidebar buttons
  const homeButton = document.getElementById('homeButton');
  const equipmentsButton = document.getElementById('equipmentsButton');
  const itemsButton = document.getElementById('itemsButton');
  const profileButton = document.getElementById('profileButton');
  const logButton = document.getElementById('logButton');
  const logoutButton = document.getElementById('logoutButton');

  // Function to check if the device is a mobile device
  function isMobileDevice() {
    return window.matchMedia('(max-width: 768px)').matches;
    // Adjust the max-width value according to your specific mobile device requirements
  }

  // Check if the device is a mobile device before adding/removing sidebar-open class
  function toggleSidebar() {
    if (!isMobileDevice()) {
      body.classList.toggle('sidebar-open');
    } else {
      // If it's not a mobile device, do nothing
    }
  }

  toggleButton.addEventListener('click', toggleSidebar);

  closeButton.addEventListener('click', function () {
    body.classList.remove('sidebar-open');
  });

  // Add event listeners to the sidebar buttons
  const sidebarButtons = [
    homeButton,
    equipmentsButton,
    itemsButton,
    profileButton,
    logButton,
    logoutButton,
  ];

  sidebarButtons.forEach(function (button) {
    button.addEventListener('click', function () {
      body.classList.remove('sidebar-open');
    });
  });

  function switchToMobileStyles() {
    const styleSwitch = document.getElementById('styleSwitch');
    const newStyle = `
        /* Media query for mobile responsiveness */
        @media screen and (max-width: 768px) {
            /* Sidebar styles */
            .sidebar {
                /* Existing styles for closed sidebar */
                border: 4px solid #80522F;
                height: auto;
                min-height: 100vh;
                width: 225px;
                position: fixed;
                top: 0;
                left: -250px;
                background: #f2f2f2;
                color: #795548;
                padding-top: 50px;
                transition: padding 0.3s ease; /* Transition for padding */

                /* New styles for open sidebar */
            }

            /* Add styles for open sidebar */
            .sidebar.opened {
                padding-top: 100px; /* Example: Increased padding when sidebar is open */
                transition: none; /* Remove transition when sidebar is open */
            }

            /* Main content styles */
            .main-content {
                margin-left: 0;
                transition: none !important;
            }

            /* Modal container styles */
            .modal-container {
                width: 100%;
                left: 0;
                top: auto;
                transform: none;
                position: relative;
                height: auto;
                flex-direction: column;
                justify-content: flex-start;
                padding: 10px;
            }

            .modal-content {
                max-width: 100%;
                padding: 10px;
                margin: 0;
            }

            /* Updated styles for card container on mobile */
            .card-container {
                flex-direction: column;
                align-items: center;
            }

            .card {
                max-width: 100%;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
                text-align: justify;
                padding: 10px;
                margin-bottom: 10px;
            }

            .card button {
                margin-top: 10px;
            }

            .header-container {
                display: block;
                text-align: center;
                display: flex;
                flex-direction: column;
            }

            .buttons,
            .search {
                position: static;
                margin-top: 10px;
            }
        }
    `;
    styleSwitch.innerHTML = newStyle;
  }

  function adjustLayoutForMobile() {
    // Function to handle the opening/closing of the sidebar and adding/removing the 'opened' class
  }

  function checkDeviceWidth() {
    const isMobile = window.matchMedia("only screen and (max-width: 768px)").matches;
    if (isMobile) {
      switchToMobileStyles();
      adjustLayoutForMobile();
    }
  }

  // Check device width on page load
  window.onload = function () {
    checkDeviceWidth();
  };

  // Check device width when the window is resized
  window.onresize = function () {
    checkDeviceWidth();
  };
});