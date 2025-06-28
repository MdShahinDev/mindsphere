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

// --- Fetch user tasks ---
$user_tasks = [];
$stmt = $conn->prepare("SELECT task_name, duration, progress FROM tasks WHERE user_id = ?");
if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $user_tasks[] = $row;
    }
    $stmt->close();
} else {
    die("SQL Prepare failed (Tasks): " . $conn->error);
}


// Handle task creation
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['task_name'])) {
    $task_name = $_POST['task_name'];
    $duration = $_POST['duration'];
    $priority = $_POST['priority'];
    $notes = $_POST['notes'] ?? '';
    $progress = 0; // default

    $stmt = $conn->prepare("INSERT INTO tasks (user_id, task_name, duration, priority, notes, progress) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("issssi", $user_id, $task_name, $duration, $priority, $notes, $progress);
        if ($stmt->execute()) {
            // Task inserted successfully
            header("Location: DashboardTask.php");
            exit();
        } else {
            die("Task Insert Failed: " . $stmt->error);
        }
    } else {
        die("Prepare Failed (Insert Task): " . $conn->error);
    }
}

// Fetch graph data for efficiency score
$stmt = $conn->prepare("
    SELECT date, MAX(score) as max_score
    FROM habit_score
    WHERE user_id = ?
    GROUP BY date
    ORDER BY date ASC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$dates = [];
$scores = [];
while ($row = $result->fetch_assoc()) {
    $dates[] = $row['date'];
    $scores[] = (int) $row['max_score'];
}
$labels = htmlspecialchars(json_encode($dates), ENT_QUOTES, 'UTF-8');
$values = htmlspecialchars(json_encode($scores), ENT_QUOTES, 'UTF-8');

// All Activity time, tasks, and other data are fetched

$stmt = $conn->prepare("SELECT duration, status FROM tasks WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$total_tasks = 0;
$completed_tasks = 0;
$total_minutes = 0;

while ($row = $result->fetch_assoc()) {
    $total_tasks++;

    if ($row['status'] === 'Completed') {
        $completed_tasks++;

        // duration format ধরুন: '5 min', '2 hrs', '1 hr', etc
        $duration = strtolower($row['duration']);
        $minutes = 0;

        if (strpos($duration, 'hr') !== false) {
            // hour আছে
            preg_match('/(\d+)\s*hr[s]?/', $duration, $matches);
            $minutes += isset($matches[1]) ? $matches[1] * 60 : 0;
        }

        if (strpos($duration, 'min') !== false) {
            preg_match('/(\d+)\s*min[s]?/', $duration, $matches);
            $minutes += isset($matches[1]) ? $matches[1] : 0;
        }

        $total_minutes += $minutes;
    }
}

$hours = floor($total_minutes / 60);
$minutes = $total_minutes % 60;
$formatted_time = sprintf("%02d:%02d:00", $hours, $minutes);
$progress_percent = $total_tasks > 0 ? round(($completed_tasks / $total_tasks) * 100) : 0;
?>






<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard | Mindsphere</title>
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
          <span class="badge">
            <?= $notification_count ?>
          </span>
        </div>

        <div class="profile-info">
          <div class="avatar-info">
            <p class="name">
              <?= htmlspecialchars($user_name) ?>
            </p>
            <p class="location">
              <?= htmlspecialchars($user_location) ?>
            </p>
          </div>
          <a href="../dashboard/DashboardProfile.php"><img class="avatar"
              src="<?php echo htmlspecialchars($user_avatar); ?>" alt="Avatar" /></a>
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
            <a href="../dashboard/Dashboard.php" class="active"><i class="fa-solid fa-border-all"></i>Dashboard</a>
          </li>
          <li>
            <a href="../dashboard/DashboardTask.php"><i class="fa-solid fa-clipboard-check"></i>Task</a>
          </li>
          <li>
            <a href="../dashboard/dashboardHabitML.php"><i class="fa-solid fa-person-running"></i>Habit Tracker</a>
          </li>
          <li>
            <a href="../dashboard/DashboardChat.php"><i class="fa-solid fa-comment"></i>Chat</a>
          </li>
          <li>
            <a href="../dashboard/DashboardResourceLibrary.php"><i class="fa-solid fa-book"></i>Resource Library</a>
          </li>
          <li>
            <a href="../dashboard/DashboardProfile.php"><i class="fa-solid fa-user"></i>Profile</a>
          </li>
          <!-- <li>
              <a href="../dashboard/DashboardSetting.php" class="active"
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
      <div class="date-header">
        <div class="date-time">
          <h3>Today</h3>
          <p>June 22, 2025 | 09:10 AM</p>
        </div>
        <div class="avctivity">
          <div class="time-tracker">
            <div class="text-card">
              <p class="title">Start Pomodoro</p>
              <p class="description">You can start tracking</p>
            </div>
            <button class="task-button pomodoro-open-btn" id="openPopup"><i class="fa-solid fa-play"></i></button>
            <!-- <button class="pomodoro-open-btn">Start Pomodoro</button> -->
          </div>




          <!-- Pomodoro Popup -->
          <div id="pomodoro-overlay" class="hidden" style="display: none;">
            <div class="pomodoro-popup">
              <span class="close-btn" id="pomodoro-close">✖</span>
              <span class="settings-btn" id="pomodoro-settings"><i class="fa-solid fa-ellipsis-vertical"
                  id="settings-icon"></i></span>

              <div class="tab-buttons">
                <button class="tab active" data-mode="pomodoro">Pomodoro</button>
                <button class="tab" data-mode="short">Short Break</button>
                <button class="tab" data-mode="long">Long Break</button>
              </div>

              <div class="timer-config hidden" id="timer-settings">
                <label>Pomodoro (min): <input type="number" id="pomodoro-time" value="25" min="1" /></label>
                <label>Short Break (min): <input type="number" id="short-time" value="5" min="1" /></label>
                <label>Long Break (min): <input type="number" id="long-time" value="15" min="1" /></label>
              </div>

              <div id="timer-area">
                <div class="timer-circle">
                  <div class="timer-display" id="timer-display">25:00</div>
                </div>
                <button id="start-timer">Start</button>
              </div>

              <audio id="alarm-audio" src="../alarm.mp3" preload="auto"></audio>
            </div>
          </div>





          <div class="taske-create">
            <div class="text-card">
              <p class="title">Create Task</p>
              <p class="description">Create a new task</p>
            </div>
            <button class="task-button" id="ms-openPopupBtn"><i class="fa-solid fa-plus"></i></button>
          </div>




          <!-- Popup Overlay -->
          <div id="ms-popup-overlay" aria-hidden="true">
            <div id="ms-popup" role="dialog" aria-modal="true" aria-labelledby="ms-popupTitle">
              <span class="ms-close-btn" id="ms-closePopupBtn" aria-label="Close popup">✖</span>
              <h2 id="ms-popupTitle"> <span><i class="fas fa-plus"> &nbsp;</i></span> Add New Task</h2>


              <form id="ms-taskForm" method="POST" action="">
                <label for="ms-taskName">Task Name *</label>
                <input type="text" name="task_name" id="ms-taskName" placeholder="Enter task name..." required />

                <label for="ms-notes">Notes</label>
                <textarea name="notes" id="ms-notes" rows="4" placeholder="Add notes"></textarea>

                <label for="ms-duration">Duration</label>
                <select name="duration" id="ms-duration">
                  <option>5 min </option>
                  <option>15 min</option>
                  <option>30 min</option>
                  <option>1 hr</option>
                  <option>2 hrs</option>
                  <option>3 hrs</option>
                </select>

                <div style="display: flex; width: 100%; justify-content: space-between; margin-top: 20px;"><label
                    for="due-date">Due Date</label>
                  <input style="width: 50%;" type="date" id="due-date" name="due_date" />
                </div>

                <label>Priority Level *</label>
                <input type="hidden" name="priority" id="ms-priority-value" value="High">
                <div class="ms-priority-levels">
                  <div class="ms-priority-level ms-high selected" data-priority="High">High</div>
                  <div class="ms-priority-level ms-medium" data-priority="Medium">Medium</div>
                  <div class="ms-priority-level ms-low" data-priority="Low">Low</div>
                </div>

                <div class="ms-btn-group">
                  <button type="button" class="ms-btn-cancel" id="ms-cancelBtn">Cancel</button>
                  <button type="submit" class="ms-btn-create">Create Task</button>
                </div>
              </form>
            </div>
          </div>




        </div>
      </div>
      <div class="data-card">
        <div class="activity-data-card">
          <div class="single-data-card">
            <div class="data-card-text">
              <p class="title">Weekly Activity</p>
              <p>:</p>
            </div>
            <div class="data-card-text">
              <p class="progress"><?php echo $progress_percent; ?>%</p>
              <p class="icon"><i class="fa-solid fa-code-merge"></i></p>
            </div>
          </div>
          <div class="single-data-card">
            <div class="data-card-text">
              <p class="title">Worked This Week</p>
              <p>:</p>
            </div>
            <div class="data-card-text">
              <p class="progress"><?php echo $formatted_time; ?></p>
              <p class="icon"><i class="fa-solid fa-arrow-rotate-right"></i></p>
            </div>
          </div>
          <div class="single-data-card">
            <div class="data-card-text">
              <p class="title">Task Worked</p>
              <p>:</p>
            </div>
            <div class="data-card-text">
              <p class="progress"><?php echo $completed_tasks; ?></p>
              <p class="icon"><i class="fa-regular fa-folder"></i></p>
            </div>
          </div>
        </div>
        <div class="bottom-section">

        <!-- ====== CHART START ====== -->

          <div class="recent-activity">
            <div class="recent-activity-title">
              <h2>Efficiency Score Progression</h2>
              <p>:</p>
            </div>


            <!-- <div id="chartData" 
              data-labels='["2025-06-01", "2025-06-05", "2025-06-10", "2025-06-15", "2025-06-20", "2025-06-25"]'
              data-values='[72, 85, 60, 90, 78, 50]'></div> -->
            <div id="chartData"
     data-labels='<?php echo $labels; ?>'
     data-values='<?php echo $values; ?>'></div>
            <canvas id="efficiencyChart" width="400" height="200"></canvas>

         <!-- ====== CHART END ====== -->
          </div>



          <div class="tasks-section">
            <div class="title">
              <h2>Tasks</h2>
              <div class="task-list">
                <?php if (empty($user_tasks)): ?>
                <p>No tasks created yet.</p>
                <?php else: ?>
                <?php foreach ($user_tasks as $task): ?>
                <div class="task-item">
                  <div class="task-info">
                    <i class="fa-regular fa-folder"></i>
                    <?php
                $task_name = htmlspecialchars($task['task_name']);
                $display_name = mb_strlen($task_name) > 5 ? mb_substr($task_name, 0, 5) . '...' : $task_name;
              ?>
                    <span>
                      <?= $display_name ?>
                    </span>
                  </div>
                  <div class="task-meta">
                    <span class="time">
                      <?= htmlspecialchars($task['duration']) ?>
                    </span>
                    <div class="progress-bar">
                      <div class="progress" style="width: <?= intval($task['progress']) ?>%;"></div>
                    </div>
                  </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
              </div>
              <a href="../dashboard/DashboardTask.php" class="view-all-btn">View All</a>
            </div>
          </div>


        </div>
      </div>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="../js/chart.js"></script>
  <script src="../js/script.js"></script>
  <script>
    // Priority level selection logic
    document.querySelectorAll('.ms-priority-level').forEach(level => {
      level.addEventListener('click', () => {
        document.querySelectorAll('.ms-priority-level').forEach(l => l.classList.remove('selected'));
        level.classList.add('selected');
        document.getElementById('ms-priority-value').value = level.dataset.priority;
      });
    });
  </script>
</body>

</html>