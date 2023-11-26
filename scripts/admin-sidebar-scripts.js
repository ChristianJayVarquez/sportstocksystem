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
  
    toggleButton.addEventListener('click', function() {
      if (body.classList.contains('sidebar-open')) {
        body.classList.remove('sidebar-open');
      } else {
        body.classList.add('sidebar-open');
      }
    });
  
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
  