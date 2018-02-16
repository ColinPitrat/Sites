<?php
  include('./include/cadre.php');
  top();
?>

  <h1>Téléchargements</h1>
  <br />
  <p>Vous trouverez ici un certain nombre de mes réalisations à télécharger.</p>
  <br />

  <ul>

  <li>
  <h3><a href="downloads/colored_dropshadow.tar.gz">E17 Colored Dropshadow</a></h3>
  <p>Vous utilisez e17 ? Alors vous connaissez certainement le module dropshadow, qui permet d'afficher l'ombre des fenêtres. Ce patch vous permet de choisir la couleur de l'ombre (qui devient alors plutôt un effet néon) parmis 8 couleurs. Pour l'appliquer, il suffit de copier l'intégralité des fichiers dans le répertoire <span class="commande">e17/apps/e/src/modules/dropshadow/</span> et d'appliquer les patchs (fichiers <span class="commande">.diff</span>) en utilisant la commande <span class="commande">patch -p0 &lt; file.diff</span></p>
  <div class="screenshot">
  <a href="screenshots/ColoredDropshadow/colored_dropshadow.png"><img src="screenshots/ColoredDropshadow/thumbs/colored_dropshadow.png" alt="Ombres portées colorées sous e17" title="Ombres portées colorées sous e17"/></a>&nbsp;
  </div>
  <div class="screenshot">
  <a href="screenshots/ColoredDropshadow/colored_dropshadow2.png"><img src="screenshots/ColoredDropshadow/thumbs/colored_dropshadow2.png" alt="Ombres portées colorées sous e17" title="Ombres portées colorées sous e17"/></a>&nbsp;
  </div>
  <div class="spacer">
  </div>
  </li>

  <li>
  <h3><a href="downloads/automates.tar.gz">Automates cellulaires</a></h3>
  <p>Un petit programme que j'ai fait pour un exposé sur les automates cellulaires. Il permet de simuler certains automates cellulaires en 2 dimension, et (par un hack douteux) des automates cellulaires en 1 dimension. Le rapport et la présentation de l'exposé sont disponibles dans l'archive.</p>
  <div class="screenshot">
  <a href="screenshots/Automates/automate-feu.png"><img src="screenshots/Automates/thumbs/automate-feu.png" alt="Automate feu de forêt" title="Automate feu de forêt"/></a>&nbsp;
  </div>
  <div class="screenshot">
  <a href="screenshots/Automates/automate-sierpinski.png"><img src="screenshots/Automates/thumbs/automate-sierpinski.png" alt="Automate de dimension 1 produisant un tapis de Sierpinski" title="Automate de dimension 1 produisant un tapis de Sierpinski"/></a>&nbsp;
  </div>
  <div class="screenshot">
  <a href="screenshots/Automates/automate-worms.png"><img src="screenshots/Automates/thumbs/automate-worms.png" alt="Automate Worms" title="Automate Worms"/></a>&nbsp;
  </div>
  <div class="spacer">
  </div>
  </li>

  <li>
  <h3><a href="downloads/gnats2mantis-0.6.tar.gz">GNATS to Mantis</a></h3>
  <p><a href="http://www.gnu.org/software/gnats/">GNATS</a> est le gestionnaire de bugs du projet GNU. <a href="http://www.mantisbt.org">Mantis</a> est un gestionnaire de bugs libre. Ce script permet d'exporter une base de bugs de GNATS vers Mantis.</p>
  </li>

  <li>
  <h3><a href="downloads/fr_ro-0.1.kvtml">Vocabulaire Français - Roumain</a></h3>
  <p>Un fichier de vocabulaire pour <a href="http://edu.kde.org/kvoctrain/">KVocTrain</a> permettant d'apprendre le Roumain. Il devrait aussi pouvoir être utilisé avec d'autres logiciels comme <a href="http://edu.kde.org/kwordquiz/">KWordQuiz</a> ou <a href="http://edu.kde.org/flashkard/">FlashKard</a>. Ce fichier n'est pas encore très avancé mais sera mis à jour régulièrement.</p>
  </li>

  <li>
  <h3><a href="downloads/rsbac-bash_completion-0.1">Bash completion pour RSBAC</a></h3>
  <p>Un fichier de configuration (encore incomplet) pour <a href="http://www.caliban.org/bash/index.shtml#completion">bash completion</a> permettant de simplifier l'utilisation des commandes RSBAC. À noter que je suis aussi en train d'écrire <a href="doc.php">une documentation sur RSBAC</a>.</p>
  </li>

  </ul>

<?php
  bottom();
?>
