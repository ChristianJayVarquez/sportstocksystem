document.addEventListener("DOMContentLoaded", function () {
    const userTableBody = document.getElementById("user-table-body");
    const userSearchInput = document.getElementById("user-search");
    const searchButton = document.getElementById("search-button");
    const prevPageButton = document.getElementById("prev-page");
    const nextPageButton = document.getElementById("next-page");
    const pageInfo = document.getElementById("page-info");
    const usersPerPage = 2;
    let currentPage = 1;

    // Function to fetch user data from the database using AJAX
    function fetchUserData() {
        const searchTerm = userSearchInput.value;
        const currentPage = this.currentPage || 1; // The current page is either the parameter or default to 1

        // Make an AJAX request to a PHP script that fetches user data from the database
        const xhr = new XMLHttpRequest();
        xhr.open("GET", `get_users.php?searchTerm=${searchTerm}&page=${currentPage}`, true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                const userData = JSON.parse(xhr.responseText);
                displayUsersInTable(userData);
            }
        };

        xhr.send();
    }

    // Function to display user information in the table
    function displayUsersInTable(users) {
        userTableBody.innerHTML = "";

        for (let i = 0; i < users.length; i++) {
            const user = users[i];

            const userRow = document.createElement("tr");
            userRow.innerHTML = `
                <td>${user.id}</td>
                <td>${user.name}</td>
                <td>${user.username}</td>
                <td>${user.course}</td>
            `;

            userTableBody.appendChild(userRow);
        }
    }

    // Update page information
    function updatePageInfo() {
        const totalPages = Math.ceil(users.length / usersPerPage);
        pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;
    }

    // Initial display
    fetchUserData();

    // Search for users and display results
    searchButton.addEventListener("click", () => {
        currentPage = 1;
        fetchUserData();
    });

    // Handle paging
    prevPageButton.addEventListener("click", () => {
        if (currentPage > 1) {
            currentPage--;
            fetchUserData();
        }
    });

    nextPageButton.addEventListener("click", () => {
        currentPage++;
        fetchUserData();
    });

});