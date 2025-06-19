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
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/style.css" />
    <!-- Font Awesome CDN Link -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
      integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
  </head>
  <body>
    <div class="dashboard-top-bar">
      <header class="header">
        <div class="dashboard-logo">MIND<span>S</span>PHERE</div>
        <input
          type="text"
          class="search-bar"
          placeholder="Search Project ..."
        />
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
              <a href="../dashboard/Dashboard.php" class="active"
                ><i class="fa-solid fa-border-all"></i>Dashboard</a
              >
            </li>
            <li>
              <a href="../dashboard/DashboardTask.php"
                ><i class="fa-solid fa-clipboard-check"></i>Task</a
              >
            </li>
            <li>
              <a href="../dashboard/dashboardHabitML.php"
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
      <!-- Dashboard Content -->
      <div class="dashboard-content">
        <div class="dashboard-full-content">
          <div class="dashboard-left">
            <div class="left-top">
              <div class="my-task-card">
                <h2>My Task</h2>
                <div class="time-frame">
                  <button>Recently</button>
                  <button>Today</button>
                  <button>Upcomming</button>
                  <button>Later</button>
                </div>
                <p class="mini-title">Make a landing page and mobile app</p>
                <div class="image-card">
                  <img src="../img/1.jpg" alt="" />
                  <img src="../img/2.jpg" alt="" />
                  <img src="../img/3.jpg" alt="" />
                  <img src="../img/4.jpg" alt="" />
                </div>
                <div class="progress-header">
                  <span class="progress-text-label">Progress</span>
                  <span class="progress-value-display">35%</span>
                </div>
                <div class="progress-bar-visual">
                  <div class="progress-bar-actual" style="width: 35%"></div>
                </div>
              </div>
              <div class="task-tracker">
                <h2>Task tracker</h2>
                <h2 class="task-tracker-count">65</h2>
                <div class="task-tracker-parcentage">
                  <div class="circle-progress-value">
                    <svg class="progress-ring" width="80" height="80">
                      <circle class="progress-ring-bg" cx="40" cy="40" r="34" />
                      <circle
                        class="progress-ring-fill"
                        cx="40"
                        cy="40"
                        r="34"
                      />
                    </svg>
                    <div class="progress-text">45%</div>
                  </div>

                  <div class="numberOfTask">
                    <p>100</p>
                    <p>Task</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="left-bottom">
              <div class="performance-and-date">
                <h3>Performance</h3>
                <input type="date" class="date-picker" />
              </div>
              <p class="left-bottom-week">Last Week</p>

              <div class="performance-section">
                <img src="../img/performanc-chart.png" alt="" />
                <div class="performance-chart">
                  <div class="chart-heading">
                    <p>Long terms Goal</p>
                    <span><i class="fa-solid fa-angle-down"></i></span>
                  </div>
                  <div class="circle-percentage">
                    <p class="parcentage-value">25%</p>
                  </div>
                  <div class="goal-achive">
                    <div class="goal-dot"></div>
                    <h4>Goal Achive</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="dashboard-right">
            <div class="dashboard-right-icon-box">
              <i class="fa-solid fa-calendar-days"></i>
              <i class="fa-solid fa-bell"></i>
              <i class="fa-regular fa-comment"></i>
            </div>
            <!-- Right side Notification -->
            <div class="deadline">
              <div class="deadline-icon">
                <i class="fa-regular fa-bell"></i>
                <div>
                  <p class="deadline-title">Deadline</p>
                  <p>Rebranding meeting 1 Hour</p>
                </div>
              </div>
              <button class="close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="deadline">
              <div class="deadline-icon">
                <i class="fa-regular fa-bell"></i>
                <div>
                  <p class="deadline-title">Task Update:</p>
                  <p>2 completed, 3 pending, 2 in progress.</p>
                </div>
              </div>
              <button class="close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="deadline">
              <div class="deadline-icon">
                <i class="fa-regular fa-bell"></i>
                <div>
                  <p class="deadline-title">Exciting News:</p>
                  <p>
                    Taskly's new AI for work planning makes work easy and
                    faster!
                  </p>
                </div>
              </div>
              <button class="close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="task-header">
              <h3>Task</h3>
              <div class="pencil-icon">
                <i class="fa-solid fa-file-pen"></i>
              </div>
            </div>
            <div class="check-field">
              <div class="check-field-item">
                <input type="checkbox" id="check1" />
                <label for="check1">Schedule post Dusk&Dawn</label>
              </div>
              <div class="check-field-item">
                <input type="checkbox" id="check2" />
                <label for="check2">Design post for Holi</label>
              </div>
              <div class="check-field-item">
                <input type="checkbox" id="check3" />
                <label for="check3">Brainstorming new project</label>
              </div>
              <div class="check-field-item">
                <input type="checkbox" id="check4" />
                <label for="check4">Re-Branding Discussion</label>
              </div>
              <div class="check-field-item">
                <input type="checkbox" id="check5" />
                <label for="check5">User Reaserch</label>
              </div>
              <div class="dashboard-right-button">
                <button>Schedule Task</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
