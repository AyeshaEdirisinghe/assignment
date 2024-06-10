<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $FirstName = filter_var($_POST['FirstName'], FILTER_SANITIZE_STRING);
    $LastName = filter_var($_POST['LastName'], FILTER_SANITIZE_STRING);
    $Password = $_POST['Password'];
    $ConfirmPassword = $_POST['ConfirmPassword'];
    $Role = filter_var($_POST['Role'], FILTER_SANITIZE_STRING);

    if (!empty($email) && !empty($FirstName) && !empty($LastName) && !empty($Password) && !empty($ConfirmPassword) && !empty($Role)) {
        if ($Password === $ConfirmPassword) {
            $host = "localhost";
            $dbusername = "root";
            $dbpassword = "";
            $dbname = "interviewsupportsystem";

            // Create connection
            $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

            if ($conn->connect_error) {
                die('Connect Error('. $conn->connect_errno .') '. $conn->connect_error);
            } else {
                $SELECT = "SELECT email FROM user WHERE email = ? LIMIT 1";
                $INSERT_USER = "INSERT INTO user (email, FirstName, LastName, Password) VALUES (?, ?, ?, ?)";
                $INSERT_CANDIDATE = "INSERT INTO candidate (email, Password) VALUES (?, ?)";
                $INSERT_INTERVIEWER = "INSERT INTO interviewer (email, Password) VALUES (?, ?)";

                // Prepare statement
                $stmt = $conn->prepare($SELECT);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();
                $rnum = $stmt->num_rows;

                // Checking if email already exists
                if ($rnum == 0) {
                    $stmt->close();

                    // Hash the password
                    $hashedPassword = password_hash($Password, PASSWORD_BCRYPT);

                    // Insert into user table
                    $stmt = $conn->prepare($INSERT_USER);
                    $stmt->bind_param("ssss", $email, $FirstName, $LastName, $hashedPassword);
                    $stmt->execute();
                    $stmt->close();

                    // Insert into candidate or interviewer table based on role
                    if ($Role == "Candidate") {
                        $stmt = $conn->prepare($INSERT_CANDIDATE);
                        $stmt->bind_param("ss", $email, $hashedPassword);
                        $stmt->execute();
                        $stmt->close();
                        $message = "Registration successful for Candidate.";
                    } elseif ($Role == "Interviewer") {
                        $stmt = $conn->prepare($INSERT_INTERVIEWER);
                        $stmt->bind_param("ss", $email, $hashedPassword);
                        $stmt->execute();
                        $stmt->close();
                        $message = "Registration successful for Interviewer.";
                    }

                    $success = true;
                } else {
                    $message = "Someone already registered using this email.";
                    $success = false;
                }
                $stmt->close();
                $conn->close();
            }
        } else {
            $message = "Passwords do not match.";
            $success = false;
        }
    } else {
        $message = "All fields are required.";
        $success = false;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - My Website</title>
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
</head>
<body>
    <header>
        <h3>Assignment</h3>
    </header>

    <main>
        <div class="register-container">
            <h2>Register</h2>
            <form class="register-form" method="post" novalidate>
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required>
                <label for="FirstName">First Name:</label>
                <input type="text" id="FirstName" name="FirstName" required>
                <label for="LastName">Last Name:</label>
                <input type="text" id="LastName" name="LastName" required>
                <label for="Password">Password:</label>
                <input type="password" id="Password" name="Password" required>
                <label for="ConfirmPassword">Confirm Password:</label>
                <input type="password" id="ConfirmPassword" name="ConfirmPassword" required>
                <label for="Role">Role:</label>
                <select id="Role" name="Role" required>
                    <option value="Candidate">Candidate</option>
                    <option value="Interviewer">Interviewer</option>
                </select>
                <button type="submit">Register</button>
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
