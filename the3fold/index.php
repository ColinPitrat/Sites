<?php
  require("include/cadre.php");
  top(); 

  if(isset($_GET["src"])) $src = $_GET["src"]; else $src = FALSE;

  SqlConnect();
  if(isset($_GET["subject"])) $sujet = $_GET["subject"]; else $sujet = FALSE;
  if(isset($_GET["type"])) $type = $_GET["type"]; else $type = FALSE;
  if($sujet)
  {
    switch($type)
    {
      case 1:
        $table = "bugs";
        $name = "rapport de bug (ou une suggestion)";
        break;
      default:
        $table = "comments";
        $name = "commentaire";
        break;
    }
    if(isset($_POST["texte"]) && isset($_POST["captcha_id"]) && $_POST["texte"])
    {
      $antispam_row = mysqli_fetch_array(SqlQuery("SELECT answer FROM captcha WHERE id = ".$_POST["captcha_id"]));
      if($_POST["captcha_ans"] == $antispam_row["answer"])
      {
        if(!$_POST["name"])
	{
	  $_POST["name"] = "Anonyme";
	}
	$date = date("d-m-Y");
	$query = 'INSERT INTO '.$table.'(subject, date, name, texte, captcha) VALUES("'.$sujet.'", "'.$date.'", "'.$_POST["name"].'", "'.$_POST["texte"].'", "'.$_POST["captcha_id"].'")';
	$res = SqlQuery($query);
	echo("<p>Merci de votre contribution.</p>");
      }
      else
      {
	echo("<p>Vous n'avez pas passé le test anti-robots.</p>");
      }
    }
    else
    {
      $antispam_row = mysqli_fetch_array(SqlQuery("SELECT id, question FROM captcha ORDER BY rand() LIMIT 1"));
      echo("<center><h3>Poster un $name</h3>");
      ?>
      <form action="" method="post">
      <table cellspacing="10px" width="100%">
        <tr>
          <td align="right">Nickname : </td>
          <td><input type="text" name="name"></td>
        </tr>
        <tr>
          <td align="right">Votre texte : </td>
          <td><textarea name="texte" rows="10" cols="60"></textarea><br/>
        </tr>
        <tr>
	<td align="right">Prouvez que vous n'êtes pas un robot. <br/><?php echo $antispam_row["question"] ?></td>
	<td><input type="hidden" name="captcha_id" value="<?php echo $antispam_row["id"] ?>"/><input type="text" name="captcha_ans"/><br/>
        </tr>
      </table>
      <input type="submit" value="Poster">
      </form>
      </center>
      <?php
    }
  }
  else
  {
    if(!$src)
    {
      echo("<h1>Nouvelles</h1>");
  
      $date=date("Y-m-d");
  
      $query = "SELECT * FROM news ORDER BY id DESC";
      $res = SqlQuery($query);
      $row = mysqli_fetch_object($res);
  
      while($row)
      {
        if(strcmp($date,$row->datedebut) >= 0 && strcmp($date,$row->datefin) < 0)
        {
          echo("<div class=\"newstitle\">".$row->titre."</div><div class=\"newsauthor\">Posté par ".$row->auteur."</div><div class=\"newstexte\">".$row->texte."</div><br/>");
        }
        $row = mysqli_fetch_object($res);
      }
    }
    else
    { 
      if((file_exists($src)) && (strpos(dirname(realpath($src)),"contenu")))
      {
        if(is_dir($src))
        {
          $dh = opendir($src);
          while (false !== ($filename = readdir($dh)))
          {
            $files[] = $filename;
          }
          sort($files);
   
          echo("<h1>".substr($src,strrpos($src,'/')+1)."</h1><br />");
  
          for($i=0;$i<sizeof($files);$i++)
          {
            if($files[$i]{0} != ".")
            {
              echo("<h2 class=\"centre\"><a href=\"index.php?src=$src/$files[$i]\">".$files[$i]."</a><br /></h2>");
            }
          }
        }
        else
        {
          $fd = fopen($src,'r');
          while (!feof ($fd)) 
          {
            $buffer = fgets($fd, 4096);
            if(preg_match("/\#comments{([^}]*)}/",$buffer,$matches))
            {
              $query = "SELECT * FROM comments WHERE subject='".$matches[1]."' ORDER BY id";
              $res = SqlQuery($query);
              $row = mysqli_fetch_object($res);
              echo("<blockquote>");
              while($row)
              {
                echo("<p class=\"comment\"><span class=\"author\">".$row->name."</span><br/><span class=\"date\">".$row->date."</span><br/>".$row->texte."</p>");
                $row = mysqli_fetch_object($res);
              }
              echo("</blockquote>");
              $buffer = str_replace($matches[0],"",$buffer);
            }
            if(preg_match("/\#bugs{([^}]*)}/",$buffer,$matches))
            {
              $query = "SELECT * FROM bugs WHERE subject='".$matches[1]."' ORDER BY id";
              $res = SqlQuery($query);
              $row = mysqli_fetch_object($res);
              echo("<blockquote>");
              while($row)
              {
                echo("<p class=\"comment\"><span class=\"author\">".$row->name."</span><br/><span class=\"date\">".$row->date."</span><br/>".$row->texte."</p>");
                $row = mysqli_fetch_object($res);
              }
              echo("</blockquote>");
              $buffer = str_replace($matches[0],"",$buffer);
            } 
            echo $buffer;
          } 
          fclose ($fd);
        }
      }
      else
      {
        echo("<h1>Erreur 404</h1>");
        echo("<br /><p>Le fichier spécifié n'a pu etre trouvé. Si vous etes arrivé ici en cliquant sur un lien, veuillez envoyer le contenu de la barre d'adresse à <a href=\"mailto://colin.pitrat@gmail.com\">colin.pitrat@gmail.com</a>.</p>");
        echo("\$src : $src<br/>dirname(realpath(\$src)) : ".dirname(realpath($src)));
      }
    }
  }
  
  bottom();
?>
