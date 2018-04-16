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


$idConnexionMessagerie = connexionServeurMessagerie();
$boiteReception = ouvertureBoiteReception($idConnexionMessagerie);

?>
<form id="BandeauBoiteReception" action="nouveauMail.php">
	<input class="boutonM" type="Submit" name="nouveauMail" value="nouveau"/>
</form>
	<div id="ListeMailReception">
		<table>
  			<tr>
    			<th id="Expediteur">Expéditeur</th>
    			<th id="Objet">Objet</th>
    			<th id="Date">Date</th>
  			</tr>
  		</table>
<?php 
	    if ($boiteReception != NULL || FALSE) {
		  for ($compteur = 1; $compteur <=30; $compteur++)   {
            $idDiv = "ListeMailReception" . "$compteur";    ?>
       			<table id="<?php "$idDiv"; ?>">
       				<tr>
       				  	<form action="consulterMail.php" method="post">
							<td><input type="submit" name="expediteur" value=" <?php echo($boiteReception[$compteur]['expediteur']); ?> "></td>
							<td><input type="submit" name="objet" value=" <?php echo($boiteReception[$compteur]['objet']); ?> "></td>
							<td><input type="submit" name="date" value=" <?php echo($boiteReception[$compteur]['date']); ?> "></td>
						</form>
					</tr>
					
				</table>
<?php 
           } 
        }
        elseif ($boiteReception == NULL)	{
            ?><p><?php echo("Vous n'avez pas encore reçu de message...");?></p><?php 
        }
        else {
            ?><p><?php echo("Une erreure est survenue, veuillez réessayer...");?></p><?php
	    }
	?></div><?php
require ($repIncludeMessagerie . '_fin.inc.php');
?>