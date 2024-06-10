<?php
session_start();
include './includes/connection.php';

$message = ""; // Initialize an empty message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Check if email and password are provided
    if (empty($email) || empty($password)) {
        $message = "Incomplete form submission";
    } else {
        $sql = "SELECT * FROM interviewer WHERE I_Email = '$email'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if ($user['status'] == 0) {
                $message = "Inactive account";
            } elseif (password_verify($password, $user['I_password'])) {
                $_SESSION['email'] = $user['I_Email'];
                header("Location: dashboard.php");
                exit();
            } else {
                $message = "Password is incorrect";
            }
        } else {
            $message = "Email is incorrect";
        }

        if ($result) {
            mysqli_free_result($result);
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login as Interviewer - My Website</title>
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
</head>
<body>
    <header>
        <h3>Assignment</h3>
    </header>

    <main>
        <div class="login-container">
            <h2>Login as Interviewer</h2>
            <form class="login-form" method="post" novalidate>
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Login</button>
                <?php if (!empty($message)): ?>
                    <p style="color: red;"><?php echo $message; ?></p>
                <?php endif; ?>
                <p><a href="forgot_password.php" id="forgotPassword">Forgot Password?</a></p>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> My Website. All rights reserved.</p>
    </footer>
</body>
</html>
