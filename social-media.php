<?php
session_start();
require 'config.php';
/*$conn->query("DELETE FROM posts");*/


// Get all posts, newest first
$result = $conn->query("
  SELECT p.*, u.username
  FROM posts p
  JOIN users u ON p.user_id = u.id
  ORDER BY p.created_at DESC
");
$posts = $result->fetch_all(MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="social-media-style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maastricht Connect</title>
    <link rel="icon" type="image/png" href="Pictures/Maastricht-Connect-Logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Special+Gothic&family=Special+Gothic+Condensed+One&family=Special+Gothic+Expanded+One&display=swap" rel="social-media-style.css">
</head>
<body>
    <div class="nav-bar">
        <ul class="nav-bar-ul">
            <a class="home" href="home.php">Home</a>
            <a class="post" href="post.php">Post</a>
        </ul>
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

    <div class="post-wrap" id="post-wrap">

    <?php foreach ($posts as $p): ?>
      <div class="uploaded-post">
    <h2><?= htmlspecialchars($p['title']) ?></h2>

    <p><strong>Description:</strong> <?php echo htmlspecialchars($p['description']); ?></p>
    <p><strong>City:</strong>        <?php echo htmlspecialchars($p['city']); ?></p>
    <p><strong>Address:</strong>     <?php echo htmlspecialchars($p['address']); ?></p>
    <p><strong>Date:</strong>        <?php echo htmlspecialchars($p['date']); ?></p>
    <?php if (!empty($p['image'])): ?>
      <img class="img-post"
        src="<?= htmlspecialchars($p['image']) ?>"
        alt="Post image"
        style="max-width:100%; height:auto; margin-bottom:1ch;"
      >

    <?php endif; ?>
  </div>


<?php endforeach; ?>


        
    </div>


    


    <script>
  document.addEventListener("DOMContentLoaded", () => {
    const loginwindow = document.getElementById("loginwindow");
    const islogin = <?php echo $islogin ? 'true' : 'false'; ?>;

    function renderButtons() {
      loginwindow.innerHTML = `
        <label class="welcome-login-window">Welcome back</label>
        <label class="username-login-window">
          ${<?php echo $islogin ? json_encode($_SESSION['username']) : "'Guest'"; ?>}
        </label>
      `;

      if (islogin) {
        loginwindow.innerHTML += `<a id="logout" class="signup" href="logout.php">Logout</a>`;
      } else {
        loginwindow.innerHTML += `
          <a id="login" class="login" href="login.html">Login</a>
          <a id="signup" class="signup" href="register.html">Sign Up</a>
        `;
      }
    }

    renderButtons();
  });
  </script>



  <script>
      var posted = <?php echo $posted ? 'true' : 'false'; ?>;
      var islogin = <?php echo isset($_SESSION['username']) ? 'true' : 'false'; ?>;
        if (posted == true && islogin == true) {
            console.log(1)
            var div1 = document.createElement("div");
            div1.className = "uploaded-post";
            document.querySelector(".post-wrap").appendChild(div1);
            
            var title1 = document.createElement("h1");
            var description1 = document.createElement("p");
            var city1 = document.createElement("p");
            var address1 = document.createElement("p");
            var date1 = document.createElement("p");
            
            
            description1.textContent = "Description: " + <?php echo json_encode($lastPost['description'] ?? ''); ?>;
            date1.textContent = "Date: " + <?php echo json_encode($lastPost['date'] ?? ''); ?>;
            address1.textContent = "Address: " + <?php echo json_encode($lastPost['address'] ?? ''); ?>;
            title1.textContent = <?php echo json_encode($lastPost['title'] ?? ''); ?>;
            city1.textContent = "City: " + <?php echo json_encode($lastPost['city'] ?? ''); ?>;

            div1.appendChild(title1);
            div1.appendChild(description1);
            div1.appendChild(date1);
            div1.appendChild(address1);
            div1.appendChild(city1);

            document.body.appendChild(div1);

        }
  </script>
</body>
</html>
