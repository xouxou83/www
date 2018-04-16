<?php
/*
 * Page d'identification des utilisateurs
 * @package GSB-AppliFrais
 * @author x@ux@u   (basé sur )
 * @projet Gsb-AppliFrais
 * @todo RAS
 */

$repInclude = './include/';
$repIncludeVisiteur = './Include/Visiteur/';
require($repInclude . "_initialisation.inc.php");

if (count($_GET) == 0) {
    ?>
    <form id="choixIdentification" action="identification.php" method="get">
    	<p>
        	<input class="bouton" type="submit" name="User" value="Visiteur" />
        	<input class="bouton" type="submit" name="User" value="Comptable" />
    	</p>
    </form>
    
    <?php
} 
else {

    $etape = (count($_POST) != 0) ? 'validerConnexion' : 'demanderConnexion';

    if ($etape == "validerConnexion") { // un client demande à s'authentifier
        // acquisition des donnees envoyees, ici login et mot de passe
        $unLogin = lireDonneePost("IdLogin");
        $unMdp = lireDonneePost("IdMdp");
        if (lireDonneeUrl('User') == "Visiteur") {
            $lgUser = verifierInfosConnexionVisiteur($idConnexion, $unLogin, $unMdp);
        }
        if (lireDonneeUrl('User') == "Comptable") {
            $lgUser = verifierInfosConnexionComptable($idConnexion, $unLogin, $unMdp);           
        }
        // si l'id utilisateur a ete trouve, donc informations fournies sous forme de tableau
        if (is_array($lgUser)) {
            affecterInfosConnecte($lgUser["id"], $lgUser["login"]);
        } else {
            ajouterErreur($tabErreurs, "Pseudo et/ou mot de passe incorrects");
        }
    }
    if ($etape == "validerConnexion" /*&& nbErreurs($tabErreurs) == 0*/) {
        if (lireDonneeUrl('User') == "Visiteur") {
            header("Location:Accueil.php?User=Visiteur");
        }
        if (lireDonneeUrl('User') == "Comptable") {
            header("Location:Accueil.php?User=Comptable");
        }
    }

    if ($etape == "validerConnexion") {
        if (nbErreurs($tabErreurs) > 0) {
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
                    <input class="boutonV" type="submit" id="ok" value="Valider" />
                    <input class="boutonV" type="reset" id="annuler" value="Effacer" />
                </p> 
            </div>
        </form>
    <?php
}
require($repInclude . "_fin.inc.php");
?>
