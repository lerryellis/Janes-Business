// Function to open the popup
function openPopup() {
    document.getElementById("popup").style.display = "flex";
}

// Function to close the popup
function closePopup() {
    document.getElementById("popup").style.display = "none";
}

// Toggle Password Visibility
function togglePasswordVisibility() {
    const passwordInput = document.getElementById("password");
    const showPasswordCheckbox = document.getElementById("show-password");

    // Toggle between text and password type
    if (showPasswordCheckbox.checked) {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
}

// Authenticate user via AJAX
function authenticateUser() {
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    if (!username || !password) {
        alert("Please enter both username and password.");
        return;
    }

    // Perform the fetch request to login.php
    fetch('..//api/auth/login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username, password })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Set session variables
            sessionStorage.setItem('username', data.username);
            sessionStorage.setItem('role', data.role);

            // Redirect to dashboard or display user info
            if (data.role === 'admin') {
                window.location.href = data.redirect;
            } else {
                document.getElementById("popup").style.display = "none";
                document.getElementById("username-display").textContent = data.username;
                document.getElementById("user-info").style.display = "block";
            }
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error("Error during fetch:", error);
        alert("An error occurred. Please try again.");
    });
}

// Function to switch to register form
function switchToRegister() {
    document.getElementById("loginForm").style.display = "none";
    document.getElementById("registerForm").style.display = "block";
}

// Function to switch to login form
function switchToLogin() {
    document.getElementById("loginForm").style.display = "block";
    document.getElementById("registerForm").style.display = "none";
}

// Function to register user via AJAX
function registerUser(event) {
    event.preventDefault();
    const registerUsername = document.getElementById("register-username").value;
    const registerEmail = document.getElementById("register-email").value;
    const registerPhoneNumber = document.getElementById("register-phone-number").value;
    const registerPassword = document.getElementById("register-password").value;
    const registerConfirmPassword = document.getElementById("register-confirm-password").value;

    if (!registerUsername || !registerEmail || !registerPhoneNumber || !registerPassword || !registerConfirmPassword) {
        alert("Please fill in all fields.");
        return;
    }

    if (registerPassword !== registerConfirmPassword) {
        alert("Passwords do not match.");
        return;
    }

    const data = {
        registerUsername,
        registerEmail,
        registerPhoneNumber,
        registerPassword
    };

    fetch('../api/auth/register.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Registration successful!");
            switchToLogin();
        } else {
            alert("Error with registration: " + data.message);
        }
    })
    .catch(error => {
        console.error("Error during fetch:", error);
        alert("An error occurred. Please try again.");
    });
}
// Listen for the Enter key on the popup
document.getElementById("popup").addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        event.preventDefault(); // Prevent default form submission behavior
        authenticateUser();
    }
});

// Toggle Register Password Visibility
function toggleRegisterPasswordVisibility() {
    const registerPasswordInput = document.getElementById("register-password");
    const registerConfirmPasswordInput = document.getElementById("register-confirm-password");
    const registerShowPasswordCheckbox = document.getElementById("register-show-password");

    // Toggle between text and password type
    if (registerShowPasswordCheckbox.checked) {
        registerPasswordInput.type = "text";
        registerConfirmPasswordInput.type = "text";
    } else {
        registerPasswordInput.type = "password";
        registerConfirmPasswordInput.type = "password";
    }
}