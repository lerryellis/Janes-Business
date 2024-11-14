$(document).ready(function () {
    // Open the login popup when the "Login" button is clicked
    $('.login-btn').on('click', function (e) {
        e.preventDefault();
        $('#overlay').fadeIn();
        $('#login-popup').fadeIn();
    });

    // Handle login form submission using AJAX
    $('#login-popup form').on('submit', function (e) {
        e.preventDefault();

        const username = $('input[name="username"]').val();
        const password = $('input[name="password"]').val();

        if (!username || !password) {
            showError('Please fill in all fields.');
            return;
        }

        // Send login data to the server
        $.ajax({
            url: '../api/auth/login.php',
            type: 'POST',
            data: { username: username, password: password },
            success: function (response) {
                if (response.success) {
                    window.location.href = '/dashboard.php';
                } else {
                    showError(response.message || 'Invalid credentials.');
                }
            },
            error: function () {
                showError('An error occurred. Please try again later.');
            }
        });
    });

    // Close popups when clicking the overlay
    $('#overlay').on('click', function () {
        closeAllPopups();
    });

    // Close the login popup when "Register" button is clicked
    $('#login-popup button[type="button"]').on('click', function () {
        closeAllPopups();
    });
});

// Function to display an error message
function showError(message) {
    $('#error-popup').text(message).fadeIn();
    $('#overlay').fadeIn();
}

// Function to close all popups
function closeAllPopups() {
    $('#overlay, #error-popup, #login-popup').fadeOut();
}
