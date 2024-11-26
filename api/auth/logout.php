<?php
session_start();
session_unset();
session_destroy();
header("Location: /janes_business/janes-business/src/index.php"); // Redirect to the login page
exit();
?>
