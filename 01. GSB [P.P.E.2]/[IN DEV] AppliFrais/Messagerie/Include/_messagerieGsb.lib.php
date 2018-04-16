<?php

/*
 * Librairie des fonctions pour le chat gsb et la gestion de la base de donnee (PDO)
 * Permet de demander conseil a un comptable disponible
 * @package GSB-AppliFrais
 * @author x@ux@u   (basé sur )
 * @projet Gsb-AppliFrais
 * @todo RAS
 */

/**
 * Fonction de connexion a la base de donnees GSB pour la messagerie
 * @param none
 * @return $idConnexionMessagerie          => Variable contenant les informations de connexion
 */
function connexionServeurMessagerie() {
    $idConnexionMessagerie = new PDO('mysql:host=localhost;dbname=gsb-applifrais-messagerie', 'root', '');
    return $idConnexionMessagerie;
}


/**
 * Fonction afficher la boite de reception, chargement des differentes lignes depuis la base de donnees
 * @param resource $idConnexionMessagerie         => Variable contenant les informations de connexion
 * @return array $boiteReception          => Variable contenant les informations de la requete
 */
function ouvertureBoiteReception($idConnexionMessagerie)  {
    $requete = "'SELECT (idMail, expediteur, objet, date, piecejointe) FROM boitereception ORDER BY 'date' WHERE destinataire=";
    filtrerChainePourBD($requete, $idConnexionMessagerie);
    
    $idConnexionMail = $idConnexionMessagerie -> prepare($requete);
    $idConnexionMessagerie -> query($requete);
    
    $boiteReception = array();
    $compteurDeLigne = 0;
    while ($reponse = $idConnexionMail -> fetch(PDO::FETCH_ASSOC))   {
        $compteurDeLigne++;        //$idMail, $expediteur, $pieceJointe, $objet, $date
        $idMail = $reponse['idmail'];
        ${"mail_" . $idMail} = array();
        for ($nbChamps = 0; $nbChamps <= 3; $nbChamps++)   {
            ${"mail_" . $idMail}['expediteur'] = $reponse['expediteur'];
            ${"mail_" . $idMail}['piecejointe'] = $reponse['piecejointe'];
            ${"mail_" . $idMail}['objet'] = $reponse['objet'];
            ${"mail_" . $idMail}['date'] = $reponse['date'];
            array_push($boiteReception, ${"mail_" . $idMail});
        }
        
    return $boiteReception;
    } 
}
    //      ${"mail_expediteur_" . $idMail}
    //      ${"skin" . $n};               => Creer un nom de variable
    
/**
 * Fonction affichage d'un Email
 * @param resource $idConnexionMessagerie         => Variable de ressources contenant les informations de connexion
 * @param String $idMail                  => Variable de chaine de caracteres contenant l'identifiant de l'E-mail a afficher
 * @return resource $reponse              => Variable de ressources contenant les informations obtenue par la requete SQL
 */
function afficherMail($idMail, $idConnexionMessagerie)    {
    $requete = "'SELECT (contenu, destinataire, copiecarbone) FROM boitereception WHERE idmail='".$idMail."'";
    filtrerChainePourBD($requete, $idConnexionMessagerie);
    $reponse = $idConnexionMessagerie -> query($requete);
    return $reponse;
}
    
    
/**
 * Fonction pour l'envoie d'un nouvel Email
 * @param resource $idConnexionMessagerie         => Variable contenant les informations de connexion
 * @return resource $reponse              => Variable de ressources contenant les informations obtenue par la requete SQL
 */
function envoyerMail($idConnexionMessagerie)  {      //   INSERT INTO `boitereception` (`expediteur`, `destinataire`, `objet`, `date`, `piecejointe`) VALUES ('20fev18-08:46-1', 'xouxou@live.com', 'remi.raze83@gmail.com', 'demande de resilliation d\'abonnement livebox', '2018-02-20 09:00:00', '0');
    $requete = "'INSERT INTO messagerie VALUES('".$Expediteur."','".$Destinataire."','".$Cc."','".$CcI."','".$Objet."','".$Contenu."','".$PieceJointe."','".$Date."','".$Taille."')";
    filtrerChainePourBD($requete, $idConnexionMessagerie);
    $reponse = $idConnexionMessagerie -> query($requete);
    return $reponse;
}


/**
 * Fonction de filtrage des requetes pour la base de donnees
 * @param resource $idConnexionMessagerie         => Variable contenant les informations de connexion
 * @param String $requete                 => Variable de chaine de caractere contenant la requete SQL a echaper
 * @return String $requete                => Variable de chaine de caractere contenant la requete SQL echapee
 */
function creationIdMail($idConnexionMessagerie, $donneesMail)  {
    $idMail = "'".date(d).date(M).date(y)."-".time()."-".rand(0, 99)."'";
    return $idMail;
}


/**
 * Fonction de filtrage des requetes pour la base de donnees
 * @param resource $idConnexionMessagerie         => Variable contenant les informations de connexion
 * @param String $requete                 => Variable de chaine de caractere contenant la requete SQL a echaper
 * @return String $requete                => Variable de chaine de caractere contenant la requete SQL echapee
 */
function obtenirMailExpe($idConnexionMessagerie)  {
    $idUser = obtenirIdUserConnecte();
    $lgUser = obtenirDetailVisiteur($idConnexionMessagerie, $idUser);
    $nom = $lgUser['nom'];
    $prenom = $lgUser['prenom']; 
    $requete = "SELECT email FROM visiteur WHERE nom='".$nom."' AND prenom='".$prenom."'";
    $eMail = $idConnexionMessagerie -> prepare($requete);
    $ligne = FALSE;
    $eMail -> execute();

    if ( $eMail ) {
        $ligne = $eMail -> fetch(PDO::FETCH_ASSOC);
    }
    $eMail -> closeCursor();
    if ( $ligne ) {
        return $ligne;
    }
    elseif  ( $ligne == FALSE ) { 
        $requeteUne = "SELECT login FROM visiteur WHERE nom='".$nom."' AND prenom='".$prenom."'";
        $trouverLogin = $idConnexionMessagerie -> prepare($requeteUne);
        $login = FALSE;
        $trouverLogin -> execute();
        
        if ($trouverLogin) {
            $login = $trouverLogin -> fetch();
        }
        $trouverLogin -> closeCursor();
        
        $newMail = $login . "@gsb-app.pv";
        $requeteDeux = "INSERT INTO visiteur VALUES email='".$newMail."' WHERE nom='".$nom."' AND prenom='".$prenom."'";
        $envoyerNewMail = $idConnexionMessagerie -> prepare($requeteDeux);
        $envoie = FALSE;
        $envoyerNewMail -> execute();
        
        if ($envoyerNewMail) {
            $envoye = $envoyerNewMail -> fetch();
        }
        $envoyerNewMail -> closeCursor();
        return $newMail;
    }
}

?>