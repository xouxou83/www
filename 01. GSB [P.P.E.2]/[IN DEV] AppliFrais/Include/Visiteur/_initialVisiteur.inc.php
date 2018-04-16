<?php
/** 
 * Initialise les ressources necessaires au fonctionnement de l'application
 * @package default
 * @todo  RAS
 */
  $repInclude = './Include/';
  require($repInclude."_gestionBDD.lib.php");
  require($repInclude."_gestionSession.lib.php");
  require($repInclude."_utilitairesEtGestionErreurs.lib.php");
  
//  demarrage ou reprise de la session
  initSessionVisiteur();

//  initialement, aucune erreur ...
  $tabErreurs = array();

// demande-t-on une deconnexion ?
  $demandeDeconnexion = lireDonneeUrl("cmdDeconnecter");
  if ( $demandeDeconnexion == "on") {
      deconnecterVisiteur();
      header("Location: identification.php");
  }
    
/* etablissement d'une connexion avec le serveur de donnees 
 * puis selection de la BD qui contient les donnees des visiteurs et de leurs frais
 */
 $idConnexion = connecterServeurBDVisiteur();
  if (!$idConnexion) {
      ajouterErreur($tabErreurs, "Echec de la connexion au serveur MySql");
  }
  elseif (!activerBDVisiteur($idConnexion)) {
      ajouterErreur($tabErreurs, "La base de donnees gsb-applifrais-Visiteur est inexistante ou non accessible");
  } 
?>