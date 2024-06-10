<!DOCTYPE html>
<html>
<head>
    <title>Confirm Your Position - My Website</title>
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <style>
        .position-container {
            text-align: center;
            margin-top: 100px;
        }
        .position-container h2 {
            margin-bottom: 20px;
        }
        .position-container .button {
            margin: 10px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <h3>Assignment</h3>
    </header>

    <main>
        <div class="position-container">
            <h2>Confirm Your Position</h2>
            <form action="login_as_interviewer.php" method="get" style="display: inline;">
                <button type="submit" class="button">Interviewer</button>
            </form>
            <form action="login_as_candidate.php" method="get" style="display: inline;">
                <button type="submit" class="button">Candidate</button>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> My Website. All rights reserved.</p>
    </footer>
</body>
</html>