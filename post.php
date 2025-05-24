<?php
session_start();
require 'config.php';

if (!isset($_SESSION['username'])) {
  header('Location: login.html');
  exit;
}

$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$stmt->bind_result($userId);
$stmt->fetch();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // 1) Validate your text fields here…

  // 2) Handle the image upload:
  $imagePath = null;
  if (
    isset($_FILES['image']) &&
    $_FILES['image']['error'] === UPLOAD_ERR_OK
  ) {
      $uploadsDir = __DIR__ . '/uploads/';
      if (!is_dir($uploadsDir)) {
          mkdir($uploadsDir, 0755, true);
      }

      // Create a unique filename
      $filename = time() . '-' . basename($_FILES['image']['name']);
      $target   = $uploadsDir . $filename;

      if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
          // Save _relative_ path in DB
          $imagePath = 'uploads/' . $filename;
      }
  }

  // 3) Insert into posts table (now including image column)
  $stmt = $conn->prepare("
    INSERT INTO posts
      (user_id, title, description, city, address, date, image)
    VALUES (?, ?, ?, ?, ?, ?, ?)
  ");
  $stmt->bind_param(
    'issssss',
    $userId,
    $_POST['title'],
    $_POST['description'],
    $_POST['city'],
    $_POST['address'],
    $_POST['date'],
    $imagePath   // will be NULL if no upload succeeded
  );
  $stmt->execute();
  $stmt->close();

  header('Location: social-media.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maastricht Connect</title>
    <link rel="icon" type="image/png" href="Pictures/Maastricht-Connect-Logo.png">
    <link rel="stylesheet" href="post-style.css">
</head>
<body>
<div class="nav-bar">
        <ul>
            <a class="home" href="home.php">Home</a>
            <a class="discover" href="social-media.php">Discover</a>
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

    <div class="form-wrap">
    <form action="post.php" class="form" method="POST" id="form" enctype="multipart/form-data">
        <label for="title" class="title-label">Title:</label>
        <input type="text" class="title" name="title" required>
        <label for="description" class="description-label">description:</label>
        <textarea type="text" class="description" name="description" required></textarea>
        <label for="city" class="city-label">Choose your city:</label>
        <select id="city" class="city" name="city" required>
            <option value="Tilburg">Tilburg</option>
            <option value="Amsterdam">Amsterdam</option>
            <option value="Rotterdam">Rotterdam</option>
            <option value="The Hague">The Hague</option>
<option value="Utrecht">Utrecht</option>
<option value="Maastricht">Maastricht</option>
<option value="Eindhoven">Eindhoven</option>
<option value="Groningen">Groningen</option>
<option value="Almere">Almere</option>
<option value="Breda">Breda</option>
<option value="Nijmegen">Nijmegen</option>
<option value="Arnhem">Arnhem</option>
<option value="Haarlem">Haarlem</option>
<option value="Enschede">Enschede</option>
<option value="’s-Hertogenbosch">’s-Hertogenbosch</option>
<option value="Amersfoort">Amersfoort</option>
<option value="Zaanstad">Zaanstad</option>
<option value="Apeldoorn">Apeldoorn</option>
<option value="Zwolle">Zwolle</option>
<option value="Zoetermeer">Zoetermeer</option>
<option value="Leeuwarden">Leeuwarden</option>
<option value="Leiden">Leiden</option>
<option value="Dordrecht">Dordrecht</option>
<option value="Alphen aan den Rijn">Alphen aan den Rijn</option>
<option value="Alkmaar">Alkmaar</option>
<option value="Delft">Delft</option>
<option value="Emmen">Emmen</option>
<option value="Deventer">Deventer</option>
<option value="Helmond">Helmond</option>
<option value="Hilversum">Hilversum</option>
<option value="Heerlen">Heerlen</option>
<option value="Lelystad">Lelystad</option>
<option value="Purmerend">Purmerend</option>
<option value="Hengelo">Hengelo</option>
<option value="Schiedam">Schiedam</option>
<option value="Zaandam">Zaandam</option>
<option value="Hoofddorp">Hoofddorp</option>
<option value="Vlaardingen">Vlaardingen</option>
<option value="Gouda">Gouda</option>
<option value="Hoorn">Hoorn</option>
<option value="Almelo">Almelo</option>
<option value="Spijkenisse">Spijkenisse</option>
<option value="Amstelveen">Amstelveen</option>
<option value="Assen">Assen</option>
<option value="Velsen-Zuid">Velsen-Zuid</option>
<option value="Capelle aan den IJssel">Capelle aan den IJssel</option>
<option value="Veenendaal">Veenendaal</option>
<option value="Katwijk">Katwijk</option>
<option value="Zeist">Zeist</option>
<option value="Nieuwegein">Nieuwegein</option>
<option value="Scheveningen">Scheveningen</option>
<option value="Heerhugowaard">Heerhugowaard</option>
<option value="Roermond">Roermond</option>
<option value="Oosterhout">Oosterhout</option>
<option value="Rijswijk">Rijswijk</option>
<option value="Houten">Houten</option>
<option value="Middelburg">Middelburg</option>
<option value="Harderwijk">Harderwijk</option>
<option value="Barendrecht">Barendrecht</option>
<option value="IJmuiden">IJmuiden</option>
<option value="Zutphen">Zutphen</option>
<option value="Soest">Soest</option>
<option value="Ridderkerk">Ridderkerk</option>
<option value="Schagen">Schagen</option>
<option value="Veldhoven">Veldhoven</option>
<option value="Kerkrade">Kerkrade</option>
<option value="Zwijndrecht">Zwijndrecht</option>
<option value="Zevenaar">Zevenaar</option>
<option value="Noordwijk">Noordwijk</option>
<option value="Etten-Leur">Etten-Leur</option>
<option value="Tiel">Tiel</option>
<option value="Beverwijk">Beverwijk</option>
<option value="Huizen">Huizen</option>
<option value="Hellevoetsluis">Hellevoetsluis</option>
<option value="Maarssen">Maarssen</option>
<option value="Wageningen">Wageningen</option>
<option value="Heemskerk">Heemskerk</option>
<option value="Veghel">Veghel</option>
<option value="Teijlingen">Teijlingen</option>
<option value="Venlo">Venlo</option>
<option value="Gorinchem">Gorinchem</option>
<option value="Landgraaf">Landgraaf</option>
<option value="Sittard">Sittard</option>
<option value="Hoogvliet">Hoogvliet</option>
<option value="Maassluis">Maassluis</option>
<option value="Bussum">Bussum</option>
<option value="Papendrecht">Papendrecht</option>
<option value="Aalsmeer">Aalsmeer</option>
<option value="Oldenzaal">Oldenzaal</option>
<option value="Vught">Vught</option>
<option value="Nieuw-Vennep">Nieuw-Vennep</option>
<option value="Waddinxveen">Waddinxveen</option>
<option value="Diemen">Diemen</option>
<option value="Hendrik-Ido-Ambacht">Hendrik-Ido-Ambacht</option>
<option value="Rosmalen">Rosmalen</option>
<option value="Best">Best</option>
<option value="Uithoorn">Uithoorn</option>
<option value="Krimpen aan den IJssel">Krimpen aan den IJssel</option>
<option value="Culemborg">Culemborg</option>
<option value="Geldrop">Geldrop</option>
<option value="Langedijk">Langedijk</option>
<option value="Vleuten">Vleuten</option>
<option value="Brunssum">Brunssum</option>
<option value="Heemstede">Heemstede</option>
<option value="Leiderdorp">Leiderdorp</option>
<option value="Blerick">Blerick</option>
<option value="Pijnacker">Pijnacker</option>
<option value="Dongen">Dongen</option>
<option value="Voorschoten">Voorschoten</option>
<option value="Sliedrecht">Sliedrecht</option>
<option value="Oegstgeest">Oegstgeest</option>
<option value="Stein">Stein</option>
<option value="Oud-Beijerland">Oud-Beijerland</option>
<option value="Heiloo">Heiloo</option>
<option value="Borne">Borne</option>
<option value="Lisse">Lisse</option>
<option value="Volendam">Volendam</option>
<option value="Hillegom">Hillegom</option>
<option value="’s-Gravenzande">’s-Gravenzande</option>
<option value="De Meern">De Meern</option>
<option value="Nuenen">Nuenen</option>
<option value="Alblasserdam">Alblasserdam</option>
<option value="Weesp">Weesp</option>
<option value="Nootdorp">Nootdorp</option>
<option value="Krommenie">Krommenie</option>
<option value="Naaldwijk">Naaldwijk</option>
<option value="Edam">Edam</option>
<option value="Enkhuizen">Enkhuizen</option>
<option value="Hardinxveld-Giessendam">Hardinxveld-Giessendam</option>
<option value="Waalre">Waalre</option>
<option value="Rijen">Rijen</option>
<option value="Glanerbrug">Glanerbrug</option>
<option value="Schaesberg">Schaesberg</option>
<option value="Beek">Beek</option>
<option value="Boskoop">Boskoop</option>
<option value="Westervoort">Westervoort</option>
<option value="Sassenheim">Sassenheim</option>
<option value="Julianadorp">Julianadorp</option>
<option value="Badhoevedorp">Badhoevedorp</option>
<option value="Raamsdonksveer">Raamsdonksveer</option>
<option value="Rozenburg">Rozenburg</option>
<option value="Blaricum">Blaricum</option>
<option value="Schoonhoven">Schoonhoven</option>
<option value="Laren">Laren</option>
<option value="Koog aan de Zaan">Koog aan de Zaan</option>
<option value="Doesburg">Doesburg</option>
<option value="Hoogland">Hoogland</option>
<option value="Leidschendam">Leidschendam</option>
<option value="Heerlerbaan">Heerlerbaan</option>
<option value="Nieuw-Lekkerland">Nieuw-Lekkerland</option>
<option value="Kudelstaart">Kudelstaart</option>
<option value="Zaandijk">Zaandijk</option>
<option value="Den Hoorn">Den Hoorn</option>
<option value="Zwanenburg">Zwanenburg</option>
<option value="Limmen">Limmen</option>
<option value="Honselersdijk">Honselersdijk</option>
<option value="Bolnes">Bolnes</option>
<option value="Santpoort-Noord">Santpoort-Noord</option>
<option value="Soesterberg">Soesterberg</option>
<option value="Elsloo">Elsloo</option>
<option value="Valkenburg">Valkenburg</option>
<option value="Reuver">Reuver</option>
<option value="Surhuisterveen">Surhuisterveen</option>
<option value="Susteren">Susteren</option>
<option value="Hintham">Hintham</option>
<option value="Belfeld">Belfeld</option>
<option value="Meteren">Meteren</option>
<option value="Westerblokker">Westerblokker</option>
<option value="Duivendrecht">Duivendrecht</option>
<option value="Empel">Empel</option>
<option value="Arnemuiden">Arnemuiden</option>
<option value="Hooglanderveen">Hooglanderveen</option>
<option value="Pernis">Pernis</option>
<option value="Soestdijk">Soestdijk</option>
<option value="Aerdenhout">Aerdenhout</option>
<option value="Munstergeleen">Munstergeleen</option>
<option value="Den Dolder">Den Dolder</option>
<option value="Rijsenhout">Rijsenhout</option>
<option value="Overveen">Overveen</option>
<option value="Molenhoek">Molenhoek</option>
<option value="De Kwakel">De Kwakel</option>
<option value="Kwintsheul">Kwintsheul</option>
<option value="Heelsum">Heelsum</option>
<option value="Nijkerkerveen">Nijkerkerveen</option>
<option value="Santpoort-Zuid">Santpoort-Zuid</option>
<option value="Goutum">Goutum</option>
<option value="Nieuwstadt">Nieuwstadt</option>
<option value="Zwaag">Zwaag</option>
<option value="Berg">Berg</option>
<option value="Bovenkerk">Bovenkerk</option>
<option value="Oerle">Oerle</option>
<option value="Elden">Elden</option>
<option value="Giesbeek">Giesbeek</option>
<option value="Boekelo">Boekelo</option>
<option value="Vlijmen">Vlijmen</option>
<option value="Bemmel">Bemmel</option>
<option value="Kralingse Veer">Kralingse Veer</option>
<option value="Born">Born</option>
<option value="Neerbeek">Neerbeek</option>
<option value="Mijdrecht">Mijdrecht</option>
<option value="Hoogkarspel">Hoogkarspel</option>
<option value="Bovenkarspel">Bovenkarspel</option>
<option value="Zuid-Scharwoude">Zuid-Scharwoude</option>
<option value="Poortugaal">Poortugaal</option>
<option value="Odijk">Odijk</option>

        </select>
        <label for="Address" class="address-label">Address:</label>
        <input type="text" class="address" name="address" required>
        <label for="date" class="date-label">Date:  </label>
        <input type="date" class="date" name="date" required>

      <div class="image-div">
        <label for="image-div" class="event-image-label">Event's Image: </label>
        <div class="image-div">
          <label for="input-file" id="drop-area">
            <input type="file" accept="image/*" id="input-file" name="image" hidden>
            <div class="img-view" id="img-view">
                <img src="Pictures/508-icon.png" class="upload-icon">
                <p>Drag and drop or click here<br>to upload image</p>
                <span>Upload any image from desktop</span>
          </div>
          </label>
        </div>
        </div>
        <script src="upload-img.js"></script>
        
        <input type="submit" value="Submit" class="submit">

    </form>
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


</body>
</html>



