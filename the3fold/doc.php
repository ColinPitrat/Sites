<?php
  include('./include/cadre.php');
  top();
?>

  <h1>Documents</h1>
  <br />
  <p>Vous trouverez ici un certain nombre de documents interessants concernant la programmation sous GNU/Linux.</p>
  <br />

  <h2>Outils de programmation</h2>
  <ul>
  <li>
  <h3><a href="doc/vimbook.pdf">Vim Book</a></h3>
  <p>Un livre pour bien utiliser vim. Il présente un grand nombre de commandes et donne un certain nombre d'astuces. Pratique pour progresser, mais si vous débutez, je vous conseille de d'abord utiliser la commande <span class="commande">vimtutor</span>.</p>
  <br/>
  </li>
  </ul>

  <h2>Programmation de jeux</h2>
  <ul>
  <li>
  <h3><a href="doc/games.pdf">Programming Linux Games</a></h3>
  <p>Un livre en anglais très interessant et destiné aux débutants concernant la programmation de jeux.</p>
  <br />
  </li>
  </ul>

  <h2>GNU/Hurd</h2>
  <ul>
  <li>
  <h3><a href="doc/hhg.html">Le guide du hacker sous Hurd</a></h3>
  <p>La traduction que j'ai faite depuis l'anglais du "Hurd Hacking Guide". Les bases pour pouvoir hacker le Hurd. <a href="doc/hhg.texi">La version texinfo</a> est aussi disponible. A noter que cette version n'est plus maintenu. Pour avoir la version à jour et pour plus de documentation sur le Hurd, visitez le wiki de hurdfr : <a href="http://wiki.hurdfr.org/index.php/Accueil">http://wiki.hurdfr.org/index.php/Accueil</a>.</p>
  <br />
  </li>
  </ul>

  <h2>RSBAC</h2>
  <ul>
  <li>
  <h3><a href="doc/rsbac_commands-0.3.html">Commandes d'administration de RSBAC</a></h3>
  <p><a href="http://www.rsbac.org/">RSBAC</a> est un patch pour le noyau comparable à <a href="http://www.nsa.gov/selinux/">SELinux</a>. Il permet de renforcer la sécurité du système d'exploitation en définissant de manière très fine une politique de sécurité. Ce document liste les commandes permettant d'administrer RSBAC 1.3.0, explique brièvement leur fonctionnalité et donne des exemples d'utilisation. Je suis aussi en train d'écrire <a href="downloads.php">un fichier pour avoir la completion sous bash pour les commandes RSBAC</a>.</p>
  </li>
  </ul>
  

<?php
  bottom();
?>
