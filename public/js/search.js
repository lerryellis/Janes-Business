$(document).ready(function () {
    // Open the search popup when the search icon is clicked
    $('.search-btn').on('click', function (e) {
        e.preventDefault();
        $('#overlay').fadeIn();
        $('#search-popup').fadeIn();
    });

    // Handle search form submission using AJAX
    $('#search-popup form').on('submit', function (e) {
        e.preventDefault();

        const query = $('input[name="query"]').val().trim();
        if (!query) {
            showError('Please enter a search term.');
            return;
        }

        // Send search query to the server
        $.ajax({
            url: '/search.php',
            type: 'GET',
            data: { query: query },
            success: function (response) {
                // Display search results or handle the response
                $('#search-results').html(response);
                closeAllPopups();
            },
            error: function () {
                showError('An error occurred while searching.');
            }
        });
    });

    // Close popups when clicking the overlay
    $('#overlay').on('click', function () {
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
    $('#overlay, #error-popup, #search-popup').fadeOut();
}
