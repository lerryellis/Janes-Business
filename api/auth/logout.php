<?php
session_start();
session_unset();
session_destroy();

// Redirect to the homepage
header("Location: ..//src/index.php");
?>
