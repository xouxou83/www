<?php
/** 
 * Initialise les ressources necessaires au fonctionnement de l'application
 * @package default
 * Modifie par x0ux0u
 */
    $repInclude = './Include/';
  require($repInclude . "_bdGestionDonnees.lib.php");
  require($repInclude . "_gestionSession.lib.php");
  require($repInclude . "_utilitairesEtGestionErreurs.lib.php");
     // demarrage ou reprise de la session
  initSessionComptable();
     // initialement, aucune erreur ...
  $tabErreurs = array();
  
     // demande-t-on une deconnexion ?
  $demandeDeconnexion = lireDonneeUrl("cmdDeconnecter");
  if ( $demandeDeconnexion == "on") {
      deconnecterComptable();
      header("Location: identification.php");
  }
    
     // etablissement d'une connexion avec le serveur de donnees 
     // puis selection de la BD qui contient les donnees des visiteurs et de leurs frais
  $idConnexion = connecterServeurBDComptable();
  if (!$idConnexion) {
      ajouterErreur($tabErreurs, "Echec de la connexion au serveur MySql");
  }
  elseif (!activerBDComptable($idConnexion)) {
      ajouterErreur($tabErreurs, "La base de donnees gsb-appfrais est inexistante ou non accessible");
  } 
?>