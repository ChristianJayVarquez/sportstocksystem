document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.querySelector('.toggle-button');
    const closeButton = document.querySelector('.close-button');
    const body = document.body;
  
    // Your sidebar buttons
    const homeButton = document.getElementById('home-button');
    const equipmentButton = document.getElementById('equipment-button');
    const userButton = document.getElementById('user-button');
    const borrowButton = document.getElementById('borrowing-button');
    const logButton = document.getElementById('settings-button');
    const logoutButton = document.getElementById('logout-button');
  
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
      equipmentButton,
      userButton,
      borrowButton,
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
  