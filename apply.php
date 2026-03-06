<?php
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["apply"])) {
    $success = "Application submitted, you will be called for an interview.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Apply - Jobseeker Portal</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="apply-page">
    <nav class="navbar">
        <div class="logo">Job<span>seeker</span>Portal</div>
        <ul class="nav-links">
            <li><a href="index.html">Home</a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
        </ul>
    </nav>

    <div class="login-page-wrapper">
        <div class="apply-card">
            <h2>Job Application</h2>
            <?php if ($success) echo "<p style='color:green; font-weight:bold;'>$success</p>"; ?>

            <form action="apply.php" method="POST" enctype="multipart/form-data">
                <label>Full Name:</label>
                <input type="text" name="fullname" required>

                <label>Contact Number:</label>
                <input type="text" name="contact" required>

                <label>Email Address:</label>
                <input type="text" name="email" required>

                <label>Job Experience:</label>
                <select name="experience" required>
                    <option value="" disabled selected>Select experience</option>
                    <option value="None">None</option>
                    <option value="5+ years">5+ years</option>
                </select>

                <label>Upload CV (PDF/DOC):</label>
                <input type="file" name="cv" accept=".pdf,.doc,.docx" required>

                <button type="submit" name="apply">Submit Application</button>
            </form>
        </div>
    </div>

     <footer>
        <p><a class="footer-link" href="members_index.html">&copy; 2026 Jobseeker Portal | Developed for Back-End Web Development Mid-Sem Project(GROUP 6)</a></p>
    </footer>
</body>
</html>
