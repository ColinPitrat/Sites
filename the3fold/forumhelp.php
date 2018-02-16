<?php
  require("./include/ident.php");
?>
  <h1>Utilisation du forum</h1>
  <h2>R�gles d'utilisation du forum</h2>
  <p>Le forum est destin� � l'�change de savoir et d'id�es entre les utilisateurs. Il est cependant soumis � certaines r�gles d'utilisation.</p>
  <p>Le forum est organis� en salons, qui d�finissent un th�me de discussion. Les messages ne correspondant pas au th�me du salon dans lequel ils sont post�s pourront �tre supprim�s. De m�me, les messages contenant des propos racistes, homophobes ... mais aussi les messages trollesques ou publicitaires seront censur�s. Enfin, les messages r�dig�s dans un langage incompr�hensible (style SMS, nombreuses fautes de fran�ais, informations erron�es) ne sont pas non plus les bienvenus.</p>
  <p>A noter que certaines discussions sont �pingl�es, c'est � dire disponibles sans avoir � s'identifier. Le th�me de ces discussions est d�limit� pr�cis�ment. Les r�gles ci-dessus s'appliquent de mani�re encore plus stricte.</p>
  <h2>R�daction d'un message - Syntaxe</h2>
  <p>Il n'est pas possible d'utiliser directement de l'html dans les messages, pour des raisons �videntes (coh�rence de la pr�sentation, validit� du code ...) mais des mises en forme sont disponible afin de rendre les messages plus lisibles. La syntaxe des balises est simple : le signe <span class="commande">#</span> suivi du nom de la balise, puis entre accolades le texte auquel s'applique la balise. Les balises suivantes sont disponibles (la liste peut s'allonger selon les besoins) :</p>
  <ul>
  <li><span class="commande">#url{ adresse }</span> permet de cr�er un lien</li>
  <li><span class="commande">#comment{ texte }</span> permet d'�crire un commentaire (plut�t utilis� dans la balise code)</li>
  <li><span class="commande">#commande{ texte }</span> permet de mettre en valeur une commande</li>
  <li><span class="commande">#title{ texte }</span> permet de faire un titre de section</li>
  <li><span class="commande">#subtitle{ texte }</span> permet de faire un titre de sous section</li>
  <li><span class="commande">#picture{ fichier [,texte] }</span> permet d'afficher une image en sp�cifiant �ventuellement un texte alternatif</li>
  <li><span class="commande">#code{ texte }</span> permet d'�crire du code source</li>
  <li><span class="commande">#closing_brace</span> permet d'�crire une accolade fermante "}" dans une balise (au lieu de fermer la balise)</li>
  </ul>
<?php
  bottom();
?>
