<?php

/**
 * @package GSB-AppliFrais
 * @author x@ux@u   (basé sur )
 * @projet Gsb-AppliFrais
 * @todo RAS
 */

$repInclude = '../Include/';
$repIncludeMessagerie = './Include/';
require($repInclude . '_initialisation.inc.php');
require($repInclude . '_messagerieGsb.lib.php');
obtenirMailExpe($idConnexion);
?>
<form id="NewMail" action="" method="post">
<!--	    <p>
				<input type="hidden" name="etape" id="etape" value="validerConnexion" />
			</p>
			<p>	
				<label for="expediteurNouveauMail" accesskey="e"> Expediteur : </label>
				<input type="email" id="expediteurNouveauMail" value="<?php obtenirMailExpe($idConnexion); ?>"/>
			</p>
-->
			<p>
				<label for="destinataireNouveauMail" accesskey="a">A* : </label>
				<input type="email" id="destinataireNouveauMail" title="Entrez le destinataire de votre message" value="" />
			</p>

			<p>	
				<label for="copieCarboneNouveauMail" accesskey="c">CC : </label>
				<input type="email" id="copieCarboneNouveauMail" title="Entrez les contacts pour qu'ils aient une copie de votre message.  " value="" />
			</p>
			<p>		
				<label for="copieCarboneInvNouveauMail" accesskey="d">CCi : </label>
				<input type="email" id="copieCarboneInvNouveauMail" title="Entrez les contacts dont vous ne souhaiter pas informer les autres." value="" />
			<p>	
</form>
			</p>	
				<label for="objetNouveauMail" accesskey="o">Objet* : </label>
				<input type="text" id="objetNouveauMail" title="Entrez l'objet de votre message" value="" />
			</p>
			<p>	
				<input type="text" id="contenuNouveauMail" placeholder="Veuillez écrire votre message ici ... " value="" />
			</p>
			<p>	
				<label for="pieceJointeNouveauMail" accesskey="p">Joindre : </label>
				<input type="file" id="pieceJointeNouveauMail" title="Cliquez pour choisir un fichier à joindre à votre message" value="" />
			</p>
		
		<div class="piedForm">
    		<p>
        		<input class="boutonV" type="submit" id="envoi" value="Envoyer" />
        		<input class="boutonV" type="reset" id="annuler" value="Annuler" />
    		</p> 
		</div>

<?php 
    require ($repInclude . '_fin.inc.php');       // Mettre un panneau de gestion de police
?>