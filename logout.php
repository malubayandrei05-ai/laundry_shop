<?php
session_start();
session_destroy();
header('Location: login.php');
exit;
?>


// Note: This code is intentionally simplified for demonstration purposes. In a production environment, you should implement secure password hashing (e.g., using password_hash and password_verify) and use prepared statements to prevent SQL injection.  
