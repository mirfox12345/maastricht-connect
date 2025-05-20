<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirect to login if not logged in
    header("Location: login.html");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maastricht Connect</title>
    <link rel="icon" type="image/png" href="Pictures/Maastricht-Connect-Logo.png">
</head>
<body>
    <div class="profile-picture"></div>
</body>
</html>