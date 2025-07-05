<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_profiles";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$errors = [];
$fullname = $email = $username = $password = "";

// Validate and sanitize input
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Full Name validation
    if (empty($_POST["fullname"])) {
        $errors[] = "Full name is required";
    } else {
        $fullname = test_input($_POST["fullname"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $fullname)) {
            $errors[] = "Only letters and white space allowed in full name";
        }
    }

    // Email validation
    if (empty($_POST["email"])) {
        $errors[] = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }
    }

    // Username validation
    if (empty($_POST["username"])) {
        $errors[] = "Username is required";
    } else {
        $username = test_input($_POST["username"]);
        if (!preg_match("/^[a-zA-Z0-9_]*$/", $username)) {
            $errors[] = "Only letters, numbers and underscore allowed in username";
        }
        
        // Check if username exists
        $sql = "SELECT id FROM users WHERE username = '$username'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $errors[] = "Username already taken";
        }
    }

    // Password validation
    if (empty($_POST["password"])) {
        $errors[] = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters";
        }
    }

    // Confirm password
    if ($_POST["password"] !== $_POST["confirm_password"]) {
        $errors[] = "Passwords do not match";
    }

    // If no errors, insert into database
    if (empty($errors)) {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert user
        $sql = "INSERT INTO users (fullname, email, username, password, created_at)
                VALUES ('$fullname', '$email', '$username', '$hashed_password', NOW())";

        if ($conn->query($sql) === TRUE) {
            // Redirect to profile page
            header("Location: profile.php");
            exit();
        } else {
            $errors[] = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Function to sanitize input
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Processing</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="header-container">
            <img src="https://via.placeholder.com/150x80?text=AUCA+Logo" alt="AUCA University Logo" class="logo">
            <h1>Sign Up Processing</h1>
        </div>
    </header>

    <main class="processing-main">
        <?php if (!empty($errors)): ?>
            <div class="error-container">
                <h2>Registration Failed</h2>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
                <a href="signup.html" class="back-btn">Go Back to Sign Up</a>
            </div>
        <?php else: ?>
            <div class="success-container">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h2>Registration Successful!</h2>
                <p>You will be redirected to your profile shortly.</p>
                <p>If you are not redirected, <a href="profile.php">click here</a>.</p>
            </div>
            <script>
                setTimeout(function() {
                    window.location.href = "profile.php";
                }, 3000);
            </script>
        <?php endif; ?>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-top">
                <div class="footer-credits">
                    <a href="#"><h5>Lecturer: Mr. BYIRINGIRO Eric</h5></a>
                    <a href="https://www.linkedin.com/in/iriza123"><h5>Developed by iriza123</h5></a>
                </div>
                <div class="footer-github">
                    <h3>Check out my GitHub!!</h3>
                    <div class="github-link">
                        <i class="fas fa-hand-point-down"></i>
                        <a href="#" target="_blank" class="github-btn">
                            <i class="fab fa-github"></i> Visit GitHub
                        </a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>Copyright &copy; <span id="current-year"></span> iriza123 - All Rights Reserved</p>
            </div>
        </div>
    </footer>

    <script src="scripts.js"></script>
</body>
</html>