document.addEventListener('DOMContentLoaded', function() {
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
  
    toggleButton.addEventListener('click', function() {
      if (body.classList.contains('sidebar-open')) {
        body.classList.remove('sidebar-open');
        body.classList.add('sidebar-closed');
      } else {
        body.classList.add('sidebar-open');
        body.classList.remove('sidebar-closed');
      }
    });
  
    closeButton.addEventListener('click', function() {
      body.classList.remove('sidebar-open');
      body.classList.add('sidebar-closed');
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
        body.classList.add('sidebar-closed');
      });
    });
  });
  