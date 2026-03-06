<?php
session_start();

// 1. Session Security Check
// If the user is not logged in, redirect them to the login page
if (!isset($_SESSION['logged_in_user'])) {
    header("Location: login.php");
    exit();
}

// 2. Retrieve Data from Session
$username = $_SESSION['logged_in_user'];
$fullname = $_SESSION['reg_fullname'];
$study_area = $_SESSION['reg_area'];
$profile_pic = $_SESSION['reg_img'];

$jobs_by_area = [
    "Computer Science" => [
        "Junior Full-Stack Developer - Accra",
        "Frontend Developer (React) - Remote",
        "Backend Developer (PHP) - Kumasi",
        "Mobile App Developer (Flutter) - Remote",
        "QA Tester - Accra",
        "DevOps Trainee - Tema",
        "Data Analyst Intern - Remote",
        "IT Support Specialist - Kumasi",
        "Cybersecurity Assistant - Accra",
        "UI/UX Designer - Remote"
    ],
    "Information Technology" => [
        "IT Support Technician - Accra",
        "Help Desk Analyst - Remote",
        "Systems Administrator (Junior) - Kumasi",
        "Network Support Technician - Tema",
        "Hardware Technician - Accra",
        "IT Intern - Remote",
        "Cloud Support Associate - Remote",
        "Technical Support Specialist - Accra",
        "Database Assistant - Kumasi",
        "Field IT Technician - Cape Coast"
    ],
    "Business Administration" => [
        "Administrative Assistant - Accra",
        "Office Manager (Junior) - Kumasi",
        "Operations Assistant - Tema",
        "Business Analyst Intern - Remote",
        "Project Assistant - Accra",
        "Client Relations Assistant - Kumasi",
        "Executive Assistant - Accra",
        "Procurement Assistant - Tema",
        "Records Clerk - Accra",
        "Scheduling Coordinator - Remote"
    ],
    "Accounting" => [
        "Accounts Assistant - Accra",
        "Junior Accountant - Kumasi",
        "Payroll Clerk - Tema",
        "Billing Assistant - Accra",
        "Audit Intern - Remote",
        "Accounts Payable Clerk - Accra",
        "Accounts Receivable Clerk - Kumasi",
        "Tax Assistant - Accra",
        "Bookkeeper - Remote",
        "Finance Clerk - Tema"
    ],
    "Finance" => [
        "Finance Analyst Intern - Accra",
        "Credit Analyst Assistant - Kumasi",
        "Treasury Assistant - Accra",
        "Loan Officer Assistant - Tema",
        "Investment Research Intern - Remote",
        "Risk Analyst Assistant - Accra",
        "Branch Operations Assistant - Kumasi",
        "Financial Reporting Assistant - Accra",
        "Cash Management Clerk - Tema",
        "Microfinance Assistant - Accra"
    ],
    "Marketing" => [
        "Marketing Assistant - Accra",
        "Social Media Coordinator - Remote",
        "Content Creator - Accra",
        "Brand Assistant - Kumasi",
        "Digital Marketing Intern - Remote",
        "Market Research Assistant - Accra",
        "Event Coordinator - Tema",
        "PR Assistant - Accra",
        "SEO Assistant - Remote",
        "Community Manager - Accra"
    ],
    "Human Resources" => [
        "HR Assistant - Accra",
        "Recruitment Coordinator - Remote",
        "Payroll Assistant - Kumasi",
        "Training Coordinator - Accra",
        "Employee Relations Assistant - Tema",
        "HR Intern - Remote",
        "Onboarding Coordinator - Accra",
        "Benefits Assistant - Kumasi",
        "HR Data Clerk - Accra",
        "Talent Acquisition Assistant - Accra"
    ],
    "Engineering" => [
        "Engineering Trainee - Accra",
        "Project Engineer Intern - Tema",
        "Site Supervisor Assistant - Kumasi",
        "Maintenance Technician - Accra",
        "Quality Control Assistant - Tema",
        "CAD Technician (Junior) - Accra",
        "Safety Assistant - Kumasi",
        "Production Assistant - Tema",
        "Field Engineer Trainee - Accra",
        "Technical Support Engineer - Remote"
    ],
    "Civil Engineering" => [
        "Civil Engineer Trainee - Accra",
        "Site Engineer Assistant - Kumasi",
        "Quantity Surveyor Assistant - Accra",
        "Roads Project Intern - Tema",
        "Survey Technician - Kumasi",
        "Construction Supervisor Assistant - Accra",
        "Materials Testing Assistant - Tema",
        "Drafting Technician - Accra",
        "Project Coordinator (Civil) - Kumasi",
        "Health and Safety Assistant - Accra"
    ],
    "Electrical Engineering" => [
        "Electrical Technician (Junior) - Accra",
        "Maintenance Electrician - Kumasi",
        "Power Systems Intern - Tema",
        "Control Systems Assistant - Accra",
        "Solar Installation Assistant - Accra",
        "Electrical Design Intern - Remote",
        "Instrumentation Technician - Tema",
        "Electrical Site Assistant - Kumasi",
        "Energy Audit Assistant - Accra",
        "Cable Technician - Accra"
    ],
    "Mechanical Engineering" => [
        "Mechanical Technician - Accra",
        "Maintenance Assistant - Kumasi",
        "Production Technician - Tema",
        "AutoCAD Drafter - Accra",
        "Plant Operator Assistant - Tema",
        "Workshop Technician - Kumasi",
        "Quality Inspector - Accra",
        "HVAC Technician Assistant - Accra",
        "Fabrication Assistant - Tema",
        "Mechanical Engineer Intern - Remote"
    ],
    "Architecture" => [
        "Architectural Assistant - Accra",
        "Drafting Technician - Kumasi",
        "3D Modeler - Remote",
        "Site Assistant - Accra",
        "Design Intern - Remote",
        "Planning Assistant - Accra",
        "Project Assistant (Architecture) - Kumasi",
        "Visualization Artist - Remote",
        "Construction Documentation Assistant - Accra",
        "Interior Design Assistant - Accra"
    ],
    "Construction" => [
        "Construction Supervisor Assistant - Accra",
        "Site Foreman Assistant - Kumasi",
        "Safety Officer Assistant - Tema",
        "Construction Clerk - Accra",
        "Materials Handler - Accra",
        "Site Logistics Assistant - Tema",
        "Equipment Operator Assistant - Kumasi",
        "Concrete Technician Assistant - Accra",
        "Building Inspector Trainee - Accra",
        "Project Coordinator (Construction) - Kumasi"
    ],
    "Education" => [
        "Teaching Assistant - Accra",
        "Tutor (Math/Science) - Remote",
        "Classroom Coordinator - Kumasi",
        "Curriculum Assistant - Accra",
        "School Administrator Assistant - Tema",
        "Library Assistant - Accra",
        "Early Childhood Assistant - Kumasi",
        "Exam Invigilator - Accra",
        "Learning Support Assistant - Accra",
        "Education Intern - Remote"
    ],
    "Nursing" => [
        "Nursing Assistant - Accra",
        "Clinical Assistant - Kumasi",
        "Ward Aide - Accra",
        "Community Health Assistant - Tema",
        "Patient Care Assistant - Accra",
        "Healthcare Assistant - Kumasi",
        "Home Care Assistant - Accra",
        "Immunization Assistant - Tema",
        "Clinic Reception Assistant - Accra",
        "Health Records Assistant - Kumasi"
    ],
    "Public Health" => [
        "Public Health Assistant - Accra",
        "Community Outreach Assistant - Kumasi",
        "Health Education Assistant - Accra",
        "Data Collection Assistant - Remote",
        "Epidemiology Intern - Remote",
        "Nutrition Program Assistant - Tema",
        "Sanitation Inspector Trainee - Accra",
        "NGO Program Assistant - Accra",
        "Monitoring and Evaluation Assistant - Kumasi",
        "Health Promotion Assistant - Accra"
    ],
    "Agriculture" => [
        "Agriculture Extension Assistant - Kumasi",
        "Farm Supervisor Assistant - Accra",
        "Greenhouse Technician - Tema",
        "Agribusiness Assistant - Accra",
        "Crop Monitoring Assistant - Kumasi",
        "Livestock Technician Assistant - Accra",
        "Quality Control Assistant (Agro) - Tema",
        "Field Research Assistant - Remote",
        "Irrigation Assistant - Accra",
        "Seed Production Assistant - Kumasi"
    ],
    "Hospitality" => [
        "Front Desk Assistant - Accra",
        "Hotel Receptionist - Kumasi",
        "Event Coordinator Assistant - Accra",
        "Guest Services Assistant - Tema",
        "Restaurant Supervisor Assistant - Accra",
        "Housekeeping Supervisor Assistant - Kumasi",
        "Catering Assistant - Accra",
        "Travel Desk Assistant - Accra",
        "Food and Beverage Assistant - Tema",
        "Concierge Assistant - Accra"
    ],
    "Logistics" => [
        "Logistics Coordinator Assistant - Accra",
        "Warehouse Assistant - Tema",
        "Inventory Clerk - Kumasi",
        "Dispatch Assistant - Accra",
        "Supply Chain Assistant - Accra",
        "Fleet Assistant - Tema",
        "Procurement Assistant - Accra",
        "Shipping Assistant - Kumasi",
        "Route Planner Assistant - Accra",
        "Delivery Operations Assistant - Accra"
    ],
    "Law" => [
        "Legal Assistant - Accra",
        "Paralegal (Junior) - Kumasi",
        "Court Clerk Assistant - Accra",
        "Compliance Assistant - Tema",
        "Legal Research Intern - Remote",
        "Contracts Assistant - Accra",
        "Case File Clerk - Accra",
        "Notary Assistant - Kumasi",
        "Litigation Support Assistant - Accra",
        "Client Intake Assistant - Accra"
    ],
    "Other (General Work - Cleaning, Driving, Security, etc.)" => [
        "Cleaner - Office",
        "Housekeeper - Hotel",
        "Janitor - School",
        "Driver (Company) - Accra",
        "Delivery Driver - Accra",
        "Security Guard - Day Shift",
        "Security Guard - Night Shift",
        "Handyman - General Repairs",
        "Maintenance Assistant - Facility",
        "Messenger/Errand Runner"
    ]
];

$salary_by_area = [
    "Computer Science" => "GHS 6,000 - 9,500 / month",
    "Information Technology" => "GHS 6,000 - 9,500 / month",
    "Business Administration" => "GHS 1,800 - 4,500 / month",
    "Accounting" => "GHS 2,200 - 5,000 / month",
    "Finance" => "GHS 2,500 - 6,000 / month",
    "Marketing" => "GHS 1,800 - 4,800 / month",
    "Human Resources" => "GHS 2,000 - 4,800 / month",
    "Engineering" => "GHS 2,800 - 6,500 / month",
    "Civil Engineering" => "GHS 2,800 - 6,500 / month",
    "Electrical Engineering" => "GHS 2,800 - 6,500 / month",
    "Mechanical Engineering" => "GHS 2,800 - 6,500 / month",
    "Architecture" => "GHS 2,200 - 5,500 / month",
    "Construction" => "GHS 2,000 - 5,000 / month",
    "Education" => "GHS 1,600 - 4,200 / month",
    "Nursing" => "GHS 2,200 - 5,500 / month",
    "Public Health" => "GHS 2,000 - 5,200 / month",
    "Agriculture" => "GHS 1,800 - 4,500 / month",
    "Hospitality" => "GHS 1,600 - 4,200 / month",
    "Logistics" => "GHS 2,000 - 4,800 / month",
    "Law" => "GHS 2,500 - 6,500 / month",
    "Other (General Work - Cleaning, Driving, Security, etc.)" => "GHS 900 - 2,500 / month"
];

$job_count = isset($jobs_by_area[$study_area]) ? count($jobs_by_area[$study_area]) : 0;
$salary_range = $salary_by_area[$study_area] ?? "GHS 1,500 - 4,000 / month";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Jobseeker Portal</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="dashboard-page">
    <div class="dashboard-layout">
        <aside class="dashboard-sidebar">
            <div class="brand">
                <div class="logo">Job<span>seeker</span>Portal</div>
                <p class="brand-tag">Candidate Center</p>
            </div>

            <div class="profile-chip">
                <img src="<?php echo $profile_pic; ?>" alt="Profile Picture">
                <div>
                    <p class="profile-name"><?php echo $fullname; ?></p>
                    <p class="profile-role"><?php echo $study_area; ?></p>
                </div>
            </div>

            <nav class="side-nav">
                <a class="side-link active" href="dashboard.php">Dashboard</a>
                <a class="side-link" href="index.html">Home</a>
                <a class="side-link" href="logout.php">Logout</a>
            </nav>
        </aside>

        <main class="dashboard-content">
            <div class="dashboard-topbar">
                <div>
                    <h1>Candidate Dashboard</h1>
                    <p>Welcome back, <?php echo $username; ?>. Here are your job matches.</p>
                </div>
                <div class="topbar-actions">
                    <span class="salary-pill">Average Salary: <?php echo htmlspecialchars($salary_range); ?></span>
                </div>
            </div>

            <section class="stat-grid">
                <div class="stat-card">
                    <p class="stat-label">Profile</p>
                    <h3><?php echo $fullname; ?></h3>
                    <span class="stat-sub"><?php echo $study_area; ?></span>
                </div>
                <div class="stat-card">
                    <p class="stat-label">Recommended Jobs</p>
                    <h3><?php echo $job_count; ?></h3>
                    <span class="stat-sub">Matches for you</span>
                </div>
                <div class="stat-card">
                    <p class="stat-label">Salary Range</p>
                    <h3><?php echo htmlspecialchars($salary_range); ?></h3>
                    <span class="stat-sub">Market estimate</span>
                </div>
            </section>

            <section class="jobs-section">
                <div class="section-head">
                    <h2>Job Recommendations</h2>
                    
                </div>

                <div class="job-list">
                    <?php
                    if (isset($jobs_by_area[$study_area])) {
                        echo "<div class=\"job-grid\">";
                        foreach ($jobs_by_area[$study_area] as $job) {
                            $salary = $salary_by_area[$study_area] ?? "GHS 1,500 - 4,000 / month";
                            echo "<div class=\"job-card\">"
                                . "<strong>" . htmlspecialchars($job) . "</strong>"
                                . "<br><small>" . htmlspecialchars($salary) . "</small>"
                                . "<div class=\"job-actions\"><a class=\"apply-btn\" href=\"apply.php\">Apply</a></div>"
                                . "</div>";
                        }
                        echo "</div>";
                    } else {
                        echo "<p>Please complete your profile to see specific job matches.</p>";
                    }
                    ?>
                </div>
            </section>
        </main>
    </div>

    <footer>
        <p><a class="footer-link" href="members_index.html">&copy; 2026 Jobseeker Portal | Developed for Back-End Web Development Mid-Sem Project(GROUP 6)</a></p>
    </footer>
</body>
</html>