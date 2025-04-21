<?php
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Display a message before redirecting
echo "<script>
        alert('User logged out successfully!');
        window.location.href = 'index.html'; 
      </script>";
exit();
?>
