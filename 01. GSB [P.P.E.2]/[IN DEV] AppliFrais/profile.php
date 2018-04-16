<?php
/**
 *
 * @author RAZE Rémi
 * @date 10/03/2018
 * 
 */

$repInclude = './Include/';
require($repInclude . '_initialisation.inc.php');

/*
 * La page est inaccessible si le visiteur ou le comptable n'est pas connecté
 */
//if ( !estVisiteurConnecte() || !estComptableConnecte())  {
//    header("Location: identification.php");
//}

$repInclude = './Include/';
require($repInclude . "_initialisation.inc.php");
?>
    	<!-- Division principale -->
	<div id="contenu">
    	<h2>Bienvenue sur l'intranet GSB</h2>
	</div>
<?php
if (lireDonnee('Visiteur')) { // un Visiteur demande à s'authentifier
    // acquisition des données envoyées, ici login et mot de passe
    
//    require($repInclude . "_sommaire.inc.php");
   
    $etape = (count($_POST) != 0) ? 'afficherInfos' : 'changerInfos';
    
    if ($etape == 'afficherInfos')	{
        ?>
        <div id="afficherInfos">
        	<table>
        		<tr>
        			<th>Libellé :</th>
        			<th>Données fournies</th>
        		</tr>
        		<tr>
        			<td><h4>Nom :</h4>
        			<td><p><?php afficherNomUser(); ?></p></td>
        			<td><input type="button" name="Changer" title="Changer"></td>
        		</tr>
        		<tr>
        			<td><h4>Nom :</h4>
        			<td><p><?php afficherNomUser(); ?></p></td>
        			<td><input type="button" name="Changer" title="Changer"></td>
        		</tr>
        		<tr>
        			<td><h4>Prénom :</h4>
        			<td><p><?php afficherPrenomUser(); ?></p></td>
        			<td><input type="button" name="Changer" title="Changer"></td>
        		</tr>
        		<tr>
        			<td><h4>Adresse :</h4>
        			<td><p><?php afficherAdresseUser(); ?></p></td>
        			<td><input type="button" name="Changer" title="Changer"></td>
        		</tr>
        		<tr>
        			<td><h4>Ville :</h4>
        			<td><p><?php afficherVilleUser(); ?></p></td>
        			<td><input type="button" name="Changer" title="Changer"></td>
        		</tr>
        		<tr>
        			<td><h4>Code Postal :</h4>
        			<td><p><?php afficherCpUser(); ?></p></td>
        			<td><input type="button" name="Changer" title="Changer"></td>
        		</tr>
        		<tr>
        			<td><h4>E-mail personnel :</h4>
        			<td><p><?php afficherMailPersoUser(); ?></p></td>
        			<td><input type="button" name="Changer" title="Changer"></td>
        		</tr>
        		<tr>
        			<td><h4>Nom :</h4>
        			<td><p><?php afficherNomUser(); ?></p></td>
        			<td><input type="button" name="Changer" title="Changer"></td>
        		</tr>
        		<tr>
        			<td><h4>Nom :</h4>
        			<td><p><?php afficherNomUser(); ?></p></td>
        			<td><input type="button" name="Changer" title="Changer"></td>
        		</tr>
        		
        	</table>
        </div>
        
        <?php
    }
}
elseif (lireDonnee('Comptable')) { // un Visiteur demande à s'authentifier
    // acquisition des données envoyées, ici login et mot de passe

  

}
else {
    echo("\n"."Condition else"."\n");
}


require($repInclude . "_fin.inc.php");
?>