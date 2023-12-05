document.addEventListener('DOMContentLoaded', function() {
  const toggleButton = document.querySelector('.toggle-button');
  const closeButton = document.querySelector('.close-button');
  const body = document.body;

  // Your sidebar buttons
  const homeButton = document.getElementById('home-button');
  const equipmentsButton = document.getElementById('equipment-button');
  const itemsButton = document.getElementById('user-button');
  const profileButton = document.getElementById('borrowing-button');
  const logButton = document.getElementById('settings-button');
  const logoutButton = document.getElementById('logout-button');

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
      // If it's not a mobile device, add the sidebar-open class
      body.classList.add('sidebar-open');
    }
  }

  toggleButton.addEventListener('click', toggleSidebar);

  closeButton.addEventListener('click', function() {
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

  sidebarButtons.forEach(function(button) {
    button.addEventListener('click', function() {
      body.classList.remove('sidebar-open');
    });
  });
});
