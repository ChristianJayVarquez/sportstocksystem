document.addEventListener("DOMContentLoaded", function () {
    const msgButton = document.getElementById("msgButton");
    const loginButton = document.getElementById("loginButton");
    const registerButton = document.getElementById("registerButton");
    const msgModal = document.getElementById("msgModal");
    const loginModal = document.getElementById("loginModal");
    const registerModal = document.getElementById("registerModal");
    const loginForm = document.getElementById("loginForm");

    // Function to set the active tab and manage "active" class
    const setActiveTab = (tabName, activeButton, inactiveButton1, inactiveButton2) => {
        activeButton.classList.add("active");
        inactiveButton1.classList.remove("active");
        inactiveButton2.classList.remove("active");

        msgModal.style.display = "none";
        loginModal.style.display = "none";
        registerModal.style.display = "none";

        if (tabName === "login") {
            loginModal.style.display = "block";
        } else if (tabName === "register") {
            registerModal.style.display = "block";
        } else {
            msgModal.style.display = "block";
        }
    };

    // Check local storage for the active tab and set it
    const activeTab = localStorage.getItem("activeTab") || "msg"; // Default to "msg"
    if (activeTab === "msg") {
        setActiveTab("msg", msgButton, loginButton, registerButton);
    } else if (activeTab === "login") {
        setActiveTab("login", loginButton, msgButton, registerButton);
    } else if (activeTab === "register") {
        setActiveTab("register", registerButton, msgButton, loginButton);
    }

    // Add event listeners to the tab buttons
    msgButton.addEventListener("click", function () {
        localStorage.setItem("activeTab", "msg");
        setActiveTab("msg", msgButton, loginButton, registerButton);
    });

    loginButton.addEventListener("click", function () {
        localStorage.setItem("activeTab", "login");
        setActiveTab("login", loginButton, msgButton, registerButton);
    });

    registerButton.addEventListener("click", function () {
        localStorage.setItem("activeTab", "register");
        setActiveTab("register", registerButton, msgButton, loginButton);
    });

    // Handle form submission (Actual login)
    loginForm.addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent the form from submitting

        // Get the user's input
        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;

        // Create an object to send via POST request
        const formData = new FormData();
        formData.append("username", username);
        formData.append("password", password);

        // Send the user's input to the server for validation
        fetch("../process/login.php", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    // Redirect to the appropriate interface based on user role
                    if (data.role === "admin") {
                        window.location.href = "../view/admin.php?toasterMessage=You%20have%20Logged%20in%20Successfuly!%20Welcome%20to%20Admin%20Dashboard!";
                    } else if (data.role === "user") {
                        // Append session ID as a query parameter
                        window.location.href = "../view/user.php?toasterMessage=You%20have%20Logged%20in%20Successfuly!%20Welcome%20to%20User%20Dashboard!";
                    }
                } else {
                    // Handle incorrect credentials
                    alert("Invalid username or password. Please try again.");
                }
            })
            .catch((error) => {
                console.error("Login error:", error);
                alert("An error occurred. Please try again.");
            });
    });
});
