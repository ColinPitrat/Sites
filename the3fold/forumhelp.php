<?php
  require("./include/ident.php");
?>
  <h1>Utilisation du forum</h1>
  <h2>Règles d'utilisation du forum</h2>
  <p>Le forum est destiné à l'échange de savoir et d'idées entre les utilisateurs. Il est cependant soumis à certaines règles d'utilisation.</p>
  <p>Le forum est organisé en salons, qui définissent un thème de discussion. Les messages ne correspondant pas au thème du salon dans lequel ils sont postés pourront être supprimés. De même, les messages contenant des propos racistes, homophobes ... mais aussi les messages trollesques ou publicitaires seront censurés. Enfin, les messages rédigés dans un langage incompréhensible (style SMS, nombreuses fautes de français, informations erronées) ne sont pas non plus les bienvenus.</p>
  <p>A noter que certaines discussions sont épinglées, c'est à dire disponibles sans avoir à s'identifier. Le thème de ces discussions est délimité précisément. Les règles ci-dessus s'appliquent de manière encore plus stricte.</p>
  <h2>Rédaction d'un message - Syntaxe</h2>
  <p>Il n'est pas possible d'utiliser directement de l'html dans les messages, pour des raisons évidentes (cohérence de la présentation, validité du code ...) mais des mises en forme sont disponible afin de rendre les messages plus lisibles. La syntaxe des balises est simple : le signe <span class="commande">#</span> suivi du nom de la balise, puis entre accolades le texte auquel s'applique la balise. Les balises suivantes sont disponibles (la liste peut s'allonger selon les besoins) :</p>
  <ul>
  <li><span class="commande">#url{ adresse }</span> permet de créer un lien</li>
  <li><span class="commande">#comment{ texte }</span> permet d'écrire un commentaire (plutôt utilisé dans la balise code)</li>
  <li><span class="commande">#commande{ texte }</span> permet de mettre en valeur une commande</li>
  <li><span class="commande">#title{ texte }</span> permet de faire un titre de section</li>
  <li><span class="commande">#subtitle{ texte }</span> permet de faire un titre de sous section</li>
  <li><span class="commande">#picture{ fichier [,texte] }</span> permet d'afficher une image en spécifiant éventuellement un texte alternatif</li>
  <li><span class="commande">#code{ texte }</span> permet d'écrire du code source</li>
  <li><span class="commande">#closing_brace</span> permet d'écrire une accolade fermante "}" dans une balise (au lieu de fermer la balise)</li>
  </ul>
<?php
  bottom();
?>
