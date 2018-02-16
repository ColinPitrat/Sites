<?php
  require("./include/cadre.php");
  top();
  SqlConnect();

  if(isset($_GET["thread"])) $thread = $_GET["thread"]; else $thread = FALSE;
  if(isset($_GET["msg"])) $msg = $_GET["msg"]; else $msg = FALSE;

  echo("<h1>Forum public</h1>");

  echo("<p class=\"small\">Cette partie contient des sujets épinglés depuis le forum, c'est à dire des sujets jugés interessants et qui méritent d'être partagés. Cependant, cette partie est en lecture seule. Si vous désirez poster des messages ou acceder aux discussions non épinglées, vous devez vous identifier sur le forum.</p>");

  if($thread)
  {
    // Afficher messages
    $query = "SELECT epingle FROM forumthreads WHERE id='".$thread."'";
    $res = SqlQuery($query);
    $row = mysql_fetch_object($res);

    if($row->epingle)
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
          echo("<img width=\"110\" src=\"".$row2->skin."\" alt=\"".$row->auteur."\"/><br/>");
        }
        echo("<strong>".$row->auteur."</strong><span class=\"grade\"><br/>".$const_levelnames[($row2->level-1)]."</span></td><td>".parseMsgToShow($row->message));
        echo("</td></tr></table>");
        $row = mysql_fetch_object($res);
      }
    }
    else
    {
      ?>
        <p>Cette discussion n'est pas disponible dans le forum public ou n'existe pas.</p>
      <?php
    }
  }
  else
  {
    // Afficher threads
    echo("<br/><br/><table class=\"forumliste\"><tr><th style=\"width: 85%;\">Discussion</th><th>Dernier message</th></tr>");    

    $query = "SELECT * FROM forumthreads WHERE epingle=1 ORDER BY id";
    $res = SqlQuery($query);
    $row = mysql_fetch_object($res);
     
    while($row)
    {
      echo("<tr><td class=\"link\"><a href=\"forumpublic.php?thread=".$row->id."\">".$row->nom."</a></td>");
      echo("<td class=\"date\">".$row->date."</td></tr>");
      $row = mysql_fetch_object($res);
    }
      
    echo("</table>");
  }
  
  bottom();
?>
