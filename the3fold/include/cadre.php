<?php
  include("./include/const.php");
  // Repertoire contenant la partie statique du site.
  $contenu="contenu";

  // Crée l'en-tête de la page
  function top($refresh = "")
  {
    global $const_lang;
    global $const_css;
    global $const_ico;
    global $const_alertIE;
    global $const_alertIEmsg;
    echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?> \n"
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <?php
      echo("<html lang=\"$const_lang\">");
    ?>
      <head>    
        <title> -=(the3fold)=- New Generation</title>
        <meta http-equiv="content-type" content="text/html;charset=iso-8859-1" />
	<?php
	if($refresh)
	 echo("<meta http-equiv=\"refresh\" content=\"0;URL=$refresh\">\n");
        echo('<link rel="stylesheet" media="screen" title="Colin" href="./style/'.$const_css.'" type="text/css" />'."\n");
        echo('<link rel="shortcut icon" href="./style/'.$const_ico.'"/>'."\n");
        echo("</head>\n");
        if($const_alertIE && isset($_SERVER["HTTP_REFERER"]) && !preg_match("/the3fold\.free\.fr/",$_SERVER["HTTP_REFERER"]) && preg_match("/IE/",$_SERVER["HTTP_USER_AGENT"]))
          echo("<body onload=\"alert('$const_alertIEmsg');\">");
        else
          echo("<body>");
	?>
        <div id="top">
          <h1 class="titre">-=(the3fold)=-</h1>
          <h2 class="titre">New Generation</h2>
        </div>
        <div id="contenu">
            <div class="centre">
              <script type="text/javascript"><!--
              google_ad_client = "ca-pub-3040795652020570";
              /* trophy */
              google_ad_slot = "9787486084";
              google_ad_width = 728;
              google_ad_height = 90;
              //-->
              </script>
              <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
              </script>
            </div>
       <?php
       if($const_alertIE && preg_match("/IE/",$_SERVER["HTTP_USER_AGENT"]))
       {
	     echo('<p class="centre"><a href="http://www.getfirefox.net/"><img alt="Upgrade to Firefox!" title="Upgrade to Firefox!" src="http://sfx-images.mozilla.org/firefox/3.6/110x32_get_orange.png"/></a></p>');
       }
  }

  // Crée le menu
  function menu()
  {
    global $contenu;
    global $const_leveladmin;
    ?>
    <p class="centre"><img class="centre" src="images/tux.png" alt="Tux" /></p>
    <h1 class="men">Menu</h1><br />
    <ul class="men">
    <li><h3 class="men"><a href="index.php" accesskey="A">Accueil</a></h3></li>
    <?php
    echo(parseDir("$contenu"));
    ?>
    <li><h2 class="men"><a href="annexes.php">Annexes</a></h2></li>
    <li><ul>
    <li><h3 class="men"><a href="downloads.php" accesskey="T">Téléchargements</a></h3></li>
    <li><h3 class="men"><a href="doc.php" accesskey="D">Documents</a></h3></li>
    <li><h3 class="men"><a href="liens.php" accesskey="L">Liens</a></h3></li>
    </ul></li>
    <li><h2 class="men"><a href="membres.php" accesskey="E">Espace membres</a></h2></li>
    <li><ul>
    <li><h3 class="men"><a href="forum.php" accesskey="F">Forum</a></h3></li>
    <li><h3 class="men"><a href="admin.php">Administration</a></h3></li>
    </ul></li>
    <li><h2 class="men"><a href="contacts.php" accesskey="E">Contacts</a></h2></li>
    <li><ul>
    <li><h3 class="men"><a href="contacts.php" accesskey="C">Contacts</a></h3></li>
    </ul></li>
    </ul> <!-- men -->
    <?php
  }

  // Parse les messages pour l'affichage
  function parseMsgToShow($msg)
  {
    $msg = preg_replace("/\#url{([^}]*)}/", "<a href=\"\$1\" rel=\"nofollow\">\$1</a>", $msg);
    $msg = preg_replace("/\#comment{([^}]*)}/", "<span class=\"comment\">$1</span>", $msg);
    $msg = preg_replace("/\#commande{([^}]*)}/", "<span class=\"commande\">\$1</span>", $msg);
    $msg = preg_replace("/\#title{([^}]*)}/", "<h3 class=\"forum\">\$1</h3>", $msg);
    $msg = preg_replace("/\#subtitle{([^}]*)}/", "<h4 class=\"forum\">\$1</h4>", $msg);
    $msg = preg_replace("/\#picture{([^},]*),?([^}]*)?}/", "<img src=\"$1\" alt=\"$2\">", $msg);
    $msg = preg_replace("/\#code{([^}]*)}/", "<div class=\"code\">$1</div>", $msg);
	$msg = preg_replace("/\#closing_brace/", "}", $msg);
    return $msg;
  }

  // Parse les messages pour la modification
  function parseMsgToModify($msg)
  {
    $msg = html_entity_decode(preg_replace('!<br.*>!iU',"",$msg));
    return $msg;
  }

  // Parse les messages pour l'enregistrement
  function parseMsgToSave($msg)
  {
	$msg = str_replace("\t", "&nbsp; &nbsp; ", $msg);
    $msg = nl2br(str_replace("  ", "&nbsp; ", htmlentities($msg)));
    return $msg;
  }

  // Crée la partie dynamique du menu
  function parseDir($dir,$lvl = 0)
  {
    global $accesskey;
    if(!isset($chaine)) $chaine="";
    $dh = opendir($dir);
    while (false !== ($filename = readdir($dh))) 
    {
      $files[] = $filename;
    }
    sort($files);

    $menuvide = 1;

    for($i=0;$i<sizeof($files);$i++)
    {
      if($files[$i]{0} != ".")
      {
        $menuvide = 0;
        if(is_dir($dir."/".$files[$i]))
        {
          $chaine .= "<li><h2 class=\"men\"><a href=\"index.php?src=$dir/$files[$i]\">".$files[$i]."</a></h2></li>\n";
          $chaine .= "<li><ul>".parseDir($dir."/".$files[$i],$lvl+1)."</ul></li>";
        }
        else
        {
          $chaine .= "<li><h3 class=\"men\"><a href=\"index.php?src=$dir/$files[$i]\">".$files[$i]."</a></h3></li>\n";
        }
      }
    }

    if ($menuvide == 1)
    {
      $chaine .= "<li><!-- Menu vide --></li>";
    }
    
    return $chaine;
  }

  // Se connecte à la base SQL
  function SqlConnect()
  {
    global $const_SQLhost;
    global $const_SQLuser;
    global $const_SQLpassword;
    global $const_SQLbase;
    global $db_link;

    $db_link = mysqli_connect($const_SQLhost, $const_SQLuser, $const_SQLpassword, $const_SQLbase)
      or die("Could not connect : " . mysqli_error());
  }

  // Lance une requête SQL
  function SqlQuery($query)
  {
    global $db_link;
    $res = mysqli_query($db_link, $query) or die("Query failed : " . mysqli_error());
    return $res;
  }
  
  // Crée le pied de page
  function bottom()
  {
    ?>
    </div>
    <div id="conteneurmenu">
      <div id="hautmenu">
      </div>
      <div id="menu">
      <?php
        menu();
      ?>
      </div>
      <div id="basmenu">
      </div>
    </div>
    <div id="copyright">
      &copy; 2004 -=(the3fold)=-
    </div>
    </body>
    </html>
    <?php
  }
?>
