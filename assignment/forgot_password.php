<?php
session_start();
include './includes/connection.php';

$message = ""; // Initialize an empty message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['user_type'])) {
        $email = $_POST['email'];
        $user_type = $_POST['user_type'];
        
        // Determine the table and email column based on user type
        if ($user_type == 'candidate') {
            $table = 'candidate';
            $email_column = 'C_Email';
        } else {
            $table = 'interviewer';
            $email_column = 'I_Email';
        }
        
        // Check if the email exists in the respective table
        $sql = "SELECT * FROM $table WHERE $email_column = '$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Generate a reset token
            $token = bin2hex(random_bytes(50));
            
            // Store the token in the respective table
            $update_sql = "UPDATE $table SET reset_token = '$token' WHERE $email_column = '$email'";
            mysqli_query($conn, $update_sql);
            
            // Send the reset link via email
            $reset_link = "http://yourwebsite.com/reset_password.php?token=$token&type=$user_type";
            $subject = "Password Reset Request";
            $message_body = "Please click on the following link to reset your password: $reset_link";
            $headers = "From: your-email@example.com";
            
            if (mail($email, $subject, $message_body, $headers)) {
                $message = "Password reset link has been sent to your email.";
            } else {
                $message = "Failed to send password reset link. Please try again later.";
            }
        } else {
            $message = "Email not found.";
        }
    } else {
        $message = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password - My Website</title>
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
</head>
<body>
    <header>
        <h3>Assignment</h3>
    </header>

    <main>
        <div class="forgot-password-container">
            <h2>Forgot Password</h2>
            <form class="forgot-password-form" method="post">
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="user_type">I am a:</label>
                <select id="user_type" name="user_type" required>
                    <option value="candidate">Candidate</option>
                    <option value="interviewer">Interviewer</option>
                </select>
                
                <button type="submit">Submit</button>
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
