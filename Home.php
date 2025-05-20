<?php
session_start();
include 'config.php';
$islogin;
?>



<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="Home-style.css">
        <meta charset="UTF-8">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Special+Gothic+Condensed+One&family=Special+Gothic+Expanded+One&display=swap" rel="stylesheet">

        <title>Maastricht Connect</title>
        <link rel="icon" type="image/png" href="Pictures/Maastricht-Connect-Logo.png">
</head>
    </head>
    <body>
        <div class="background">
            <div class="nav-bar">
                <div class="nav-bar-buttons">
                    <a class="login1" href="social-media.php">Discover Events</a>
                    <a class="about-us" href="#scroll">About Us</a>
                    <a class="contact-us">Contact Us</a>
                </div>
                <div class="profile-wrap">
                    <div class="profile" id="profile"></div>
                    <div class="login_window" id="loginwindow">
                        <label for="username" class="welcome-login-window">Welcome back</label>
                        <label for="username" class="username-login-window">
                            <?php 
                                if (isset($_SESSION['username'])) {
                                    echo $_SESSION['username'];
                                } else {
                                    echo "Guest";
                                }
                            ?>
                        </label>
                        <a class="login" href="login.html" id="login">Login</a>
                        <a class="signup" href="register.html" id="signup">Sign Up</a>
                    </div>
                </div>
            </div>
            <h1 class="page-title">Maastricht Connect</h1>
        </div>
    
        <div class="about-us-page">
            <h1 id="scroll">Scroll Down</h1>
            <p>This is content below the background image.</p>
            <p>This is content below the background image.</p>
            <p>This is content below the background image.</p>
            <p>This is content below the background image.</p>
            <p>This is content below the background image.</p>
            <p>This is content below the background image.</p>
            <p>This is content below the background image.</p>
        </div>

        <script>
document.addEventListener("DOMContentLoaded", () => {
  // Grab the container
  const loginwindow = document.getElementById("loginwindow");

  // Determine login state from PHP
  const islogin = <?php echo isset($_SESSION['username']) ? 'true' : 'false'; ?>;

  function renderButtons() {
    // 1) wipe out everything inside
    loginwindow.innerHTML = '';

    console.log(islogin);

    // 2) always show the welcome labels
    const welcome = document.createElement('label');
    welcome.className = 'welcome-login-window';
    welcome.textContent = 'Welcome back';
    loginwindow.appendChild(welcome);

    const userLabel = document.createElement('label');
    userLabel.className = 'username-login-window';
    userLabel.textContent = '<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : "Guest"; ?>';
    loginwindow.appendChild(userLabel);

    // 3) append the correct buttons
    if (islogin) {
      const logout = document.createElement('a');
      logout.id = 'logout';
      logout.className = 'signup';
      logout.href = 'logout.php';
      logout.textContent = 'Logout';
      loginwindow.appendChild(logout);

      const profile = document.createElement('a');
      profile.id = 'profile';
      profile.className = 'signup';
      profile.href = 'profile.php';
      profile.textContent = 'Edit Profile';
      loginwindow.appendChild(profile);
    } else {
      const login = document.createElement('a');
      login.id = 'login';
      login.className = 'login';
      login.href = 'login.html';
      login.textContent = 'Login';
      loginwindow.appendChild(login);

      const signup = document.createElement('a');
      signup.id = 'signup';
      signup.className = 'signup';
      signup.href = 'register.html';
      signup.textContent = 'Sign Up';
      loginwindow.appendChild(signup);
    }
  }

  renderButtons();
});
</script>

    </body>
    
</html>

