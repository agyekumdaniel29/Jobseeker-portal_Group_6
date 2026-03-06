<?php 
session_start();
$error = "";
$success = "";

// Only process if the form was actually submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    
    // Collect and Sanitize Inputs - Variables are now safe inside this block
    $fullname = htmlspecialchars($_POST['fullname'] ?? '');
    $username = htmlspecialchars($_POST['username'] ?? ''); 
    $password = $_POST['pass'] ?? '';
    $confirm_password = $_POST['confirm_pass'] ?? '';
    $area_of_study = htmlspecialchars($_POST['area_of_study'] ?? '');

    // Validation using conditional statements [cite: 21, 23]
    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } elseif (empty($_FILES["profile_pic"]["name"])) {
        $error = "Please upload a profile picture.";
    } else {
        // File Upload Handling [cite: 27]
        $target_dir = "profiles/";
        if (!is_dir($target_dir)) { 
            mkdir($target_dir, 0777, true); 
        }

        $file_ext = strtolower(pathinfo($_FILES["profile_pic"]["name"], PATHINFO_EXTENSION));
        $file_name = $username . "_" . time() . "." . $file_ext;
        $target_file = $target_dir . $file_name;

        $tmp_file = $_FILES["profile_pic"]["tmp_name"];
        $check = (!empty($tmp_file)) ? getimagesize($tmp_file) : false;

        if ($check === false) {
            $error = "File is not a valid image.";
        } elseif ($_FILES["profile_pic"]["size"] > 2000000) {
            $error = "Image size too large (Max 2MB).";
        } else {
            if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
                // Session management [cite: 26]
                $_SESSION['reg_user'] = $username; 
                $_SESSION['reg_pass'] = $password; 
                $_SESSION['reg_fullname'] = $fullname;
                $_SESSION['reg_img'] = $target_file;
                $_SESSION['reg_area'] = $area_of_study;
                
                // Redirect to login page after successful registration
                header("Location: login.php");
                exit();
            } else {
                $error = "Failed to upload image.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Jobseeker Portal</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="register-page">
    <nav class="navbar">
        <div class="logo">Job<span>seeker</span>Portal</div>
        <ul class="nav-links">
            <li><a href="index.html">Home</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>

    <div class="login-page-wrapper"> <div class="register-card">
        <h2>Create Account</h2>
        <p>Join the Jobseeker community today</p>
        <?php if ($error) echo "<p style='color:red; margin-top:10px;'>$error</p>"; ?>
        <?php if ($success) echo "<p style='color:green; margin-top:10px; font-weight:bold;'>$success</p>"; ?>
        
        <form action="register.php" method="POST" enctype="multipart/form-data">
            
            <div class="input-group">
                <input type="text" name="fullname" placeholder="Full Name" required>
            </div>

            <div class="input-group">
                <input type="text" name="username" placeholder="Choose Username" required>
            </div>

            <div class="input-group">
                <select name="area_of_study" required>
                    <option value="" disabled selected>Select Area of Study</option>
                    <option value="Computer Science">Computer Science</option>
                    <option value="Information Technology">Information Technology</option>
                    <option value="Business Administration">Business Administration</option>
                    <option value="Accounting">Accounting</option>
                    <option value="Finance">Finance</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Human Resources">Human Resources</option>
                    <option value="Engineering">Engineering</option>
                    <option value="Civil Engineering">Civil Engineering</option>
                    <option value="Electrical Engineering">Electrical Engineering</option>
                    <option value="Mechanical Engineering">Mechanical Engineering</option>
                    <option value="Architecture">Architecture</option>
                    <option value="Construction">Construction</option>
                    <option value="Education">Education</option>
                    <option value="Nursing">Nursing</option>
                    <option value="Public Health">Public Health</option>
                    <option value="Agriculture">Agriculture</option>
                    <option value="Hospitality">Hospitality</option>
                    <option value="Logistics">Logistics</option>
                    <option value="Law">Law</option>
                    <option value="Other (General Work - Cleaning, Driving, Security, etc.)">Other (General Work - Cleaning, Driving, Security, etc.)</option>
                </select>
            </div>

            <div class="input-group">
                <input type="password" name="pass" placeholder="Create Password" required>
            </div>

            <div class="input-group">
                <input type="password" name="confirm_pass" placeholder="Confirm Password" required>
            </div>

            <div class="file-group">
                <label for="profile_pic">Upload Profile Picture</label>
                <input type="file" name="profile_pic" id="profile_pic" accept="image/*" required>
            </div>

            <button type="submit" name="register" class="login-btn">SIGN UP</button>
        </form>
        
        <div class="form-footer">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
</div>

    <footer>
        <p><a class="footer-link" href="members_index.html">&copy; 2026 Jobseeker Portal | Developed for Back-End Web Development Mid-Sem Project(GROUP 6)</a></p>
    </footer>
</body>
</html>