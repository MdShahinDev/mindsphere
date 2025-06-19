<?php
include("../config/db.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// --- Fetch user data ---
$user_name = "Guest";
$user_email = "";
$user_location = "";
$user_profession = "";
$user_avatar = "../img/profilePicture.png";

$stmt = $conn->prepare("SELECT name, email, location, profession, avatar FROM users WHERE user_id = ?");

// --- Fetch notification count ---
$notification_count = 0;
$query = "SELECT COUNT(*) as count FROM notification WHERE user_id = ?";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $notification_count = $row['count'];
    }
    $stmt->close();
} else {
    // Show clear error message
    die("SQL Prepare failed (Notification Count): " . $conn->error);
}

// --- Fetch user name and location ---
$user_name = "Guest";
$user_location = "";

$stmt = $conn->prepare("SELECT name, email, location, profession, avatar FROM users WHERE user_id = ?");
if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $user_name = $row['name'];
        $user_email = $row['email'];
        $user_location = $row['location'];
        $user_profession = $row['profession'];
        $user_avatar = $row['avatar'] ?: "../img/profilePicture.png";

    }
    $stmt->close();
} else {
    die("SQL Prepare failed (User Info): " . $conn->error);
}


// --- Handle skill submission ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['skill_type'])) {
    $skill_type = $_POST['skill_type'];
    $skill_name = $_POST['skill_name'];
    $skill_grade = intval($_POST['skill_grade']);
    $skill_assessed = isset($_POST['skill_assessed']) ? 1 : 0;

    if (in_array($skill_type, ['personal', 'professional']) && $skill_grade >= 1 && $skill_grade <= 5) {
        $table = $skill_type === 'personal' ? 'personal_skill' : 'professional_skill';

        $stmt = $conn->prepare("INSERT INTO $table (user_id, skill_name, grade, assessed) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("isii", $user_id, $skill_name, $skill_grade, $skill_assessed);
            $stmt->execute();
            $stmt->close();
            header("Location: DashboardProfile.php");
            exit();
        }
    }
}

// --- Handle profile update ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['skill_type'])) {
    $updated_name = !empty($_POST['name']) ? $_POST['name'] : $user_name;
    $updated_email = !empty($_POST['user_email']) ? $_POST['user_email'] : $user_email;
    $updated_location = !empty($_POST['location']) ? $_POST['location'] : $user_location;
    $updated_profession = !empty($_POST['profession']) ? $_POST['profession'] : $user_profession;
    $updated_password = !empty($_POST['new_password']) ? $_POST['new_password'] : null;

    $new_avatar_path = $user_avatar;
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = "../uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        $file_tmp = $_FILES['avatar']['tmp_name'];
        $file_name = basename($_FILES['avatar']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($file_ext, $allowed_exts)) {
            $unique_name = uniqid("avatar_", true) . "." . $file_ext;
            $destination = $upload_dir . $unique_name;
            if (move_uploaded_file($file_tmp, $destination)) {
                $new_avatar_path = $destination;
            } else {
                echo "<p style='color:red;'>Failed to upload profile picture.</p>";
            }
        } else {
            echo "<p style='color:red;'>Invalid image format. Only JPG, PNG, and GIF allowed.</p>";
        }
    }

    $query = "UPDATE users SET name = ?, email = ?, location = ?, profession = ?, avatar = ?";
    $types = "sssss";
    $params = [$updated_name, $updated_email, $updated_location, $updated_profession, $new_avatar_path];

    if (!empty($updated_password)) {
        $hashed_password = password_hash($updated_password, PASSWORD_DEFAULT);
        $query .= ", password = ?";
        $types .= "s";
        $params[] = $hashed_password;
    }

    $query .= " WHERE user_id = ?";
    $types .= "i";
    $params[] = $user_id;

    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param($types, ...$params);
        if ($stmt->execute()) {
            header("Location: DashboardProfile.php");
            exit();
        } else {
            echo "<p style='color:red;'>Error updating profile: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        die("SQL Prepare failed (Update): " . $conn->error);
    }
}

// --- Fetch skills ---
$personal_skills = [];
$professional_skills = [];

$res = $conn->query("SELECT skill_name, grade, assessed FROM personal_skill WHERE user_id = $user_id");
if ($res) $personal_skills = $res->fetch_all(MYSQLI_ASSOC);

$res = $conn->query("SELECT skill_name, grade, assessed FROM professional_skill WHERE user_id = $user_id");
if ($res) $professional_skills = $res->fetch_all(MYSQLI_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile</title>
    <link rel="stylesheet" href="../css/DashboardProfile.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="dashboard-top-bar">
        <header class="header">
            <div class="dashboard-logo">MIND<span>S</span>PHERE</div>
            <input type="text" class="search-bar" placeholder="Search Project ..." />
            <div class="right-section">
                <div class="notification">
                    <span class="bell-icon"><i class="fa-solid fa-bell"></i></span>
                    <span class="badge"><?= $notification_count ?></span>
                </div>

                <div class="profile-info">
                    <div class="avatar-info">
                        <p class="name"><?php echo htmlspecialchars($user_name); ?></p>
                        <p class="location"><?php echo htmlspecialchars($user_location); ?></p>
                    </div>
                    <img class="avatar" src="<?php echo htmlspecialchars($user_avatar); ?>" alt="Avatar" />
                    </div>
                </div>
            </div>
        </header>
    </div>

    <div class="page-body">
        <div class="dashboard-sidebar">
            <div class="dashboard-menu">
                <ul class="dashboard-menu-item">
            <li>
                <a href="../index.php"><i class="fa-solid fa-house"></i>Home</a>
            </li>
            <li>
                <a href="../dashboard/Dashboard.php" 
                ><i class="fa-solid fa-border-all"></i>Dashboard</a>
            </li>
            <li>
                <a href="../dashboard/DashboardTask.php"
                ><i class="fa-solid fa-clipboard-check"></i>Task</a>
            </li>
            <li>
                <a href="../dashboard/dashboardHabitML.php"
                ><i class="fa-solid fa-person-running"></i>Habit Tracker</a>
            </li>
            <li>
                <a href="../dashboard/DashboardChat.php"
                ><i class="fa-solid fa-comment"></i>Chat</a>
            </li>
            <li>
                <a href="../dashboard/DashboardResourceLibrary.php"
                ><i class="fa-solid fa-book"></i>Resource Library</a>
            </li>
            <li>
                <a href="../dashboard/DashboardProfile.php" class="active"
                ><i class="fa-solid fa-user"></i>Profile</a>
            </li>
            <!-- <li>
                <a href="../dashboard/DashboardSetting.php"
                ><i class="fa-solid fa-gear"></i>Setting</a>
            </li> -->
            <li>
                <a href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i>Sign Out</a>
            </li>
            </ul>
                <div class="dashboard-help-card">
                    <div class="card">
                        <p class="question-icon"><span>?</span></p>
                        <div class="help-card-content">
                            <p class="help-card-content-title">Help Center</p>
                            <p class="description">Having Trouble in Learning. Please contact us for more questions.</p>
                            <button class="button">Go To Help Center</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dashboard-content ">
            <div>
                <h1>My Profile</h1>

                <!-- Profile Section -->
                 <form method="POST" action=""  enctype="multipart/form-data">
                    <div class="profile-box">
                        <div class="profile-header">
                            <img src="<?php echo htmlspecialchars($user_avatar); ?>" class="avatar" />
                            <div class="photo-buttons">
                                <input type="file" name="avatar" accept="image/*" />
                            </div>
                        </div>

                        <label>Full Name</label>
                        <input type="text" name="name" placeholder="<?php echo htmlspecialchars($user_name); ?>"  autocomplete="off" />

                        <label>Email</label>
                        <input type="email" name="user_email" autocomplete="off" placeholder="<?php echo htmlspecialchars($user_email); ?>" />


                        <label>Address</label>
                        <input type="text" name="location" placeholder="<?php echo htmlspecialchars($user_location); ?>" autocomplete="off" />

                        <label>Change Password</label>
                        <input type="password" name="new_password" autocomplete="new-password" placeholder="New password (leave blank to keep current)" />

                        <label>Select Profession</label>
                        <select name="profession">
                            <option value="">Select your profession</option>
                            <option value="Software Engineer" <?php if ($user_profession == 'Software Engineer') echo 'selected'; ?>>Software Engineer</option>
                            <option value="Frontend Developer" <?php if ($user_profession == 'Frontend Developer') echo 'selected'; ?>>Frontend Developer</option>
                            <option value="Backend Developer" <?php if ($user_profession == 'Backend Developer') echo 'selected'; ?>>Backend Developer</option>
                            <option value="Data Scientist" <?php if ($user_profession == 'Data Scientist') echo 'selected'; ?>>Data Scientist</option>
                            <option value="UI/UX Designer" <?php if ($user_profession == 'UI/UX Designer') echo 'selected'; ?>>UI/UX Designer</option>
                        </select>

                        <div class="action-buttons">
                            <button class="btn orange" type="submit">Save</button>
                            <button class="btn cancel" type="reset">Cancel</button>
                        </div>
                    </div>
                </form>


             

                <!-- Personal Skill Section -->
               <div class="skill-section">
                <div class="section-header">
                    <h2>Personal Skill</h2>
                    <button class="icon-btn" onclick="openModal('personal')"><i class="fa-solid fa-plus"></i></button>
                </div>
                <div class="skill-table">
                    <div class="skill_row heading">
                    <p>Skills</p>
                    <p>Grade</p>
                    <p>Assessed</p>
                    <p>Proficiency Chart</p>
        </div>
        <?php foreach ($personal_skills as $skill): ?>
            <div class="skill_row skill">
                <p><?= htmlspecialchars($skill['skill_name']) ?></p>
                <p><?= $skill['grade'] ?>/5</p>
                <p class="<?= $skill['assessed'] ? 'check' : 'cross' ?>">
                    <i class="fa-solid fa-<?= $skill['assessed'] ? 'check' : 'xmark' ?>"></i>
                </p>
                <p class="stars">
                    <?php for ($i = 0; $i < $skill['grade']; $i++): ?>
                        <i class="fa-solid fa-star"></i>
                    <?php endfor; ?>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
</div>

            </div>

            <!-- Professional Skill Section -->
             <div class="skill-section">
    <div class="section-header">
        <h2>Professional Skill</h2>
        <button class="icon-btn" onclick="openModal('professional')"><i class="fa-solid fa-plus"></i></button>
    </div>
    <div class="skill-table">
        <div class="skill_row heading">
            <p>Skills</p>
            <p>Grade</p>
            <p>Assessed</p>
            <p>Proficiency Chart</p>
        </div>
        <?php foreach ($professional_skills as $skill): ?>
            <div class="skill_row skill">
                <p><?= htmlspecialchars($skill['skill_name']) ?></p>
                <p><?= $skill['grade'] ?>/5</p>
                <p class="<?= $skill['assessed'] ? 'check' : 'cross' ?>">
                    <i class="fa-solid fa-<?= $skill['assessed'] ? 'check' : 'xmark' ?>"></i>
                </p>
                <p class="stars">
                    <?php for ($i = 0; $i < $skill['grade']; $i++): ?>
                        <i class="fa-solid fa-star"></i>
                    <?php endfor; ?>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
</div>





          

            
        </div>

        <!-- Modal Popup -->
        <div class="modal" id="skill-modal">
        <div class="modal-content">
        <form method="POST" action="">
            <h3>Add Skill</h3>
            <input type="hidden"  name="skill_type" id="skill-type" value="">
            <select id="skill-name" name="skill_name" required>
                <option value="Public Speaking">Public Speaking</option>
                <option value="Negotiation">Negotiation</option>
                <option value="Driving">Driving</option>
                <option value="Team Work">Team Work</option>
                <option value="Leadership">Leadership</option>
                <option value="NEXT JS">NEXT JS</option>
                <option value="Python">Python</option>
                <option value="Machine Learning">Machine Learning</option>
                <option value="DBMS">DBMS</option>
                <option value="UI/UX Design">UI/UX Design</option>
                <option value="Data Structure">Data Structure</option>
                <option value="Blockchain">Blockchain</option>
            </select>
            <input type="number" id="skill-grade" name="skill_grade" placeholder="Grade (1-5)" min="1" max="5" required />
            <label class="checkbox_label">
                <input type="checkbox" id="skill-assessed" name="skill_assessed" /> Assessed
            </label>
            <div class="modal-buttons">
                <button class="btn orange" type="submit">Save</button>
                <button class="btn cancel" type="button" onclick="closeModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>




    </div>
    <!-- =================== HABIT TRACKER BODY END ====================== -->



    </div>
    </div>

    <script src="../js/DashboardProfile.js"></script>
</body>

</html>