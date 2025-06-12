<?php
include("config/db.php");

$success = false;
$username_taken = false;

if (isset($_POST["signup"])) {

  if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["username"]) && isset($_POST["password"])) {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $check_query = "SELECT * FROM `users` WHERE `username` = '$username'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
      $username_taken = true;
    } else {
      $sql = "INSERT INTO `users` (`name`, `email`, `username`, `password`) 
                    VALUES ('$name', '$email', '$username', '$hash')";

      $result = mysqli_query($conn, $sql);

      if ($result) {
        $success = true;
      } else {
        echo "Something went wrong, Please try again!!";
      }
    }
  } else {
    echo "Fill up the form correctly!!<br>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Signup - MindSphere</title>
  <link rel="stylesheet" href="css/style.css" />
  <style>
    body.full-bg {
      margin: 0;
      height: 100vh;
      width: 100vw;
      background-color: #fff1e9;
      /* same peach */
      font-family: 'Segoe UI', sans-serif;
    }

    .center-wrapper {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100%;
      width: 100%;
    }

    .success-wrapper {
      display: flex;
      justify-content: center;
      align-items: flex-start;
      height: 100vh;
      background-color: #fff6f0;
      padding-top: 4rem;
    }

    .success-box {
      background: #fff;
      border-radius: 12px;
      padding: 2.5rem 3rem;
      text-align: center;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      max-width: 500px;
    }

    .success-box h2 {
      color: #2ecc71;
      font-weight: bold;
      font-size: 1.6rem;
    }

    .success-box a {
      display: inline-block;
      margin-top: 1rem;
      color: #6a0dad;
      text-decoration: underline;
      font-weight: 500;
    }
  </style>
</head>

<body>
  <div class="signup-body">
    <div class="container">
      <div class="main-body">

        <?php if ($success): ?>
          <div class="center-wrapper">
            <div class="success-box">
              <img src="img/success-icon.png" alt="Success" width="80" />
              <h2>Account created successfully</h2>
              <p>Please check your email for further instructions</p>
              <a href="login.php">← Back to login</a>
            </div>
          </div>
        <?php else: ?>
          <div class="image-side">
            <img src="img/signup.png" alt="Signup" />
          </div>
          <div class="form-side">
            <h1 class="logo">MIND<span class="highlight">S</span>PHERE</h1>

            <h2>Create an account</h2>
            <p class="login-text">Already have an account? <a href="login.php">Login</a></p>

            <?php if ($username_taken): ?>
              <p class="username-error">This username is already taken.</p>
            <?php endif; ?>

            <form class="form" action="signup.php" method="post">
              <input type="text" name="name" placeholder="Full name" required />
              <input type="email" name="email" placeholder="example@gmail.com" required />
              <input type="text" name="username" placeholder="Username" required />

              <div style="position: relative;">
                <input type="password" name="password" id="password" placeholder="Password" required
                  style="padding-right: 40px;">
                <span id="togglePassword"
                  style="position: absolute; right: 10px; top: 7px; cursor: pointer;">
                  👁️
                </span>
              </div>

              <label class="checkbox-container">
                <span>By signing in, you agree to our <a href="#">Terms & Conditions</a></span>
              </label>
              <button type="submit" name="signup" class="signup-button">Create account</button>
            </form>
          </div>
        <?php endif; ?>

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