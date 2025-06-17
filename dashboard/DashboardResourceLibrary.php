<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MindSphere Chat</title>
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/DashboardResourceLibrary.css" />
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
        <input type="text" class="search-bar" placeholder="Search Project ..." />
        <div class="right-section">
          <div class="notification">
            <span class="bell-icon"><i class="fa-solid fa-bell"></i></span>
            <span class="badge">12</span>
          </div>

          <div class="profile-info">
            <div class="avatar-info">
              <p class="name">Vladimir Putin</p>
              <p class="location">Moscow, Russia</p>
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
              <a href="../dashboard/DashboardResourceLibrary.php" class="active"
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
        <h2>All Resources</h2>
        <div class="wrapper-div">


            <div class="card">
                <img src="../img/rl_books.png" alt="">
                <p><a href=""> <span><i class="fa-solid fa-book"></i></span> Books</a></p>
            </div>


            <div class="card">
                <img src="../img/rl_podcast.png" alt="">
                <p><a href=""> <span><i class="fa-solid fa-microphone-lines"></i></span> Podcast</a></p>
            </div>

            <div class="card">
                <img src="../img/rl_course.png" alt="">
                <p><a href="../resourceLibrarayCourse.php"> <span><i class="fa-solid fa-play"></i></span> Courses</a></p>
            </div>

            <div class="card">
                <img src="../img/rl_researchPaper.png" alt="">
                <p><a href=""> <span><i class="fa-brands fa-researchgate"></i></span> Research Paper</a></p>
            </div>

          
        </div>
      </div>


      
    </div>
  </body>
</html>
