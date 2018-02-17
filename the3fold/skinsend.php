<?php
  require("./include/ident.php");

  $login = $_SESSION["login"];

  $succes=0;
  if(sizeof($HTTP_POST_FILES))
  {
    if($HTTP_POST_FILES['userfile']['size'] < 1)
    {
      echo("Probleme durant la transmission, veuillez reessayer.");
      exit;
    }
    if($HTTP_POST_FILES['userfile']['size'] > 102400)
    {
      echo("Le fichier est trop gros. Taille maximale : 100 Ko");
      exit;
    }
    switch($HTTP_POST_FILES['userfile']['type'])
    {
    case "image/jpeg":
      $newname=$login.".jpg";
      break;
    case "image/gif":
      $newname=$login.".gif";
      break;
    case "image/png":
      $newname=$login.".png";
      break;
    default:
      echo("Seuls les formats JPEG,GIF et PNG sont accept&eacute;s.");
      exit;	  
    }
    $dest="./skins/".$newname;
    if(!move_uploaded_file($userfile, $dest)) 
    {
      echo("Problem rencontré lors du telechargement. Veuillez réessayer."); 
      exit; 
    }
    chmod($dest, 0644);
    SqlConnect();
    $query="UPDATE users SET skin='".$dest."' WHERE nick='".$login."'";
    SqlQuery($query);
    $succes=1;
  }
  if($succes)
  {
  ?>
    <h3 class="centre">Votre skin a été modifié.</h3>
    <br /><br />
    <p class="centre"><a href="profil.php">Retour au profil</a></p>
  <?php
  }
  else
  {
  ?>
    <h2 class="centre">Envoi de skin</h2>
    <br /><br />
    <center>
    <form method="post" name="formulaire" action="skinsend.php" enctype="multipart/form-data">
      <input type="file" name="userfile" size="40" maxlength="400"/><br /><br />
      <input type="submit" value="Envoyer"/>
    </form>
    </center>
    <br /><br />
    <p class="centre"><a href="profil.php">Retour au profil</a></p>
  <?php
  }
  
  bottom();
?>
