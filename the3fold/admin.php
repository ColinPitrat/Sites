<?php
  require("./include/ident.php");
  SqlConnect();

  if(isset($_GET["action"])) $action = $_GET["action"]; else $action = FALSE;
  if(isset($_GET["page"])) $page = $_GET["page"]; else $page = FALSE;
  if(isset($_POST["action"])) $action = $_POST["action"]; else $action = FALSE;

  if($_SESSION["level"] >= $const_leveladmin)
  {
    switch($action)
    {
    case 1:
        // Modifier le grade d'un membre
        if(is_numeric($_POST["grade"]))
        {
            $query = "UPDATE users SET level='".$_POST["grade"]."' WHERE nick='".$_POST["nick"]."'";
            SqlQuery($query);
        }
        break;
    case 2:
        // Modifier le mot de passe d'un membre
        $query = "UPDATE users SET password='".md5($_POST["pwd"])."' WHERE nick='".$_POST["nick"]."'";
        SqlQuery($query);
        break;
    case 3:
        // Supprimer un membre
        $query = "DELETE FROM users WHERE nick='".$_POST["nick"]."'";
        SqlQuery($query);
        break;
    case 4:
        // Créer une news
        $query = "INSERT INTO news(titre, auteur, texte, datedebut, datefin) VALUES ('".$_POST["titre"]."','".$_POST["auteur"]."','".$_POST["texte"]."','".$_POST["datedebut"]."','".$_POST["datefin"]."')";
        SqlQuery($query);
        break;
    case 5:
        // Supprimer une news
        $query = "DELETE FROM news WHERE id='".$_POST["id"]."'";
        SqlQuery($query);
        break;
    case 6:
        // Modifier une news
        $query = "UPDATE news SET titre='".$_POST["titre"]."', texte='".$_POST["texte"]."', auteur='".$_POST["auteur"]."', datedebut='".$_POST["datedebut"]."', datefin='".$_POST["datefin"]."' WHERE id='".$_POST["id"]."'";
        SqlQuery($query);
        break;
    }
?>
    <center><h1>Administration</h1>
    <font size="1"><a href="admin.php?page=1">Gestion des membres</a> | <a href="admin.php?page=2">Gestion des news</a> | <a href="logout.php">Se déconnecter</a></font> 
    <br /><br />
    <?php
    switch($page)
    {
    case 2:
      ?>
      <h2>Gestion des news</h2>
      <font size=\"1\"><a href="modif.php?action=4">Créer une news</a></font><br/><br/>
      <table border="1" cellspacing="0" width="95%">
        <tr><th>Titre</th><th>Texte</th><th>Debut</th><th>Fin</th><th>Actions</th></tr>
      <?php
      $query = "SELECT * FROM news ORDER by id DESC";
      $res = SqlQuery($query);
      $row = mysqli_fetch_object($res);
      while($row)
      {
        echo('<tr><td align="center">'.$row->titre.'</td><td align="center">'.substr($row->texte,0,255).'</td><td align="center" nowrap>'.$row->datedebut.'</td><td align="center" nowrap>'.$row->datefin.'</td><td align="center" nowrap> [ <a href="modif.php?action=6&id='.$row->id.'">Modifier</a> ]<br/> [ <a href="modif.php?action=5&id='.$row->id.'">Supprimer</a> ]</td>');
        $row = mysqli_fetch_object($res);
      }
      echo('</table><br/><font size=\"1\"><a href="modif.php?action=4">Créer une news</a></font>');
      break;
    default:
      ?>
      <h2>Gestion des membres</h2>
      <br />
      <table border="1" cellspacing="0" width="95%">
        <tr><th>Nom</th><th>Grade</th><th>Actions</th></tr>
      <?php
      $query="SELECT nick,skin,level FROM users ORDER BY level DESC";
      $res = SqlQuery($query);
      $row = mysqli_fetch_object($res);
      while($row)
      {
        echo('<tr><td align="center">');
        if($row->skin)
        {
          echo('<img src="'.$row->skin.'" width="50"><br />'.$row->nick);
        }
        else
        {
          echo($row->nick.'</td>');
        }
        echo('</td>');
        echo('<td align="center">'.$row->level.'<br/><font size=\"1\">'.$const_levelnames[$row->level-1].'</font></td>');
        echo('<td align="center">[<a href="modif.php?action=1&nick='.$row->nick.'">Modifier grade</a>] <br /> [<a href="modif.php?action=2&nick='.$row->nick.'">Changer mot de passe</a>] <br /> [<a href="modif.php?action=3&nick='.$row->nick.'">Supprimer</a>]</td></tr>');
        $row = mysqli_fetch_object($res);
      }  
      echo('</table>');
      break;
    }
    ?>
    </center>    
    <?php
  }  
  bottom();  
?>
    
