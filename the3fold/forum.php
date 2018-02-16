<?php
  require("./include/ident.php");
  SqlConnect();

  if(isset($_GET["salon"])) $salon = $_GET["salon"]; else $salon = FALSE;
  if(isset($_GET["thread"])) $thread = $_GET["thread"]; else $thread = FALSE;
  if(isset($_GET["msg"])) $msg = $_GET["msg"]; else $msg = FALSE;
  if(isset($_POST["action"])) $action = $_POST["action"]; else $action = FALSE;
  if(isset($_SESSION["level"])) $level = $_SESSION["level"]; else $level = 0;

  echo("<h1>Forum</h1>");

  $date=getdate();
  $date=$date["mday"]."/".$date["mon"]."/".$date["year"]."<br />".$date["hours"].":".$date["minutes"];
  switch($action)
  {
  case 1:
    // Créer salon
    if($level < $const_levelforumadmin)
    {
      echo("<b>Vous n'avez pas le statut nécessaire pour afficher cette page</b>");
      break;
    }

    // On telecharge d'abord l'image
    if(isset($HTTP_POST_FILES['userfile']) && $HTTP_POST_FILES['userfile']['error'] != 4)
    {
      if($HTTP_POST_FILES['userfile']['size'] < 1)
      {
        echo("Probleme durant la transmission, veuillez reessayer.");
        exit;
      }
      if($HTTP_POST_FILES['userfile']['size'] > 51200)
      {
        echo("Le fichier est trop gros. Taille maximale : 50 Ko");
        exit;
      }
      switch($HTTP_POST_FILES['userfile']['type'])
      {
      case "image/jpeg":
      case "image/gif":
      case "image/png":
        $newname=$HTTP_POST_FILES['userfile']['name'];
        break;
      default:
        echo("Seuls les formats JPEG,GIF et PNG sont accept&eacute;s.");
        exit;
      }
      if(file_exists("./images/".$newname))
      {
        echo("Le nom de fichier spécifié est déja utilisé.");
        exit;
      }
      $img="./images/".$newname;
      if(!move_uploaded_file($userfile, $img))
      {
        echo("Probleme rencontré lors du telechargement. Veuillez réessayer.");
        exit;
      }
      chmod($img, 0644);
    }
    else
    {
      $img=$_POST["img"];
    }

    $titre=htmlentities($_POST["titre"]);
    $lvl=$_POST["lvl"];
    if(is_numeric($lvl) && ($lvl <= $const_levelmax) && ($lvl >= 1))
    {
      $query="INSERT INTO forumsalons (nom,img,date,lvl) VALUES ('".$titre."','".$img."','".$date."','".$lvl."')";
      SqlQuery($query);
      mail("colin.pitrat@gmail.com", "Salon '$titre' créé sur the3fold", "Le salon '$titre' a été créé sur the3fold. Il est visible depuis http://the3fold.free.fr/forum.php.");
    }
    else      
    {
      echo("Le niveau doit etre un chiffre entre 1 et $const_levelmax");
      bottom();
      exit();
    }
    break;
  case 2:
    // Créer thread
    $msg=parseMsgToSave($_POST["msg"]);
    $titre=htmlentities($_POST["titre"]);
    $salon=$_POST["salon"];
    $query="INSERT INTO forumthreads (nom,auteur,date,salon) VALUES ('".$titre."','".$_SESSION["login"]."','".$date."','".$salon."')";
    SqlQuery($query);
    mail("colin.pitrat@gmail.com", "Thread '$titre' créé sur the3fold", "Le thread '$titre' a été créé sur the3fold. Il est visible depuis http://the3fold.free.fr/forum.php?salon=$salon. Contenu: $msg");

    $query="SELECT id FROM forumthreads WHERE nom='".$titre."'";
    $res=SqlQuery($query);
    $row=mysql_fetch_object($res);
    $thread=$row->id;

    $query="INSERT INTO forummessages (auteur,message,thread) VALUES ('".$_SESSION["login"]."','".$msg."','".$thread."')";
    SqlQuery($query);

    $query="UPDATE forumsalons SET date='".$date."' WHERE id=".$salon;
    SqlQuery($query);
    break;
  case 3:
    // Créer message
    $msg=parseMsgToSave($_POST["msg"]);      
    $thread=$_POST["thread"];
    $salon=$_POST["salon"];
    $query="INSERT INTO forummessages (auteur,message,thread) VALUES ('".$_SESSION["login"]."','".$msg."','".$thread."')";
    SqlQuery($query);
    mail("colin.pitrat@gmail.com", "Message posté sur the3fold", "Un message a été posté sur the3fold. Il est visible depuis http://the3fold.free.fr/forum.php?salon=$thread. Contenu: $msg");
    $query="UPDATE forumthreads SET date='".$date."' WHERE id=".$thread;
    SqlQuery($query);
    $query="UPDATE forumsalons SET date='".$date."' WHERE id=".$salon;
    SqlQuery($query);
    break;
  case 4:
    // Modifier un salon
    if($level < $const_levelforumadmin)
    {
      echo("<b>Vous n'avez pas le statut nécessaire pour afficher cette page</b>");
      break;
    }

    echo("sizeof :".sizeof($HTTP_POST_FILES));
    // On telecharge d'abord l'image
    if(isset($HTTP_POST_FILES['userfile']) && $HTTP_POST_FILES['userfile']['error'] != 4)
    {
      if($HTTP_POST_FILES['userfile']['size'] < 1)
      {
        echo("Probleme durant la transmission, veuillez reessayer.");
        exit;
      }
      if($HTTP_POST_FILES['userfile']['size'] > 51200)
      {
        echo("Le fichier est trop gros. Taille maximale : 50 Ko");
        exit;
      }
      switch($HTTP_POST_FILES['userfile']['type'])
      {
      case "image/jpeg":
      case "image/gif":
      case "image/png":
        $newname=$HTTP_POST_FILES['userfile']['name'];
        break;
      default:
        echo("Seuls les formats JPEG,GIF et PNG sont accept&eacute;s.");
        exit;
      }
      if(file_exists("./images/".$newname))
      {
        echo("Le nom de fichier spécifié est déja utilisé.");
        exit;
      }
      $img="./images/".$newname;
      if(!move_uploaded_file($userfile, $img))
      {
        echo("Probleme rencontré lors du telechargement. Veuillez réessayer.");
        exit;
      }
      chmod($img, 0644);
    }
    else
    {
      $img=$_POST["img"];
    }

    $titre=htmlentities($_POST["titre"]);
    $lvl=$_POST["lvl"];
    if(is_numeric($lvl) && ($lvl <= $const_levelmax) && ($lvl >= 1))
    {
      $query="UPDATE forumsalons SET nom='$titre',img='$img',lvl=$lvl WHERE id=$salon";
      SqlQuery($query);
      unset($salon);
    }
    else      
    {
      echo("Le niveau doit etre un chiffre entre 1 et ".$const_levelmax);
      bottom();
      exit();
    }
    break;
  case 5:
    // Modifier un message
    $idmsg = $_POST["idmsg"];
    $msg = parseMsgToSave($_POST["msg"]);
    $query = "SELECT auteur,thread FROM forummessages WHERE id=\"$idmsg\"";
    $res = SqlQuery($query);
    $row = mysql_fetch_object($res);
    $thread = $row->thread;
    if($_SESSION["login"] != $row->auteur)
    {
      echo("<b>Vous n'avez pas le statut nécessaire pour afficher cette page</b>");
      break;
    }
    $query = "UPDATE forummessages SET message='".$msg."' WHERE id=$idmsg";
    SqlQuery($query);
    $query = "SELECT salon FROM forumthreads WHERE id=\"$thread\"";
    $res = SqlQuery($query);
    $row = mysql_fetch_object($res);
    $salon = $row->salon;
    break;
  case 6:
    // Supprimer un salon
    if($level < $const_levelforumadmin)
    {
      echo("<b>Vous n'avez pas le statut nécessaire pour afficher cette page</b>");
      break;
    }
    $query = "DELETE FROM forumsalons WHERE id=\"".$_POST["salon"]."\"";
    SqlQuery($query);
    unset($salon);
    break;
  case 7:
    // Supprimer une discussion
    if($level < $const_levelforumadmin)
    {
      echo("<b>Vous n'avez pas le statut nécessaire pour afficher cette page</b>");
      break;
    }
    SqlConnect();
    $query = "SELECT salon FROM forumthreads WHERE id=\"".$_POST["thread"]."\"";
    $res = SqlQuery($query);
    $row = mysql_fetch_object($res);
    $salon = $row->salon;
    $query = "DELETE FROM forumthreads WHERE id=\"".$_POST["thread"]."\"";
    SqlQuery($query);
    unset($thread);
    break;
  case 8:
    // Supprimer un message
    $query = "SELECT auteur,thread FROM forummessages WHERE id=\"".$_POST["idmsg"]."\"";
    $res = SqlQuery($query);
    $row = mysql_fetch_object($res);
    $thread = $row->thread;
    if(($level < $const_levelforumadmin) && ($_SESSION["login"] != $row->auteur))
    {
      echo("<b>Vous n'avez pas le statut nécessaire pour afficher cette page</b>");
      break;
    }
    $query = "DELETE FROM forummessages WHERE id=\"".$_POST["idmsg"]."\"";
    SqlQuery($query);
    $query = "SELECT salon FROM forumthreads WHERE id=\"$thread\"";
    $res = SqlQuery($query);
    $row = mysql_fetch_object($res);
    $salon = $row->salon;
    break;
  case 9:
    // Epingler une discussion
    if($level < $const_levelforumadmin)
    {
      echo("<b>Vous n'avez pas le statut nécessaire pour afficher cette page</b>");
      break;
    }
    SqlConnect();
    $query = "UPDATE forumthreads SET epingle=1 WHERE id=\"".$_POST["thread"]."\"";
    SqlQuery($query);
    $query = "SELECT salon FROM forumthreads WHERE id=\"".$_POST["thread"]."\"";
    $res = SqlQuery($query);
    $row = mysql_fetch_object($res);
    $salon = $row->salon;
    unset($thread);
    break;
  case 10:
    // Desepingler une discussion
    if($level < $const_levelforumadmin)
    {
      echo("<b>Vous n'avez pas le statut nécessaire pour afficher cette page</b>");
      break;
    }
    SqlConnect();
    $query = "UPDATE forumthreads SET epingle=0 WHERE id=\"".$_POST["thread"]."\"";
    SqlQuery($query);
    $query = "SELECT salon FROM forumthreads WHERE id=\"".$_POST["thread"]."\"";
    $res = SqlQuery($query);
    $row = mysql_fetch_object($res);
    $salon = $row->salon;
    unset($thread);
    break;
  }

  if($salon)
  {
    if($thread)
    {
      // Afficher messages
      echo("<p class=\"quickmenu\"><a href=\"post.php?action=3&salon=$salon&thread=$thread\">Nouveau message</a> | <a href=\"profil.php\">Modifier son profil</a> | <a href=\"forum.php?salon=$salon\">Retour aux discussions</a> | <a href=\"forum.php\">Retour aux salons</a> | <a href=\"forumhelp.php\">Aide</a> | <a href=\"logout.php\">Se déconnecter</a></p>\n");
      
      $query = "SELECT lvl FROM forumsalons WHERE id='".$salon."'";
      $res = SqlQuery($query);
      $row = mysql_fetch_object($res);

      if($row->lvl <= $level)
      {
        $query = "SELECT * FROM forummessages WHERE thread='".$thread."' ORDER BY id";
        $res = SqlQuery($query);
        $row = mysql_fetch_object($res);
      
        while($row)
        {
          $query = "SELECT * FROM users WHERE nick='".$row->auteur."'";
          $res2 = SqlQuery($query);
          $row2 = mysql_fetch_object($res2);
          echo("<br/><table class=\"forumliste\"><tr><td class=\"auteur\">");
          if($row2->skin)
          {
            echo("<img width=\"110\" src=\"".$row2->skin."\" alt=\"".$row->auteur."\"/><br />");
          }
          echo("<strong>".$row->auteur."</strong><span class=\"grade\"><br/>".$const_levelnames[($row2->level-1)]."</td><td>".parseMsgToShow($row->message));
          if($_SESSION["login"] == $row->auteur)
          {
            echo("<br /><br />[ <a href=\"post.php?action=5&idmsg=".$row->id."\">Modifier</a> ] [ <a href=\"post.php?action=8&idmsg=".$row->id."\">Supprimer</a> ]");
          }
          elseif($level >= $const_levelforumadmin)
          {
            echo("<br /><br />[ <a href=\"post.php?action=8&idmsg=".$row->id."\">Supprimer</a> ]");
          }
          echo("</td></tr></table>");
          $row = mysql_fetch_object($res);
        }
      }
      
      echo("<br/><p class=\"quickmenu\"><a href=\"post.php?action=3&salon=$salon&thread=$thread\">Nouveau message</a> | <a href=\"profil.php\">Modifier son profil</a> | <a href=\"forum.php?salon=$salon\">Retour aux discussions</a> | <a href=\"forum.php\">Retour aux salons</a> | <a href=\"forumhelp.php\">Aide</a> | <a href=\"logout.php\">Se déconnecter</a></p>\n");
    }
    else
    {
      // Afficher threads
      echo("<p class=\"quickmenu\"><a href=\"post.php?action=2&salon=$salon\">Nouvelle discussion</a> | <a href=\"profil.php\">Modifier son profil</a> | <a href=\"forum.php\">Retour aux salons</a> | <a href=\"forumhelp.php\">Aide</a> | <a href=\"logout.php\">Se déconnecter</a></p>\n");
      
      $query = "SELECT lvl FROM forumsalons WHERE id='".$salon."'";
      $res = SqlQuery($query);
      $row = mysql_fetch_object($res);

      echo("<br/><table class=\"forumliste\"><tr><th width=\"85%\" align=\"center\"");
      if($level >= $const_levelforumadmin)
      {
        echo(" colspan=\"2\"");
      }
      echo(">Discussion</th><th>Dernier message</th></tr>");    

      if($row->lvl <= $level)
      {
        $query = "SELECT * FROM forumthreads WHERE salon='".$salon."' ORDER BY id";
        $res = SqlQuery($query);
        $row = mysql_fetch_object($res);
      
        while($row)
        {
          echo("<tr><td class=\"link\"><a href=\"forum.php?salon=$salon&thread=".$row->id."\">".$row->nom."</a></td>");
          if($level >= $const_levelforumadmin)
          {
            if($row->epingle)
            {
              echo("<td class=\"action\">[<a href=\"post.php?action=10&thread=".$row->id."\">Desepingler</a>] [<a href=\"post.php?action=7&thread=".$row->id."\">Supprimer</a>]</td>");
            }
            else
            {
              echo("<td class=\"action\">[<a href=\"post.php?action=9&thread=".$row->id."\">Epingler</a>] [<a href=\"post.php?action=7&thread=".$row->id."\">Supprimer</a>]</td>");
            }
          }
          echo("<td class=\"date\">".$row->date."</td></tr>");
          $row = mysql_fetch_object($res);
        }
      }
      
      echo("</table>");
    }
  }
  else
  {
    // Afficher salons
    echo("<p class=\"quickmenu\">");
    if($level >= $const_levelforumadmin)
    {
      echo("<a href=\"post.php?action=1\">Nouveau Salon</a> | ");
    }
    echo("<a href=\"profil.php\">Modifier son profil</a> | <a href=\"forumhelp.php\">Aide</a> | <a href=\"logout.php\">Se déconnecter</a></p>\n");
    
    $query = "SELECT * FROM forumsalons WHERE lvl<='".$level."' ORDER BY lvl ASC";
    $res = SqlQuery($query);
    $row = mysql_fetch_object($res);

    echo("<br/><table class=\"forumliste\" cellpadding=\"2\"><tr><th width=\"85%\" align=\"center\"");
    if($level >= $const_levelforumadmin)
    {
      echo(" colspan=\"2\"");    
    }
    echo(">Salon</th><th>Dernier message</th></tr>");
      
    while($row)
    {
      echo("<tr><td class=\"link\"><img src=\"".$row->img."\" width=\"60\" align=\"middle\" alt=\"".$row->img."\"/>");
      echo("<b><font size=\"4\" style=\"font-family: utopia;\">&nbsp;<a href=\"forum.php?salon=".$row->id."\">".$row->nom."</a></font></b></td>");
      if($level >= $const_levelforumadmin)
      {
        echo("<td class=\"action\"> [ <a href=\"post.php?action=4&salon=".$row->id."\">Modifier</a> ] [ <a href=\"post.php?action=6&salon=".$row->id."\">Supprimer</a> ]</td>");
      }
      echo("<td class=\"date\">".$row->date."</td></tr>");
      $row = mysql_fetch_object($res);
    }
    
    echo("</table>");
  }
  
  bottom();
?>
