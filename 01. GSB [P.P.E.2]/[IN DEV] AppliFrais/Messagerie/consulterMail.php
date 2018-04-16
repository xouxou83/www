<?php

/**
 * @package GSB-AppliFrais
 * @author x@ux@u   (basé sur )
 * @projet Gsb-AppliFrais
 * @todo RAS
 */

$repInclude = '../Include/';
$repIncludeMessagerie = "./Include/";

require ($repIncludeMessagerie . '_messagerieGsb.lib.php');
require ($repInclude . '_entete.inc.html');

$idConnexion = connexionServeurMessagerie();
$mailChoisit = array();
$mailChoisit['expediteur'] = $_POST['expediteur'];
$mailChoisit['objet'] = $_POST['objet']; 
$mailChoisit['date'] = $_POST['date'];

$donneesMail = afficherMail($mailChoisit, $idConnexion);
?>

<p> <?php print_r($donneesMail); ?> </p>

