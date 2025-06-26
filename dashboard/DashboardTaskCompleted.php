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
$stmt = $conn->prepare("SELECT id, task_name, notes, priority, created_at, due_date, progress FROM tasks WHERE user_id = ? AND status = 'Completed'");
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


?>






<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Task</title>
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/DashboardTaskNew.css" />
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
          <a href="../dashboard/DashboardProfile.php"><img class="avatar" src="<?php echo htmlspecialchars($user_avatar); ?>" alt="Avatar" /></a>
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
              <a href="../dashboard/DashboardTask.php" class="active"
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
      
      <div class="nav">
        <div class="nav-links">
        <a href="../dashboard/DashboardTask.php" >Today</a>
        <a href="../dashboard/DashboardAllTask.php" >All Tasks</a>
        <a href="../dashboard/DashboardTaskCompleted.php" class="active">Completed</a>
      </div>
      <div class="nav-btn">
          <button class="navBtn" id="ms-openPopupBtn">Add Task <i class="fa-solid fa-plus"></i></button>
      </div>
      </div>





          <!-- Popup Overlay
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

                <div style="display: flex; width: 100%; justify-content: space-between; margin-top: 20px;"><label for="due-date">Due Date</label>
                <input style="width: 50%;" type="date" id="due-date" name="due_date" /></div>


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
          </div> -->



      <!-- Task Overview Popup -->
<div id="taskov-popup-overlay" aria-hidden="true">
  <div id="taskov-popup" role="dialog" aria-modal="true" aria-labelledby="taskov-popupTitle">
    <span class="taskov-close-btn" id="taskov-closePopupBtn" aria-label="Close popup">✖</span>
    <h2 id="taskov-popupTitle"><i class="fas fa-clock"></i>&nbsp;Task Overview</h2>

    <form id="taskov-taskOverviewForm">
      <label>Task Name</label>
      <p class="task-name">Mindsphere Figma Design</p>

      <label>Description</label>
      <textarea readonly class="description-box">Create a modern, responsive website redesign that improves user experience and aligns with our new brand identity. This includes updating the homepage, product pages, and contact forms with a fresh design system and improved navigation structure.</textarea>

      <div class="task-meta">
        <div>
          <label>Status</label>
          <select>
            <option>Pending</option>
            <option selected>In Progress</option>
            <option>Completed</option>
          </select>
        </div>
        <div>
          <label>Priority</label>
          <select>
            <option>Low</option>
            <option>Medium</option>
            <option selected>High</option>
          </select>
        </div>
      </div>

      <div class="task-dates">
        <div>
          <label>Assigned Date</label>
          <p>10 June, 2025</p>
        </div>
        <div>
          <label>Due Date</label>
          <p>25 June, 2025</p>
        </div>
      </div>

      
      <label for="progressRange">Update Progress</label>
      <input type="range" id="progressRange" name="progress" min="0" max="100" value="65"/>
      <p id="progressValue">65% Completed</p>
    

      <div class="taskov-btn-group">
        <button type="button" style="background-color: green;" class="taskov-btn-complete">Update</button>
        <button type="button" style="background-color: green;" class="taskov-btn-complete">Mark as Completed</button>
        <button type="button" style="background-color: #FF7500;" class="taskov-btn-remove">Remove Task</button>
      </div>
    </form>
  </div>
</div>



      <div class="wrapper" style="margin-top: 1rem;">
        <div class="left" style="background-color: #fff; margin-top: 0; padding: 1.5rem; border-radius: 15px;">

          
           
            <?php foreach ($user_tasks as $task): ?>
              <div class="inner-card" data-task-id="<?= $task['id'] ?>">
                <div class="card-header">
                  <p class="task-status"><i class="fa-solid fa-circle-check done"></i> Completed</p>
                  <div class="title-option">
                    <i class="fa-solid fa-pen-to-square task-edit" data-id="<?= $task['id'] ?>"></i>
                    <i class="fa-solid fa-trash task-delete" data-id="<?= $task['id'] ?>"></i>
                  </div>
                </div>
                
                <h4 class="taskOverview"><?= htmlspecialchars($task['task_name']) ?></h4>
                <p class="description"><?= htmlspecialchars($task['notes']) ?></p>
                <p class="priority"><?= htmlspecialchars($task['priority']) ?> Priority</p>

                <div class="progressBbar mt-10">
                  <div class="icon done-fill"><i class="fa-solid fa-check duration-icon"></i></div>
                  <div class="duration">Done</div>
                </div>
              </div>
            <?php endforeach; ?>

          

        


          </div>

          
          
        </div>
        <div class="right"></div>
      </div>


    </div>
  </div>


  
  <script src="../js/task.js"></script>
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