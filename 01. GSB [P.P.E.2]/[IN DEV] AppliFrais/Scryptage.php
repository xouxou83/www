<?php
/**
 * Page permettant la copie de la base de donnee GSB vers Centre_de_sauvegarde_GSB
 * @author RAZE Remi
 * @date 09/04/2018
 * @TODO RAS
 *
 */

$repInclude = './include/';
require($repInclude . "_initialisation.inc.php");

//=> page inaccessible si visiteur non connecte
/*if ( ! estVisiteurConnecte() ) {
    header("Location: identification.php");
}
*/
$nomDeTable = array("visiteur","comptable");

$idConnexion = connecterServeurBD();
$idConnexionSave = connecterServeurBDSave();
foreach ($nomDeTable as $nom)   {
    $requeteExport = "'SELECT id, mdp FROM '".$nom.'"';
    $idJeu = $idConnexion -> prepare($requeteExport);
    $export = FALSE;
    $idJeu -> execute();

    if ( $idJeu != NULL) {
        $export = $idJeu -> fetchAll();
    }
    print_r($export);

    $requeteImport = "'UPDATE id, mdp FROM visiteur'".$nom.'"';
    $idJeuSave = $idConnexionSave -> prepare($requeteImport);
    $idJeuSave -> execute();
    print($idJeuSave);
}
