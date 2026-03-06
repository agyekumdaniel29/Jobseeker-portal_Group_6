<?php
session_start();
$error = "";

// Check if user is already logged in
if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = htmlspecialchars($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // 1. Authentication Logic using Conditional Statements
    if (isset($_SESSION['reg_user']) && isset($_SESSION['reg_pass'])) {
        // Check if input matches registered data
        if ($username === $_SESSION['reg_user'] && $password === $_SESSION['reg_pass']) {
            // 2. Set Login Session
            $_SESSION['is_logged_in'] = true;
            $_SESSION['logged_in_user'] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password!";
        }
    } else {
        $error = "No account found. Please register first.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Jobseeker Portal</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="login-page">
    <nav class="navbar">
        <div class="logo">Job<span>seeker</span>Portal</div>
        <ul class="nav-links">
            <li><a href="index.html">Home</a></li>
            <li><a href="register.php">Register</a></li>
        </ul>
    </nav>

    <div class="login-page-wrapper">
    <div class="login-card">
        <h2>Login</h2>
        <p>Secure your next opportunity</p>
        <?php if ($error) echo "<p style='color:red; margin-top:10px;'>$error</p>"; ?>
        
        <form action="login.php" method="POST">
            <div class="input-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" name="login" class="login-btn">LOGIN</button>
        </form>
        
        <div class="form-footer">
            <p>Don't have an account? <a href="register.php">Create an Account</a></p>
        </div>
    </div>
</div>

     <footer>
        <p><a class="footer-link" href="members_index.html">&copy; 2026 Jobseeker Portal | Developed for Back-End Web Development Mid-Sem Project(GROUP 6)</a></p>
    </footer>
</body>
</html>


