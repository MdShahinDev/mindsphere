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


// ---- Determine current time period ----
date_default_timezone_set("Asia/Dhaka"); // Adjust if needed
$hour = (int)date("H");

if ($hour >= 5 && $hour < 12) {
    $time_period = 'morning';
} elseif ($hour >= 12 && $hour < 16) {
    $time_period = 'noon';
} elseif ($hour >= 16 && $hour < 18) {
    $time_period = 'afternoon';
} elseif ($hour >= 18 && $hour < 20) {
    $time_period = 'evening';
} else {
    $time_period = 'night';
}

// ---- Fetch a random quote from DB based on time period ----
$quote_text = "Stay strong. Keep going.";
$quote_author = "Unknown";

$stmt = $conn->prepare("SELECT quote, author FROM motivational_quotes WHERE time_period = ? ORDER BY RAND() LIMIT 1");
if ($stmt) {
    $stmt->bind_param("s", $time_period);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $quote_text = $row['quote'];
        $quote_author = $row['author'];
    }
    $stmt->close();
}

// ---- Fetch a second (different) quote for subtitle ----
$subtitle_quote = "Let's make today count.";
$subtitle_author = "Unknown";

$stmt2 = $conn->prepare("SELECT quote, author FROM motivational_quotes WHERE time_period = ? ORDER BY RAND() LIMIT 1 OFFSET 1");
if ($stmt2) {
    $stmt2->bind_param("s", $time_period);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    if ($row2 = $result2->fetch_assoc()) {
        $subtitle_quote = $row2['quote'];
        $subtitle_author = $row2['author'];
    }
    $stmt2->close();
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
                    <a href="../dashboard/DashboardProfile.php"><img class="avatar" src="../img/profilePicture.png" alt="Avatar" /></a>
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
                        <h1 id="greeting">Loading...</h1>
                        <p class="subtitle"><?= htmlspecialchars($subtitle_quote) ?></p>
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
                                <a href="../dashboard/dashboardHabitML.php" class="tab" >Health</a>
                                <a href="../dashboard/dashboardHabitMLWellness.php" class="tab" >Wellness</a>
                                <a href="../dashboard/dashboardHabitMLProductivity.php" class="tab  active" >Productivity</a>
                                <a href="../dashboard/dashboardHabitMLLearning.php" class="tab" >Learning</a>
                            </div>
                        </div>

                        <div class="content-card">
                            <div class="card-header">
                                <span>Habit Checklist</span>
                                <span>Habit Path</span>
                            </div>
                           
                                

   <div class="tracker-row">
      <label><input type="checkbox" name="work_hours">Work Hours</label>
      <select>
        <option>Less than 4 hrs</option>
        <option>4-6 hrs</option>
        <option>6-8 hrs</option>
        <option>More than 8 hrs</option>
      </select>
    </div>

    <div class="tracker-row">
      <label><input type="checkbox" name="social_media_usage">Social Media Usage</label>
      <select>
        <option>0 Min</option>
        <option>15 min</option>
        <option>1 hr</option>
        <option>1 hr</option>
        <option>Overused+</option>
      </select>
    </div>

    <div class="tracker-row">
      <label><input type="checkbox" name="task_done">Tasks Done</label>
      <select>
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5+</option>
        
      </select>
    </div>

    <div class="tracker-row">
      <label><input type="checkbox" name="blood_pressure">Pomodoro Session</label>
      <select>
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5</option>
        <option>6</option>
        <option>7</option>
        <option>8</option>
        <option>9</option>
        <option>10</option>
        <option>10+</option>
      </select>
    </div>
    <div class="tracker-row">
      <label><input type="checkbox" name="meal">Break Time</label>
      <select>
        <option>Short</option>
        <option>Medium</option>
        <option>Long</option>
        
      </select>
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
                            <p style="padding-bottom: 2rem;">
                                “<?= nl2br(htmlspecialchars($quote_text)) ?><br><strong>— <?= htmlspecialchars($quote_author) ?></strong>
                            </p>
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

    <script>
      function getGreeting() {
          const now = new Date();
          const hour = now.getHours();
          let greeting = "";

          if (hour >= 5 && hour < 12) {
              greeting = "Good morning,";
          } else if (hour >= 12 && hour < 16) {
              greeting = "Good noon,";
          } else if (hour >= 16 && hour < 18) {
              greeting = "Good afternoon,";
          } else if (hour >= 18 && hour < 20) {
              greeting = "Good evening,";
          } else {
              greeting = "Good night,";
          }

          return greeting;
      }

      function showGreeting(userName) {
          const greetingText = `${getGreeting()} ${userName}`;
          document.getElementById("greeting").textContent = greetingText;
      }

      const userName = <?= json_encode($user_name) ?>;
      showGreeting(userName);
    </script>

</body>

</html>