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
  <title>Chat</title>
  <link rel="stylesheet" href="../css/style.css" />
  <!-- Font Awesome CDN Link -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />
</head>

<body>
  <div class="dashboard-top-bar">
    <header class="header">
      <div class="dashboard-logo">MIND<span>S</span>PHERE</div>
      <input
        type="text"
        class="search-bar"
        placeholder="Search Project ..." />
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
              <a href="../dashboard/dashboardHabitML.php" 
                ><i class="fa-solid fa-person-running"></i>Habit Tracker</a
              >
            </li>
            <li>
              <a href="../dashboard/DashboardChat.php" class="active"
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
    <div class="dashboard-content">
      <div class="dashboard-chat">
        <div class="chat-button">
          <button><i class="fa-solid fa-plus"></i> New Chat</button>
        </div>
        <div class="chat-main-section">
          <div class="chat-title">
            <p>Welcome to Mindsphere AI</p>
            <h2>Ask me anything - I’m help to here!</h2>
          </div>
          <!-- <div class="">
              <div class="chat-message-box">
                <textarea name="" rows="6" id=""></textarea>
                <div>
                  <button class="send-button">
                    <i class="fa-solid fa-paper-plane"></i> Send
                  </button>
                  <button class="send-button">
                    <i class="fa-solid fa-paper-plane"></i> Upload File
                  </button>
                  <button class="send-button">
                    <i class="fa-solid fa-paper-plane"></i> Voice Message
                  </button>
                  <button><i class="fa-solid fa-paper-plane"></i></button>
                </div>
              </div>
            </div> -->
          <div class="chatbox-container">
            <textarea
              class="chatbox-input"
              placeholder="Whatever you need just ask Mindsphere !"
              maxlength="10000"></textarea>
            <div class="chatbox-footer">
              <div class="chatbox-actions">
                <!-- <span>📎 Attach File</span>
                  <span>📁 Upload File</span>
                  <span>🎙️ Voice message</span> -->
                <button class="send-button">
                  <i class="fa-solid fa-link"></i>Attach File
                </button>
                <button class="send-button">
                  <i class="fa-solid fa-file-arrow-up"></i> Upload File
                </button>
                <button class="send-button">
                  <i class="fa-solid fa-microphone"></i> Voice Message
                </button>
              </div>
              <div class="chatbox-meta">
                <span class="char-count">00/10,000</span>
                <button class="chat-send-button"><i class="fa-solid fa-paper-plane"></i></button>
              </div>
            </div>
          </div>
          <div class="instruction">
            <h2>Explore by ready prompt</h2>
            <div class="instruction-box">
              <div class="instruction-box-item">
                <i class="fa-solid fa-arrow-up-right-dots"></i>
                <h4>Personal Development</h4>
                <p>Enhance your habits and mindset with tools designed for self-improvement.</p>
              </div>
              <div class="instruction-box-item">
                <i class="fa-solid fa-gear"></i>
                <h4>Productivity Analysis</h4>
                <p>Track, analyze, and optimize your work patterns to focus and efficiency.</p>
              </div>
              <div class="instruction-box-item">
                <i class="fa-solid fa-list-check"></i>
                <h4>Task Management</h4>
                <p>Plan, organize, and complete tasks effectively to meet deadlines accomplishment.</p>
              </div>
              <div class="instruction-box-item">
                <i class="fa-solid fa-book-open"></i>
                <h4>Learning & Motivation</h4>
                <p>Access resources to fuel your motivation and expand your skills continuously.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>