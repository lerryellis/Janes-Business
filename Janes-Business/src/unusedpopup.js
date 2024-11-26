// Function to open the popup
function openPopup() {
    const popup = document.getElementById("popup");
    popup.style.display = "flex";
}

// Function to close the popup
function closePopup() {
    const popup = document.getElementById("popup");
    popup.style.display = "none";
}

// Toggle Password Visibility (Login)
function togglePasswordVisibility() {
    const passwordInput = document.getElementById("password");
    const showPasswordCheckbox = document.getElementById("show-password");

    passwordInput.type = showPasswordCheckbox.checked ? "text" : "password";
}

// Toggle Password Visibility (Register)
function toggleRegisterPasswordVisibility() {
    const registerPasswordInput = document.getElementById("register-password");
    const registerShowPasswordCheckbox = document.getElementById("register-show-password");

    const passwordType = registerShowPasswordCheckbox.checked ? "text" : "password";
    registerPasswordInput.type = passwordType;
}

// Switch to Register Form
function switchToRegister() {
    const loginForm = document.getElementById("loginForm");
    const registerForm = document.getElementById("registerForm");

    loginForm.style.display = "none";
    registerForm.style.display = "block";
}

// Switch to Login Form
function switchToLogin() {
    const loginForm = document.getElementById("loginForm");
    const registerForm = document.getElementById("registerForm");

    loginForm.style.display = "block";
    registerForm.style.display = "none";
}

// Register user via AJAX
function registerUser(event) {
    event.preventDefault(); // Prevent the form from submitting the traditional way

    const registerUsername = document.getElementById("register-username").value;
    const registerEmail = document.getElementById("register-email").value;
    const registerPhoneNumber = document.getElementById("register-phone-number").value;
    const registerPassword = document.getElementById("register-password").value;

    if (!registerUsername || !registerEmail || !registerPhoneNumber || !registerPassword) {
        alert("Please fill in all fields.");
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
            switchToLogin(); // Switch to login form after successful registration
        } else {
            alert("Error with registration: " + data.message);
        }
    })
    .catch(error => {
        console.error("Error during fetch:", error);
        alert("An error occurred. Please try again.");
    });
}

// Add event listeners when the document is loaded
document.addEventListener("DOMContentLoaded", function() {
    const loginButton = document.getElementById("login-btn");
    const closePopupButton = document.getElementById("close-popup");
    const registerForm = document.getElementById("registerForm");

    // Event listeners for popup opening and closing
    loginButton.addEventListener("click", openPopup);
    closePopupButton.addEventListener("click", closePopup);

    // Event listener for register form submission
    registerForm.addEventListener("submit", registerUser);
    
    // Check if there's a register button
    const registerButton = document.getElementById("register-btn");
    if (registerButton) {
        registerButton.addEventListener("click", function(event) {
            event.preventDefault();
            registerForm.submit(); // Ensure submit event is triggered manually
        });
    }
});

// Authenticate user via AJAX
function authenticateUser(event) {
    event.preventDefault(); // Prevent default form submission

    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    if (!username || !password) {
        alert("Please enter both username and password.");
        return;
    }

    const data = {
        username,
        password
    };

    fetch('../api/auth/login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
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
                closePopup();
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

// Add event listener for login form submission
document.getElementById("loginForm").addEventListener("submit", authenticateUser);
