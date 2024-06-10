<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php"); // Redirect to the login page if not logged in
    exit();
}

// Logout logic
if (isset($_POST['logout'])) {
    session_destroy(); // Destroy the session
    header("Location: login.php"); // Redirect to the login page after logout
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Website</title>
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
</head>
<body>
    <header>
        <h3>Assignment</h3>
        <form method="post" style="display: inline;">
            <button type="submit" name="logout" class="button">Logout</button>
        </form>
    </header>

    <main>
        <!-- Your main content goes here -->
    </main>
</body>
</html>
