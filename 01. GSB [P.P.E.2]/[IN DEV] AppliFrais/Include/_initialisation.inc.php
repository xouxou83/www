<?php

/**
 *  Initialisation des ressources necessaires au fonctionnement
 * @package GSB-AppliFrais
 * @author x@ux@u   (basé sur )
 * @projet Gsb-AppliFrais
 * @todo RAS
 */


$repInclude = './Include/';
$repIncludeVisiteur = './Include/Visiteur/';
$repIncludeComptable = './Include/Comptable/';
$repIncludeMessagerie = '../Include/';

if ( $_SERVER['PHP_SELF'] == '/GSB-New-App/Messagerie/boiteReception.php' or
     $_SERVER['PHP_SELF'] == '/GSB-New-App/Messagerie/consulterMail.php' or
     $_SERVER['PHP_SELF'] == '/GSB-New-App/Messagerie/nouveauMail.php')   {
    require($repIncludeMessagerie .'_gestionBDD.lib.php');
    require($repIncludeMessagerie .'_gestionSession.lib.php');
    require($repIncludeMessagerie .'_utilitairesEtGestionErreurs.lib.php');
}
else     {
    require($repInclude .'_gestionBDD.lib.php');
    require($repInclude .'_gestionSession.lib.php');
    require($repInclude .'_utilitairesEtGestionErreurs.lib.php');
    //require($repInclude .'_gestionErreursEtUtilitaire.lib.php');
}

/*
 * Appel de la fonction permettant :
 *   de limiter le temps de session
 *   d'ouvrir une session
 *   source: gestionBDD.lib.php
 */
configEtOuvertureSession();

/*
 * Creation du tableau d'enregistrement des erreurs:
 */
$tabErreurs = array();

/*
 * Systeme pour demande de deconnexion:
 */
$Deconnexiondemandee = lireDonneeUrl("cmdDeconnecter");
if ( $Deconnexiondemandee == "on" )     {
    deconnecter();
    session_destroy();
    header("Location: identification.php");
}

/*
 * Connexion a la base de donnees
 */
$idConnexion = connecterServeurBD();
if ( !$idConnexion )    {
    ajouterErreur( $tabErr, "Echec de la connexion a la base de donnees");
}
elseif (!activerBD( $idConnexion )) {
    ajouterErreur( $tabErreurs, "La base de donnees gsb-applifrais est non accessible ou inexistante");
}

identifierPostUser();

if ( $_SERVER['PHP_SELF'] == '/GSB-New-App/Messagerie/boiteReception.php' or
     $_SERVER['PHP_SELF'] == '/GSB-New-App/Messagerie/consulterMail.php' or
     $_SERVER['PHP_SELF'] == '/GSB-New-App/Messagerie/nouveauMail.php')   {
    require($repInclude . '_entete.inc.html');
    
    if (estVisiteurConnecte() || estComptableConnecte())	{
        require(".".sommaireUser());		//=> Charge le sommaire correspondant
    }									// si un utilisateur est connecte
    
    //=> Charge la page de mise en forme selon les pages demandées
    require($repIncludeMessagerie . '_titreDePage.inc.php'); 
}
else    {
    require($repInclude . '_entete.inc.html');
    
    if (estVisiteurConnecte() || estComptableConnecte())	{
    require(sommaireUser());		//=> Charge le sommaire correspondant
    }									// si un utilisateur est connecte
    
    //=> Charge la page de mise en forme selon les pages demandées
    require($repInclude . '_titreDePage.inc.php'); 
}
?>

