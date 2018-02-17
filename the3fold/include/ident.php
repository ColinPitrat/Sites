<?php
  session_start();
  header("Cache-control: private");
  require("./include/cadre.php");
  
  top();

  if(isset($_POST["login"]) && $_POST["login"])
  {
    SqlConnect();
    
    $query = "SELECT * FROM users WHERE nick='".$_POST["login"]."'";
    $res = SqlQuery($query);
    $row = mysqli_fetch_object($res);
    
    if($row && $row->password==md5($_POST["password"]))
    {
      $_SESSION["authent"] = 1;
      $_SESSION["login"] = $row->nick;
      $_SESSION["level"] = $row->level;
    }
    else
    {
      $_SESSION["authent"] = 0;
    }
  }

  if(!isset($_SESSION["authent"]) || $_SESSION["authent"] != 1)
  {
    ?>
    <h1>Espace membres</h1>
    <br/>
    Le forum possède une <a href="forumpublic.php">partie publique</a>, accessible à tous sans identification.<br/>
    <br/>
    Avant de pouvoir poster dans le forum, vous devez vous identifier.<br/>
    Si vous ne poss&eacute;dez pas encore d'identit&eacute;, vous
    devez en cr&eacute;er une en cliquant <a href="subscribe.php">ici</a>.
    <br/>Si vous en avez d&eacute;j&agrave; une, entrez simplement votre nom
    et votre mot de passe ci-dessous.
    <br/>
    <br/>
    <br/>
    <form action="" method="post">
    <table cellspacing="10px" width="100%">
      <tr>
        <td align="right"> Login : </td>
        <td> <input type="text" name="login" /></td>
      </tr>
      <tr> 
        <td align="right"> Mot de passe : </td>
        <td> <input type="password" name="password" /> </td>
      </tr>
      <tr>
        <td> <br/></td>
      </tr>
      <tr>
        <td align="center" colspan="2"> <input type="submit" value="Se connecter" /></td>
      </tr>
    </table>
    </form>
    <?php
    bottom();  
    exit();
  }
?>
