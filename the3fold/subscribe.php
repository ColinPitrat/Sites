<?php
  require("./include/cadre.php");
  top();

  ?>
    <h1>Espace membres</h1>
    <h3 class="centre">Création d'une identité</h3>
    <br />
  <?php

  if($_POST["password"] || $_POST["login"] || $_POST["password2"])
  {
    $libre = 1;
    $identiques = 1;
    $vide = 0;
    
    if($_POST["password"] != $_POST["password2"])
    {
      $identiques = 0;
    }
    
    if($_POST["password"]=="" || $_POST["login"]=="" || $_POST["password2"]=="")
    {
      $vide = 1;
    }
    
    SqlConnect();
    
    $query = "SELECT * FROM users";
    $res = SqlQuery($query);
    
    $row = mysql_fetch_object($res);
    
    while($row != FALSE)
    {
      if($_POST["login"]==$row->nick)
      {
        $libre = 0;
      }
      $row = mysql_fetch_object($res);
    }

    if(($libre == 1) && ($identiques == 1) && ($vide == 0))
    {
      $name = $_POST["login"];
      $pwd = md5($_POST["password"]);
      $query = "INSERT INTO users(nick,password) VALUES (\"$name\",\"$pwd\");";
      SqlQuery($query);
      echo("Inscription réussie. Cliquez <a href=\"membres.php\">ici</a> pour retourner à l'entrée de l'espace membre.");
      bottom();
      exit();
    }
    else
    {
      if($libre != 1)
      {
        echo("<font color=\"#FF0000\">Le login demand&eacute; est d&eacute;j&agrave; utilis&eacute;. Veuillez en changer.</font><br />");
      }
      if($identiques != 1)
      {
        echo("<font color=\"#FF0000\">Les deux mots de passe que vous avez tap&eacute; ne sont pas identiques.</font><br />");
      }
      if($vide != 0)
      {
        echo("<font color=\"#FF0000\">Vous avez laiss&eacute; vide un champs n&eacute;cessaire.</font><br />");
      }
    }
  }
  ?>
    <br />
    <form action="" method="post">
      <table cellspacing="10px" width="100%">
        <tr>
          <td align="right" style="width: 50%"> Login : </td>
          <td> <input type="text" name="login" /></td>
        </tr>
        <tr>
          <td align="right"> Mot de passe : </td>
          <td> <input type="password" name="password" /></td>
        </tr>
        <tr>
          <td align="right"> Vérification du mot de passe : </td>
          <td> <input type="password" name="password2" /></td>
        </tr>
        <tr>
          <td> <br /> </td>
        </tr>
        <tr>
          <td align="center" colspan="2"> <input type="submit" value="S'inscrire" /></td>
        </tr>
      </table>
    </form>
<?php
  bottom();
?>
