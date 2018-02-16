<?php
  require("./include/ident.php");
?>
  <h1>Bienvenue dans l'espace membres</h1>
  <p class="quickmenu"><a href="profil.php">Modifier son profil</a> | <a href="logout.php">Se déconnecter</a></p>
  <br /><br />
  <br />
  Vous pouvez acceder aux sections suivantes :
  <br />
  <br />
  <h2 class="centre"><a href="forum.php">Forum</a></h2>
  <?php
  if(isset($_SESSION["level"]) && $_SESSION["level"] >= $const_leveladmin)
  {
    echo('<h2 class="centre"><a href="admin.php">Administration</a></h2>');
  }
  ?>
<?php
  bottom();
?>
