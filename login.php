<?php
include("config/db.php");

$login_error = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $query = "SELECT * FROM `users` WHERE `email` = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
      $row = mysqli_fetch_assoc($result);
      if (password_verify($password, $row["password"])) {
        session_start();
        $_SESSION["user_id"] = $row["user_id"];
        $_SESSION["email"] = $row["email"];
        $_SESSION["username"] = $row["username"];
        $_SESSION["name"] = $row["name"];

        header("Location: dashboard/Dashboard.php"); 
        
        exit();
      } else {
        $login_error = true;
      }
    } else {
      $login_error = true;
    }
  } else {
    $login_error = true;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - MindSphere</title>
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <div class="loginPage">
      <div class="loginContainer">
        <div class="form-container">
          <div class="logo">MIND<span class="highlight">S</span>PHERE</div>
          <h2>Welcome Back 👋</h2>
          <p class="subtitle">
            Today is a new day. It's your day. You shape it. <br />
            Sign in to start managing your projects.
          </p>

          <?php if ($login_error): ?>
            <p class="login-error" style="color: red; margin-bottom: 10px;">Invalid email or password.</p>
          <?php endif; ?>

          <form class="form" action="login.php" method="post">
            <label>Email</label>
            <input type="email" name="email" placeholder="example@gmail.com" required />

            <div div style="position: relative; z-index: 3;">
                <input type="password" name="password" id="password" placeholder="Your Password" required
                  style="padding-right: 40px;">
                <span id="togglePassword"
                  style="position: absolute; right: 10px; top: 7px; cursor: pointer;">
                  👁️
                </span>
              </div>

            <div class="actions">
              <a href="forgotpass.html" class="forgot">Forgot Password?</a>
            </div>

            <button type="submit" class="btn">Sign In</button>
          </form>
          <p class="signup-text">Don’t have an account? <a href="signup.php">Sign up</a></p>
        </div>
        <div class="image-container">
          <img src="img/login.png" alt="Login" />
        </div>
      </div>
    </div>
      <script>
        document.querySelector("form").addEventListener("submit", function(e) {
        const emailInput = document.querySelector('input[name="email"]');
        const email = emailInput.value;
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailPattern.test(email)) {
          e.preventDefault();
          alert("Please enter a valid email address (must contain @ and .)");
        }
    });
    </script>
  
  </body>
</html>

<?php
mysqli_close($conn);
?>

<script>
  const togglePassword = document.getElementById('togglePassword');
  const passwordInput = document.getElementById('password');

  togglePassword.addEventListener('click', function() {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    this.textContent = type === 'password' ? '👁️' : '👁️';
  });
</script>