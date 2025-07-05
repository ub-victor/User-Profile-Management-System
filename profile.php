<?php
// Database connection
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

// For demonstration, we'll use a sample user
$user_id = 1; // In a real app, this would come from session

// Fetch user data
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    // Default values if no user found (for demo)
    $user = [
        'fullname' => 'John Doe',
        'email' => 'john@example.com',
        'username' => 'johndoe',
        'created_at' => date('Y-m-d H:i:s')
    ];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - User Profile Management</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="header-container">
            <img src="https://via.placeholder.com/150x80?text=AUCA+Logo" alt="AUCA University Logo" class="logo">
            <h1>My Profile</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="signup.html">Sign Up</a></li>
                <li><a href="profile.php" class="active">My Profile</a></li>
            </ul>
        </nav>
    </header>

    <main class="profile-main">
        <section class="profile-header">
            <div class="profile-image">
                <img src="https://via.placeholder.com/150x150?text=User+Photo" alt="User profile photo">
            </div>
            <div class="profile-info">
                <h2><?php echo htmlspecialchars($user['fullname']); ?></h2>
                <p>Member since: <?php echo date('F Y', strtotime($user['created_at'])); ?></p>
            </div>
        </section>

        <article class="profile-details">
            <h3>Account Information</h3>
            <div class="detail-item">
                <span class="detail-label">Full Name:</span>
                <span class="detail-value"><?php echo htmlspecialchars($user['fullname']); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Email:</span>
                <span class="detail-value"><?php echo htmlspecialchars($user['email']); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Username:</span>
                <span class="detail-value"><?php echo htmlspecialchars($user['username']); ?></span>
            </div>
        </article>

        <section class="profile-actions">
            <button class="action-btn update-btn" id="updateProfileBtn">
                <i class="fas fa-user-edit"></i> Update Profile
            </button>
            <button class="action-btn delete-btn" id="deleteProfileBtn">
                <i class="fas fa-user-times"></i> Delete Account
            </button>
        </section>

        <!-- Update Profile Modal -->
        <div class="modal" id="updateModal">
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <h3>Update Profile</h3>
                <form id="updateForm">
                    <div class="form-group">
                        <label for="update_fullname">Full Name</label>
                        <input type="text" id="update_fullname" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="update_email">Email</label>
                        <input type="email" id="update_email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="update_username">Username</label>
                        <input type="text" id="update_username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="update_password">New Password (leave blank to keep current)</label>
                        <input type="password" id="update_password" name="password">
                    </div>
                    <button type="submit" class="submit-btn">Save Changes</button>
                </form>
            </div>
        </div>
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