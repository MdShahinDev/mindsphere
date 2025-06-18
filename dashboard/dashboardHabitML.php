<?php
include("../config/db.php");

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

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

$stmt = $conn->prepare("SELECT name, location FROM users WHERE user_id = ?");
if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $user_name = $row['name'];
        $user_location = $row['location'];
    }
    $stmt->close();
} else {
    die("SQL Prepare failed (User Info): " . $conn->error);
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MindSphere - Habit tracker</title>
    
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/DashboardHabitML.css" />
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
                        <p class="name"><?= htmlspecialchars($user_name) ?></p>
                        <p class="location"><?= htmlspecialchars($user_location) ?></p>
                    </div>
                    <img class="avatar" src="../img/profilePicture.png" alt="Avatar" />
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
                ><i class="fa-solid fa-border-all"></i>Dashboard</a
              >
            </li>
            <li>
              <a href="../dashboard/DashboardTask.php"
                ><i class="fa-solid fa-clipboard-check"></i>Task</a
              >
            </li>
            <li>
              <a href="../dashboard/dashboardHabitML.php" class="active"
                ><i class="fa-solid fa-person-running"></i>Habit Tracker</a
              >
            </li>
            <li>
              <a href="../dashboard/DashboardChat.php"
                ><i class="fa-solid fa-comment"></i>Chat</a
              >
            </li>
            <li>
              <a href="../dashboard/DashboardResourceLibrary.php"
                ><i class="fa-solid fa-book"></i>Resource Library</a
              >
            </li>
            <li>
              <a href="../dashboard/DashboardProfile.php"
                ><i class="fa-solid fa-user"></i>Profile</a
              >
            </li>
            <!-- <li>
              <a href="../dashboard/DashboardSetting.php"
                ><i class="fa-solid fa-gear"></i>Setting</a
              >
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
            <div class="dashboard">
                <div class="header2">
                    <div>
                        <h1>Good morning, <?= htmlspecialchars($user_name) ?></h1>
                        <p class="subtitle">12 hrs 44 mins till bedtime</p>
                    </div>
                    <div class="datetime">
                      <h2 id="dayName">Loading...</h2>
                      <p id="fullDate">Loading date and time...</p>
                    </div>
                </div>

              <form>
                <div class="main">
                    <div class="left">
                        <div class="tabs-card">
                            <div class="health_tabs">
                                <button class="tab active" onclick="showTab(event, 'health')">Health</button>
                                <button class="tab" onclick="showTab(event, 'wellness')">Wellness</button>
                                <button class="tab" onclick="showTab(event, 'productivity')">Productivity</button>
                                <button class="tab" onclick="showTab(event, 'learning')">Learning</button>
                            </div>
                        </div>

                        <div class="content-card">
                            <div class="card-header">
                                <span>Habit Checklist</span>
                                <span>Habit Path</span>
                            </div>
                            <div id="checklist" class="checklist">
                                <!-- JS will populate -->
                            </div>
                            <div class="action-btns">
                                <button class="update">Update</button>
                                <button class="cancel">Cancel</button>
                            </div>
                        </div>
                    </div>

                    <div class="right">
                        <div class="calendar-section" style="display: flex; gap: 1rem;">
                      
                            <input style="width: 100%;" type="date" id="dob" name="dob" value="2025-06-17" min="2020-01-01" max="2030-12-31" required>

                            
                        </div>
                        <div class="quote-box">
                            <div style="text-align: center; margin-bottom: 2rem;"><h3 style="font-style: normal; margin-bottom: 1rem;">Efficiency Score: <span>70</span> </h3>
                            <button class="update">Get Suggestion</button></div>
                            <h3>🧠 <em>Motivation</em></h3>
                            <p style="padding-bottom: 2rem;">“Take care of your body.<br>It’s the only place you have to live.”<br><strong>— Jim
                                    Rohn</strong></p>
                        </div>
                    </div>
                </div>
              </form>
            </div>

        </div>




    </div>
    <!-- =================== HABIT TRACKER BODY END ====================== -->



    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="../js/DashboardHabitML.js"></script>
    <script>
      function updateDateTime() {
          const now = new Date();

          const dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
          const dayName = dayNames[now.getDay()];

          const monthNames = ["January", "February", "March", "April", "May", "June",
                              "July", "August", "September", "October", "November", "December"];
          const month = monthNames[now.getMonth()];
          const date = now.getDate();
          const year = now.getFullYear();

          let hours = now.getHours();
          const minutes = now.getMinutes().toString().padStart(2, '0');
          const ampm = hours >= 12 ? 'PM' : 'AM';
          hours = hours % 12 || 12;

          const fullDate = `${month} ${date}, ${year} | ${hours}:${minutes} ${ampm}`;

          document.getElementById("dayName").textContent = dayName;
          document.getElementById("fullDate").textContent = fullDate;
      }

      updateDateTime();
      setInterval(updateDateTime, 60000);
    </script>

</body>

</html>