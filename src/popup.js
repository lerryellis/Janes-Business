// Function to open the popup
function openPopup() {
  document.getElementById("popup").style.display = "flex";
}

// Function to close the popup
function closePopup() {
  document.getElementById("popup").style.display = "none";
}

// Authenticate user via AJAX
function authenticateUser() {
  const username = document.getElementById("username").value;
  const password = document.getElementById("password").value;

  // AJAX request to login.php
  fetch('api/auth/login.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ username, password })
  })
  .then(response => response.json())
  .then(data => {
      if (data.success) {
          if (data.role === 'admin') {
              // Redirect admin to dashboard
              window.location.href = 'admin_dashboard.php';
          } else {
              // Display username for non-admin users
              document.getElementById("popup").style.display = "none";
              document.getElementById("username-display").textContent = data.username;
              document.getElementById("user-info").style.display = "block";
          }
      } else {
          alert("Invalid login credentials");
      }
  })
  .catch(error => console.error('Error:', error));
}
