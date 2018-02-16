<?php
  require("./include/ident.php");

  if(isset($_GET["action"])) $action = $_GET["action"]; else $action = FALSE;
  if(isset($_GET["nick"])) $nick = $_GET["nick"]; else $nick = FALSE;
  if(isset($_GET["id"])) $id = $_GET["id"]; else $id = FALSE;

  if($_SESSION["level"] >= $const_leveladmin)
  {
    switch($action)
    {
    case 1:
      // Modifier le grade d'un membre
      echo("<center><h3>Modifier le grade de $nick</h3><br /><br />");
      ?>
      <form action="admin.php" method="post">
      <input type="hidden" value="1" name="action"/>
      Grade (1-10) : <input type="text" name="grade" maxlength="2"/><br /><br />
      <?php
      echo('<input type="hidden" value="'.$nick.'" name="nick"/>'); 
      ?>
      <input type="submit" value="Modifier"/>
      </form>
      <br /><br />
      <a href="admin.php">Retour</a>
      </center>
      <?php
      break;
    case 2:
      // Modifier le mot de passe d'un membre
      echo("<center><h3>Modifier le mot de passe de $nick</h3><br /><br />");
      ?>
      <form action="admin.php" method="post">
      <input type="hidden" value="2" name="action"/>
      Nouveau mot de passe : <input type="text" name="pwd"><br /><br />
      <?php
      echo('<input type="hidden" value="'.$nick.'" name="nick"/>');
      ?>
      <input type="submit" value="Modifier"/>
      </form>
      <br /><br />
      <a href="admin.php">Retour</a>
      </center>
      <?php
      break;
    case 3:
      // Supprimer un membre
      ?>
      <center><h3>Etes vous sur de vouloir supprimer ce membre ?</h3>
      <br /><br />
      <form action="admin.php" method="post">
      <input type="hidden" value="3" name="action"/>
      <?php
      echo('<input type="hidden" value="'.$nick.'" name="nick"/>');
      ?>
      <input type="submit" value="Supprimer"/>
      </form>
      <br /><br />
      <a href="admin.php">Retour</a>
      </center>
      <?php
      break;
    case 4:
      // Créer news
      ?>
      <center><h3>Créer une nouvelle news</h3>
      <br/><br/>
      <form action="admin.php?page=2" method="post">
      <input type="hidden" value="4" name="action"/>
      <?php
      echo('<input type="hidden" value="'.$_SESSION["login"].'" name="auteur"/>');
      ?>
      <table width="100%" border="0">
        <tr>
          <td style="text-align: right" width="50%">Titre : </td>
          <td width="50%"><input type="text" name="titre" maxlength="200"/></td>
        </tr>
        <tr>
          <td style="text-align: right" width="50%">Texte : </td>
          <td width="50%"><textarea name="texte" cols="30" rows="5"></textarea></td>
        </tr>
        <tr>
          <td style="text-align: right" width="50%">Date de début (YYYY-MM-JJ) : </td>
          <td width="50%"><input type="text" name="datedebut" maxlength="10"/></td>
        </tr>
        <tr>
          <td style="text-align: right" width="50%">Date de fin (YYYY-MM-JJ) : </td>
          <td width="50%"><input type="text" name="datefin" maxlength="10"/></td>
        </tr>
      </table>
      <input type="submit" value="Créer"/>
      </form>
      <br/><br/>
      <a href="admin.php?page=2">Retour</a>
      </center>
      <?php
      break;
    case 5:
      // Supprimer news
      ?>
      <center><h3>Etes vous sur de vouloir supprimer cette news ?</h3>
      <br/><br/>
      <form action="admin.php?page=2" method="post">
        <input type="hidden" value="5" name="action"/>
        <?php
        echo('<input type="hidden" value="'.$id.'" name="id"/>');
        ?>
        <input type="submit" value="Supprimer"/>
      </form>
      <br/><br/>
      <a href="admin.php?page=2">Retour</a>
      </center>
      <?php
      break;
    case 6:
      // Modifier news
      SqlConnect();
      $query = "SELECT * FROM news WHERE id=$id";
      $res = SqlQuery($query);
      $row = mysql_fetch_object($res);
      ?>
      <center><h3>Modifier une news</h3>
      <br/><br/>
      <form action="admin.php?page=2" method="post">
      <input type="hidden" value="6" name="action"/>
      <?php
      echo('<input type="hidden" value="'.$row->auteur);
      if(!strstr($row->auteur, $_SESSION["login"]))
      {
        echo(" & ".$_SESSION["login"]);
      }
      echo('" name="auteur"/>');
      echo('<input type="hidden" value="'.$row->id.'" name="id"/>');
      ?>
      <table width="100%" border="0">
        <tr>
          <td style="text-align: right" width="50%">Titre : </td>
          <td width="50%"><input type="text" value="<?php echo($row->titre);?>" name="titre" maxlength="200"/></td>
        </tr>
        <tr>
          <td style="text-align: right" width="50%">Texte : </td>
          <td width="50%"><textarea name="texte" cols="30" rows="5"><?php echo($row->texte)?></textarea></td>
        </tr>
        <tr>
          <td style="text-align: right" width="50%">Date de début (YYYY-MM-JJ) : </td>
          <td width="50%"><input type="text" value="<?php echo($row->datedebut);?>" name="datedebut" maxlength="10"/></td>
        </tr>
        <tr>
          <td style="text-align: right" width="50%">Date de fin (YYYY-MM-JJ) : </td>
          <td width="50%"><input type="text" value="<?php echo($row->datefin);?>" name="datefin" maxlength="10"/></td>
        </tr>
      </table>
      <input type="submit" value="Modifier"/>
      </form>
      <br/><br/>
      <a href="admin.php?page=2">Retour</a>
      </center>
      <?php
      break;
    }
  }
  
  bottom();
?>
