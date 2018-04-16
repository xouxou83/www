<?php
/** 
 * Libere les ressources necessaires au fonctionnement de l'application
 * @package GSB-AppliFrais
 * @author x@ux@u   (basé sur )
 * @projet Gsb-AppliFrais
 * @todo RAS
 */

?>		</div>	<?php     //=> Fin div "contenu"
?>	</div>	<?php     //=> Fin div "page"

$repInclude = './Include/';
$repIncludeMessagerie = '../Include/';

if ($_SERVER['PHP_SELF'] == '/GSB-New-App/Messagerie/boiteReception.php' ||
    $_SERVER['PHP_SELF'] == '/GSB-New-App/Messagerie/consulterMail.php'  ||
    $_SERVER['PHP_SELF'] == '/GSB-New-App/Messagerie/nouveauMail.php')   {
    require($repIncludeMessagerie . "_pied.inc.html");
}
else    {
    require($repInclude . "_pied.inc.html");	//=> Charge le pied de page        
}

identifierPostUser();

deconnecterServeurBD($idConnexion);			//=> Libere la connexion au serveur BDD

?>