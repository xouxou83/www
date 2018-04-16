<?php
/*
 * Page d'identification des utilisateurs
 * @package default
 * @todo RAS
 */
$repInclude = './include/';
$repIncludeVisiteur = './Include/Visiteur/';
require($repInclude."_initialisation.inc.php");

$etape = (count($_POST) != 0 ) ? 'validerConnexion' : 'demanderConnexion';
	
if ($etape == 'validerConnexion') { // un client demande à s'authentifier
    // acquisition des donnees envoyees, ici login et mot de passe
    $login = lireDonneePost("IdLogin");
    $mdp = lireDonneePost("IdMdp");
    $lgUser = verifierInfosConnexion($idConnexion, $login, $mdp);
    // si l'id utilisateur a ete trouve, donc informations fournies sous forme de tableau
    if ( is_array($lgUser) ) {
        affecterInfosConnecte($lgUser["id"], $lgUser["login"]);
    }
    else {
        ajouterErreur($tabErreurs, "Pseudo et/ou mot de passe incorrects");
    }
}
if ( $etape == "validerConnexion" && nbErreurs($tabErreurs) == 0 ) {
    header("Location:Accueil.php");
}

	require($repInclude . "_entete.inc.html");
?>

<!-- Division pour le contenu principal -->
    <div id="contenu">
    	<h2>Identification utilisateur</h2>
<?php
          if ( $etape == "validerConnexion" )   {
              if ( nbErreurs($tabErreurs) > 0 ) {
                echo toStringErreurs($tabErreurs);
              }
          }
?>
	<form id="frmConnexion" action="" method="post">
    	<div class="corpsForm">
        	<input type="hidden" name="etape" id="etape" value="validerConnexion" />
      			<p>
        			<label for="IdLogin" accesskey="n"> Login* : </label>
        			<input type="text" id="IdLogin" name="IdLogin" maxlength="20" size="15" value="" title="Entrez votre login" />
      			</p>
      			<p>
        			<label for="IdMdp" accesskey="m"> Mot de passe* : </label>
        			<input type="password" id="IdMdp" name="IdMdp" maxlength="8" size="15" value="" title="Entrez votre mot de passe"/>
      			</p>
      	</div>
      	<div class="piedForm">
      		<p>
        		<input type="submit" id="ok" value="Valider" />
        		<input type="reset" id="annuler" value="Effacer" />
      		</p> 
      	</div>
    </form>
<?php
	require($repInclude."_pied.inc.html");
	require($repInclude . "_fin.inc.php");
?>