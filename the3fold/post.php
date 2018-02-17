<?php
  require("./include/ident.php");

  if(isset($_GET["action"])) $action = $_GET["action"]; else $action = FALSE;
  if(isset($_GET["salon"])) $salon = $_GET["salon"]; else $salon = FALSE;
  if(isset($_GET["thread"])) $thread = $_GET["thread"]; else $thread = FALSE;
  if(isset($_GET["idmsg"])) $idmsg = $_GET["idmsg"]; else $idmsg = FALSE;

  switch($action)
  {
  case 1:
    if(!isset($_SESSION["level"]) || $_SESSION["level"] < $const_levelforumadmin)
    {
      echo("<b>Vous n'avez pas le statut nécessaire pour afficher cette page</b>");
      break;
    }
    ?>
    <h3 class="centre">Créer un nouveau salon</h3>
    <center>
    <form action="forum.php" method="post" enctype="multipart/form-data">
    <?php
    echo('<input type="hidden" name="action" value=1 />');
    echo("Niveau minimum pour l'acces au forum (1-$const_levelmax) :");
    ?>
    <input type="text" name="lvl" size="8" />
    <br /><br />
    Titre :
    <input type="text" name="titre" size="80" maxlength="80" />
    <br /><br /><br />
    Selectionnez une image :
    <br /><br />
    <?php
    $dh = opendir("./images");
    $count = 0;
    while (false !== ($filename = readdir($dh)))
    {
      if((filetype("./images/".$filename)=="file") && ($filename{0}!='.'))
      {
        echo('<input type="radio" value="./images/'.$filename);
        if($filename==$const_defaultimg)
        {
          echo('" checked="1');
        }
        echo('" name="img"><img src="./images/'.$filename.'" width="60" align="middle">&nbsp;&nbsp;&nbsp;&nbsp;');
        if((++$count % 4) == 0)
        {
          echo("<br /><br />");
        }
      }
    }
    ?>                            
    <br /><br /><br />
    Ou uploadez en une nouvelle ...
    <br /><br />
    Image :
    <input type="file" name="userfile" size="40" maxlength="400">
    <br /><br />
    <input type="submit" value="Créer">
    </form>
    <br /><br /><a href="forum.php">Retour au forum</a></center>
    <?php
    break;
  case 2:
    ?>
    <center><h3>Créer une nouvelle discussion</h3>
    <form action="forum.php" method="post">
    <?php
    echo('<input type="hidden" name="salon" value="'.$salon.'">');
    echo('<input type="hidden" name="action" value=2>');
    ?>
    Titre :<br />
    <input type="text" name="titre" size="80" maxlength="80">
    <br /><br />
    Message :<br />
    <textarea name="msg" rows="10" cols="80"></textarea>
    <br /><br />
    <input type="submit" value="Poster">
    </form>
    <?php
    echo("<br /><br /><a href=\"forum.php?salon=$salon\">Retour au forum</a></center>");
    break;
  case 3:
    ?>
    <center><h3>Poster un message</h3>
    <form action="forum.php" method="post">
    <?php
    echo('<input type="hidden" name="thread" value="'.$thread.'">');
    echo('<input type="hidden" name="salon" value="'.$salon.'">');
    echo('<input type="hidden" name="action" value="3">');
    ?>
    <textarea name="msg" rows="10" cols="60"></textarea>
    <br /><br />
    <input type="submit" value="Poster">
    </form>
    <?php
    echo("<br /><br /><a href=\"forum.php?salon=$salon&thread=$thread\">Retour au forum</a></center>");    
    break;
  case 4:
    if(!isset($_SESSION["level"]) || $_SESSION["level"] < $const_levelforumadmin)
    {
      echo("<b>Vous n'avez pas le statut nécessaire pour afficher cette page</b>");
      break;
    }
    SqlConnect();
    $query = "SELECT * FROM forumsalons WHERE id=$salon";
    $res = SqlQuery($query);
    $row = mysqli_fetch_object($res);
    $lvl = $row->lvl;
    $img = $row->img;
    $titre = $row->nom;
    ?>
    <center><h3>Modifier le salon</h3>
    <form action="forum.php" method="post" enctype="multipart/form-data">
    <?php
    echo('<input type="hidden" name="salon" value="'.$salon.'"/>');
    echo('<input type="hidden" name="action" value="4"/>');
    echo("Niveau minimum pour l'acces au forum (1-$const_leveladmin) :");
    echo('<input type="text" name="lvl" value="'.$lvl.'" size="8"/>');
    ?>
    <br /><br />
    Titre :
    <?php
    echo('<input type="text" name="titre" size="80" value="'.$titre.'" maxlength="80"/>');
    ?>
    <br /><br /><br />
    Selectionnez une image :
    <br /><br />
    <?php
    $dh = opendir("./images");
    $count = 0;
    while (false !== ($filename = readdir($dh)))
    {
      if((filetype("./images/".$filename)=="file") && ($filename{0}!='.'))
      {
        echo('<input type="radio" value="./images/'.$filename);
        if("./images/".$filename==$img)
        {
          echo('" checked="1');
        }
        echo('" name="img"><img src="./images/'.$filename.'" width="60" align="middle">&nbsp;&nbsp;&nbsp;&nbsp;');
        if((++$count % 4) == 0)
        {
          echo("<br /><br />");
        }
      }
    }
    ?>                            
    <br /><br /><br />
    Ou uploadez en une nouvelle ...
    <br /><br />
    Image :
    <input type="file" name="userfile" size="40" maxlength="400">
    <br /><br />
    <input type="submit" value="Modifier">
    </form>
    <br /><br /><a href="forum.php">Retour au forum</a></center>
    <?php
    break;
  case 5:    
    SqlConnect();
    $query = "SELECT auteur,message,thread FROM forummessages WHERE id=$idmsg";
    $res = SqlQuery($query);
    $row = mysqli_fetch_object($res);
    if($row->auteur != $_SESSION["login"])
    {
      echo("<b>Vous n'avez pas le statut nécessaire pour afficher cette page</b>");
      break;
    }
    $thread = $row->thread;
    ?>
    <center><h3>Modifier le message</h3>
    <form action="forum.php" method="post">
    <?php
    echo('<input type="hidden" name="idmsg" value="'.$idmsg.'">');
    echo('<input type="hidden" name="action" value="5">');
    echo('<textarea name="msg" rows="10" cols="60">'.parseMsgToModify($row->message).'</textarea>');
    ?>
    <br /><br />
    <input type="submit" value="Modifier">
    </form>
    <?php
    $query = "SELECT salon FROM forumthreads WHERE id=$thread";
    $res = SqlQuery($query);
    $row = mysqli_fetch_object($res);
    $salon = $row->salon;
    
    echo("<br /><br /><a href=\"forum.php?salon=$salon&thread=$thread\">Retour au forum</a></center>");    
    break;
  case 6:
    ?>
    <h3 class="centre">Etes vous sur de vouloir supprimer ce salon ?</h3>
    <center>
    <br /><br />
    <form action="forum.php" method="post">
    <input type="hidden" value="6" name="action">
    <?php
    echo('<input type="hidden" value="'.$salon.'" name="salon"/>');
    ?>
    <input type="submit" value="Supprimer"/>
    </form>
    <br /><br />
    <a href="forum.php">Retour au forum</a></center>
    <?php
    break;
  case 7:
    ?>
    <center><h3>Etes vous sur de vouloir supprimer cette discussion ?</h3>
    <br /><br />
    <form action="forum.php" method="post">
    <input type="hidden" value="7" name="action"/>
    <?php
    echo('<input type="hidden" value="'.$thread.'" name="thread">');
    ?>
    <input type="submit" value="Supprimer">
    </form>
    <br /><br />
    <?php
    SqlConnect();
    $query = "SELECT salon FROM forumthreads WHERE id=\"$thread\"";
    $res = SqlQuery($query);
    $row = mysqli_fetch_object($res);
    $salon = $row->salon;                            
    echo("<a href=\"forum.php?salon=$salon\">Retour au forum</a></center>");
    break;
  case 8:
    ?>
    <center><h3>Etes vous sur de vouloir supprimer ce message ?</h3>
    <br /><br />
    <form action="forum.php" method="post">
    <input type="hidden" value="8" name="action">
    <?php
    echo('<input type="hidden" value="'.$idmsg.'" name="idmsg">');
    ?>
    <input type="submit" value="Supprimer">
    </form>
    <br /><br />
    <?php
    SqlConnect();
    $query = "SELECT thread FROM forummessages WHERE id=\"$idmsg\"";
    $res = SqlQuery($query);
    $row = mysqli_fetch_object($res);
    $thread = $row->thread;
    $query = "SELECT salon FROM forumthreads WHERE id=\"$thread\"";
    $res = SqlQuery($query);
    $row = mysqli_fetch_object($res);
    $salon = $row->salon;                            
    echo("<a href=\"forum.php?salon=$salon&thread=$thread\">Retour au forum</a></center>");
    break;
  case 9:
    ?>
    <center><h3>Etes vous sur de vouloir épingler cette discussion ?</h3>
    <br /><br />
    <form action="forum.php" method="post">
    <input type="hidden" value="9" name="action"/>
    <?php
    echo('<input type="hidden" value="'.$thread.'" name="thread">');
    ?>
    <input type="submit" value="Epingler">
    </form>
    <br /><br />
    <?php
    SqlConnect();
    $query = "SELECT salon FROM forumthreads WHERE id=\"$thread\"";
    $res = SqlQuery($query);
    $row = mysqli_fetch_object($res);
    $salon = $row->salon;                            
    echo("<a href=\"forum.php?salon=$salon\">Retour au forum</a></center>");
    break;
  case 10:
    ?>
    <center><h3>Etes vous sur de vouloir desépingler cette discussion ?</h3>
    <br /><br />
    <form action="forum.php" method="post">
    <input type="hidden" value="10" name="action"/>
    <?php
    echo('<input type="hidden" value="'.$thread.'" name="thread">');
    ?>
    <input type="submit" value="Desépingler">
    </form>
    <br /><br />
    <?php
    SqlConnect();
    $query = "SELECT salon FROM forumthreads WHERE id=\"$thread\"";
    $res = SqlQuery($query);
    $row = mysqli_fetch_object($res);
    $salon = $row->salon;                            
    echo("<a href=\"forum.php?salon=$salon\">Retour au forum</a></center>");
    break;
  }
  
  bottom();
?>
