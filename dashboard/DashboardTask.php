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
$stmt = $conn->prepare("SELECT id, task_name, notes, duration, priority, created_at, status, time_worked, progress, due_date FROM tasks WHERE user_id = ?");
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
    $due_date = $_POST['due_date'] ?? null;

    $stmt = $conn->prepare("INSERT INTO tasks (user_id, task_name, duration, priority, notes, progress, created_at, status, due_date) VALUES (?, ?, ?, ?, ?, ?, NOW(), 'Pending', ?)");
    if ($stmt) {
        $stmt->bind_param("issssis", $user_id, $task_name, $duration, $priority, $notes, $progress, $due_date);
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



// Handle AJAX actions before any HTML is sent
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $task_id = $_POST['task_id'];

    switch ($action) {
        case 'delete':
            $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
            $stmt->bind_param("ii", $task_id, $user_id);
            $stmt->execute();
            echo "Deleted";
            exit;
        case 'update_status':
            $new_status = $_POST['status'];
            $stmt = $conn->prepare("UPDATE tasks SET status = ? WHERE id = ? AND user_id = ?");
            $stmt->bind_param("sii", $new_status, $task_id, $user_id);
            $stmt->execute();
            echo "Status Updated";
            exit;
        case 'update_progress':
            $progress = intval($_POST['progress']);
            $stmt = $conn->prepare("UPDATE tasks SET progress = ? WHERE id = ? AND user_id = ?");
            $stmt->bind_param("iii", $progress, $task_id, $user_id);
            $stmt->execute();
            echo "Progress Updated";
            exit;
        default:
            echo "Invalid Action";
            exit;
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
        <a href="../dashboard/DashboardTask.php" class="active">Today</a>
        <a href="../dashboard/DashboardAllTask.php">All Tasks</a>
        <a href="../dashboard/DashboardTaskCompleted.php">Completed</a>
      </div>
      <div class="nav-btn">
          <button class="navBtn" id="ms-openPopupBtn">Add Task <i class="fa-solid fa-plus"></i></button>
      </div>
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
          </div>



      <!-- Task Overview Popup -->
<div id="taskov-popup-overlay" aria-hidden="true">
  <div id="taskov-popup" role="dialog" aria-modal="true" aria-labelledby="taskov-popupTitle">
    <span class="taskov-close-btn" id="taskov-closePopupBtn" aria-label="Close popup">✖</span>
    <h2 id="taskov-popupTitle"><i class="fas fa-clock"></i>&nbsp;Task Overview</h2>

    <form id="taskov-taskOverviewForm">
      <input type="hidden" id="popup-task-id" name="task_id" value="">

      <label>Task Name</label>
      <p class="task-name" id="popup-task-name"></p>

      <label>Description</label>
      <textarea readonly class="description-box" id="popup-task-desc"></textarea>

      <div class="task-meta">
        <div>
          <label>Status</label>
          <select id="popup-task-status">
            <option>Pending</option>
            <option>In Progress</option>
            <option>Completed</option>
          </select>
        </div>
        <div>
          <label>Priority</label>
          <select id="popup-task-priority">
            <option>Low</option>
            <option>Medium</option>
            <option>High</option>
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
      <input type="range" id="progressRange" name="progress" min="0" max="100" value="0" />
      <p id="progressValue">65% Completed</p>

      <div class="taskov-btn-group">
        <button type="button" class="taskov-btn-complete" id="btn-update-task">Update</button>
        <button type="button" class="taskov-btn-complete" id="btn-mark-complete">Mark as Completed</button>
        <button type="button" class="taskov-btn-remove" id="btn-delete-task">Remove Task</button>
      </div>
    </form>

  </div>
</div>



      <div class="wrapper">
        <div class="left">

          <!-- On Progress Tasks -->
        <div class="status-card">
          <h3><i class="fa-solid fa-circle"></i> On progress</h3>

          <?php foreach ($user_tasks as $task): ?>
            <?php if ($task['status'] === 'In Progress'): ?>
              <div class="inner-card"
                  data-id="<?= $task['id'] ?>"
                  data-task-name="<?= htmlspecialchars($task['task_name']) ?>"
                  data-notes="<?= htmlspecialchars($task['notes']) ?>"
                  data-priority="<?= $task['priority'] ?>"
                  data-status="<?= $task['status'] ?>"
                  data-progress="<?= $task['progress'] ?>"
                  
                  data-created="<?= date('d M, Y', strtotime($task['created_at'])) ?>"
                  data-due="<?= $task['due_date'] ? date('d M, Y', strtotime($task['due_date'])) : 'N/A' ?>">
                <div class="card-header">
                  <p class="task-status"><i class="fa-solid fa-clock"></i> <?= htmlspecialchars($task['status']) ?></p>
                  <div class="title-option">
                    <i class="fa-solid fa-pen-to-square edit-task" data-id="<?= $task['id'] ?>"></i>
                    <i class="fa-solid fa-trash delete-task" data-id="<?= $task['id'] ?>"></i>
                  </div>
                </div>
                <h4 class="taskOverview"><?= htmlspecialchars($task['task_name']) ?></h4>
                <p class="description"><?= htmlspecialchars($task['notes']) ?></p>
                <p class="priority"><?= htmlspecialchars($task['priority']) ?> Priority</p>
                <div class="progressBbar">
                  <div class="bar">
                    <div class="progress-fill" style="width: <?= intval($task['progress']) ?>%;"></div>
                  </div>
                  <p><?= intval($task['progress']) ?>%</p>
                </div>
              </div>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>

          <div class="status-card">
            <h3><i class="fa-solid fa-circle pending"></i> Pending</h3>

            <?php foreach ($user_tasks as $task): ?>
              <?php if ($task['status'] === 'Pending'): ?>
                <div class="inner-card"
                  data-id="<?= $task['id'] ?>"
                  data-task-name="<?= htmlspecialchars($task['task_name']) ?>"
                  data-notes="<?= htmlspecialchars($task['notes']) ?>"
                  data-priority="<?= $task['priority'] ?>"
                  data-status="<?= $task['status'] ?>"
                  data-progress="<?= $task['progress'] ?>"
                  data-created="<?= date('d M, Y', strtotime($task['created_at'])) ?>"
                  data-due="<?= $task['due_date'] ? date('d M, Y', strtotime($task['due_date'])) : 'N/A' ?>">
                  <div class="card-header">
                    <p class="task-status"><i class="fa-solid fa-clock pending"></i> Pending</p>
                    <div class="title-option">
                      <i class="fa-solid fa-pen-to-square edit-task" data-id="<?= $task['id'] ?>"></i>
                      <i class="fa-solid fa-trash delete-task" data-id="<?= $task['id'] ?>"></i>
                    </div>
                  </div>
                  <h4 class="taskOverview"><?= htmlspecialchars($task['task_name']) ?></h4>
                  <p class="description"><?= htmlspecialchars($task['notes']) ?></p>
                  <p class="priority"><?= htmlspecialchars($task['priority']) ?> Priority</p>
                  <div class="progressBbar mt-10">
                    <div class="icon"><i class="fa-solid fa-hourglass-end duration-icon"></i></div>
                    <div class="duration"><?= htmlspecialchars($task['duration']) ?></div>
                  </div>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>



          <div class="status-card">
            <h3><i class="fa-solid fa-circle completed"></i> Completed</h3>

            <?php foreach ($user_tasks as $task): ?>
              <?php if ($task['status'] === 'Completed'): ?>
                <div class="inner-card"
                  data-id="<?= $task['id'] ?>"
                  data-task-name="<?= htmlspecialchars($task['task_name']) ?>"
                  data-notes="<?= htmlspecialchars($task['notes']) ?>"
                  data-priority="<?= $task['priority'] ?>"
                  data-status="<?= $task['status'] ?>"
                  data-progress="<?= $task['progress'] ?>"
                  data-created="<?= date('d M, Y', strtotime($task['created_at'])) ?>"
                  data-due="<?= $task['due_date'] ? date('d M, Y', strtotime($task['due_date'])) : 'N/A' ?>">
                  <div class="card-header">
                    <p class="task-status"><i class="fa-solid fa-circle-check done"></i> Completed</p>
                    <div class="title-option">
                      <i class="fa-solid fa-pen-to-square edit-task" data-id="<?= $task['id'] ?>"></i>
                      <i class="fa-solid fa-trash delete-task" data-id="<?= $task['id'] ?>"></i>
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
              <?php endif; ?>
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
    <script>
      document.querySelectorAll(".delete-task").forEach(btn => {
        btn.addEventListener("click", () => {
          const id = btn.getAttribute("data-id");
          if (confirm("Delete this task?")) {
            fetch("", {
              method: "POST",
              headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
              body: `action=delete&task_id=${id}`
            })
            .then(res => res.text())
            .then(msg => {
              console.log(msg);
              location.reload();
            });
          }
        });
      });
    </script>
    <script>
        // Task popup open event
        document.querySelectorAll(".taskOverview").forEach(taskEl => {
        taskEl.addEventListener("click", () => {
          const card = taskEl.closest(".inner-card");
          const taskId = card.querySelector(".edit-task")?.dataset.id;
          const taskName = card.querySelector("h4").textContent;
          const notes = card.querySelector(".description").textContent;
          const priority = card.querySelector(".priority").textContent.split(" ")[0];
          const status = card.querySelector(".task-status").textContent.trim().split(" ")[1];
          // const progress = card.querySelector(".progress-fill")?.style.width?.replace('%', '') || "0";
          const progressBar = card.querySelector(".progress-fill");
          const progress = progressBar ? parseInt(progressBar.style.width.replace('%', '')) : 0;

          const createdAt = card.dataset.created;
          const dueDate = card.dataset.due;

          document.getElementById("popup-task-id").value = taskId;
          document.getElementById("popup-task-name").textContent = taskName;
          document.getElementById("popup-task-desc").value = notes;
          document.getElementById("popup-task-status").value = status;
          document.getElementById("popup-task-priority").value = priority;
          document.getElementById("progressRange").value = progress;
          document.getElementById("progressValue").textContent = progress + "% Completed";

          document.getElementById("popup-created-at").textContent = createdAt;
          document.getElementById("popup-due-date").textContent = dueDate;

          document.getElementById("taskov-popup-overlay").style.display = "block";
        });
      });

        document.getElementById("progressRange").addEventListener("input", e => {
          document.getElementById("progressValue").textContent = e.target.value + "% Completed";
        });

        // Close popup
        document.getElementById("taskov-closePopupBtn").addEventListener("click", () => {
          document.getElementById("taskov-popup-overlay").style.display = "none";
        });

        // Update task
        document.getElementById("btn-update-task").addEventListener("click", () => {
          const id = document.getElementById("popup-task-id").value;
          const status = document.getElementById("popup-task-status").value;
          const progress = document.getElementById("progressRange").value;

          fetch("", {
            method: "POST",
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `action=update_status&task_id=${id}&status=${status}`
          }).then(() => {
            return fetch("", {
              method: "POST",
              headers: {'Content-Type': 'application/x-www-form-urlencoded'},
              body: `action=update_progress&task_id=${id}&progress=${progress}`
            });
          }).then(() => {
            const card = document.querySelector(`.inner-card[data-id="${id}"]`);
            if (card) {
              card.dataset.progress = progress;
              const fill = card.querySelector(".progress-fill");
              if (fill) {
                fill.style.width = `${progress}%`;
              }
            }
            location.reload();
          });
        });

        // Mark as completed
        document.getElementById("btn-mark-complete").addEventListener("click", () => {
          const id = document.getElementById("popup-task-id").value;
          fetch("", {
            method: "POST",
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `action=update_status&task_id=${id}&status=Completed`
          }).then(() => {
            location.reload();
          });
        });

        // Delete task
        document.getElementById("btn-delete-task").addEventListener("click", () => {
          const id = document.getElementById("popup-task-id").value;
          if (confirm("Are you sure you want to delete this task?")) {
            fetch("", {
              method: "POST",
              headers: {'Content-Type': 'application/x-www-form-urlencoded'},
              body: `action=delete&task_id=${id}`
            }).then(() => {
              location.reload();
            });
          }
        });
      </script>


</body>

</html>