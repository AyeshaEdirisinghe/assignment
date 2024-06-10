<?php
session_start();
include './includes/connection.php';

$message = ""; // Initialize an empty message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['token']) && isset($_POST['user_type'])) {
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $token = $_POST['token'];
        $user_type = $_POST['user_type'];
        
        if ($password === $confirm_password) {
            // Hash the new password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Determine the table and email column based on user type
            if ($user_type == 'candidate') {
                $table = 'candidate';
                $password_column = 'C_password';
            } else {
                $table = 'interviewer';
                $password_column = 'I_password';
            }
            
            // Update the password in the respective table
            $update_sql = "UPDATE $table SET $password_column = '$hashedPassword', reset_token = NULL WHERE reset_token = '$token'";
            $result = mysqli_query($conn, $update_sql);
            
            if (mysqli_affected_rows($conn) > 0) {
                $message = "Password has been reset successfully. You can now log in.";
            } else {
                $message = "Invalid token or token has expired.";
            }
        } else {
            $message = "Passwords do not match.";
        }
    } else {
        $message = "Please fill in all fields.";
    }
} else if (isset($_GET['token']) && isset($_GET['type'])) {
    $token = $_GET['token'];
    $user_type = $_GET['type'];
} else {
    header("Location: forgot_password.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password - My Website</title>
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
</head>
<body>
    <header>
        <h3>Assignment</h3>
    </header>

    <main>
        <div class="reset-password-container">
            <h2>Reset Password</h2>
            <form class="reset-password-form" method="post">
                <input type="hidden" name="token" value="<?php echo $token; ?>">
                <input type="hidden" name="user_type" value="<?php echo $user_type; ?>">
                
                <label for="password">New Password:</label>
                <input type="password" id="password" name="password" required>
                
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                
                <button type="submit">Reset Password</button>
                <?php if (!empty($message)): ?>
                    <p style="color: red;"><?php echo $message; ?></p>
                <?php endif; ?>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> My Website. All rights reserved.</p>
    </footer>
</body>
</html>
