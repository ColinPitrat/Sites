<?php
  require("./include/ident.php");

  SqlConnect();
  
  if(isset($_POST["modif"])) $modif = $_POST["modif"]; else $modif = FALSE;

  if($modif)
  {
    $query = 'UPDATE users SET skin="'.$_POST["skin"].'" WHERE nick="'.$_SESSION["login"].'"';
    SqlQuery($query);
    if($_POST["pwd"])
    {
      if(md5($_POST["pwd"])==$row[1])
      {
        if($_POST["newpwd"]==$_POST["newpwd2"])
        {
          $query = 'UPDATE users SET password="'.md5($_POST["newpwd"]).'" WHERE nick="'.$row[0].'"';
          SqlQuery($query);
          echo("Le mot de passe a &eacute;t&eacute; modifi&eacute;.<br />");
        }
        else
        {
          echo("<font color=\"#FF0000\">Les deux nouveaux mots de passe ne concordent pas</font><br />");
        }
      }
      else
      {
        echo("<font color=\"#FFOOOO\">Le mot de passe rentr&eacute; n'est pas correct</font><br />");
      }
    }
  }

  echo("<h2 class=\"centre\">Bienvenue ".$_SESSION["login"]."</h2>");

  $query = 'SELECT * FROM users WHERE nick="'.$_SESSION["login"].'"';
  $res = SqlQuery($query);
  $row = mysqli_fetch_object($res);
  
  if($row->skin)
    echo("<p class=\"centre\"><img width=\"110\" src=\"".$row->skin."\" /></p>");
  else
    echo("<br /><br />");
  ?>
    <form action="profil.php" method="post">
    <input type="hidden" name="modif" value="1" style="text-align: center">
    <table width="75%" align="center">
      <tr>
        <td align="right" width="50%"> Login : </td>
	<td> <?php echo($_SESSION["login"]); ?> </td>
      </tr>
      <tr>
        <td align="right" width="50%"> Grade : </td>
        <td> <?php echo($const_levelnames[($_SESSION["level"]-1)]); ?> </td>
      </tr>
      <tr>
        <td align="right" width="50%"> Skin : </td>
	<td> <?php echo("<input type=\"text\" name=\"skin\" value=\"".$row->skin."\">"); ?> </td>
      </tr>
      <tr>
        <td align="center" colspan="2"><a href="skinsend.php">Envoyer votre skin</a></td>
      </tr>
      <tr>
        <td> </td>
      </tr>
      <tr>
        <td align="center" colspan="2"> <h3>Pour modifier votre mot de passe :</h3></td>
      </tr>
      <tr>
        <td align="right" width="50%"> Mot de passe actuel : </td>
	<td> <input type="password" name="pwd"> </td>
      </tr>
      <tr>
        <td align="right" width="50%"> Nouveau mot de passe : </td>
	<td> <input type="password" name="newpwd"></td>
      </tr>
      <tr>
        <td align="right" width="50%"> Verification mot de passe :</td>
	<td> <input type="password" name="newpwd2"></td>
      </tr>
      <tr>
        <td> <br /> </td>
      </tr>
      <tr>
        <td align="center" colspan="2"> <input type="submit" value="Valider"></td>
      </tr>
      <tr>
        <td><br /></td>
      </tr>
      <tr>
        <td align="center" colspan="2"><a href="forum.php">Retour au forum</a></td>
      </tr>
    </table>
    </form>    
  <?php

  bottom();
?>
