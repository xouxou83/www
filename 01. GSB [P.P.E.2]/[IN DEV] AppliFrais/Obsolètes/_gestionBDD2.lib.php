<?php
/*
 * Librairie des fonctions pour la gestion de la base de donnee (PDO)
 * @ By x@ux@u
 */
   

                       /*_____FONCTIONS__CONNEXIONS__UTILISATEURS__ET__CONNEXIONS__BDD_____*/
/*
 * Fonction de connexion au serveur BD en PDO, afin de facilite la compatibilitee 
 * @param none
 * @return resource $idConnexion
 */

function connecterServeurBD()   {
    try {
        $idConnexion = new PDO('mysql:host=localhost;dbname=gsb-applifrais;charset=utf8', 'root', '');
        $idConnexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
    catch (Exception $e) {
        die('Erreur : ' . $e -> getMessage());
    }
    return $idConnexion;
}


/*
 * Fonction de connexion au serveur BD en PDO pour la sauvegarde des donnees.
 * @param none
 * @return resource $idConnexionSave
 */
function connecterServeurBDSave()   {
    try {
        $idConnexionSave = new PDO('mysql:host=localhost;dbname=gsb-centre-sauvegarde;charset=utf8', 'root', '');
        $idConnexionSave -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
    catch (Exception $d) {
        die('Erreur : ' . $d -> getMessage());
    }
    return $idConnexionSave;
}


/**
 * SELECTionne (rend active) la base de donnees.
 * SELECTionne (rend active) la BD predefinie gsb_frais sur la connexion
 * identifiee par $idConnexion. Retourne true si succes, FALSE sinon.
 * @param resource $idConnexion identifiant de connexion
 * @return boolean succes ou echec de SELECTion BD
 */
function activerBD($idConnexion) {
    $requete = "SET CHARACTER SET utf8";
    $reponse = $idConnexion -> query($requete);
    return $reponse;
}


/*
 * Fonction de changement de la duree de vie d'une session
 * @param none
 * @return boolean         => Indique l'ouverture de session
 */
function configEtOuvertureSession()    {
    $ttl = 1800; // Une heure, en secondes
    $local_sessions_save_path = ini_get('session.save_path').'/sessionGSB';
    
    session_set_cookie_params($ttl);
    ini_set('session.gc_maxlifetime', $ttl);
    ini_set('session.save_path', $local_sessions_save_path);
    return session_start();
}


/*
 * Fonction de deconnexion de la base de donnees
 * @param resource $idConnexion
 * @return resource $idConnexion
 */
function deconnecterServeurBD($idConnexion) {
    $idConnexion = NULL;
    return $idConnexion;
}


/*
 * Fonction de filtrage des chaines pour les requetes SQL
 * @param string $str
 * @param resource $idConnexion
 * @return string $str          => Renvoie la chaine filtree pour la base de donnees
 */
function filtrerChainePourBD($str, $idConnexion)  {
    if ( ! get_magic_quotes_gpc() ) {
        $idConnexion -> quote($str);
    }
    return $str;
}


/**
 * Fonction de cryptage avec $salt realise par x0ux0u
 * @param string $unMdp         ==> Mot de passe en clair
 * @return string $crypted      ==> Mot de passe crypte
 */
function cryptage($unMdp)	{
    if (strlen($unMdp)!= 0) {
        $Mdp = "$unMdp";
        $var = rAND(0,9).$Mdp[0];
        $salt = "";
        for ($x=0; $x <= (strlen($Mdp)-1); $x++)	{
            for ($y = (strlen($Mdp)-1); $y >= 0; $y--)	{
                $salt = $salt . $var . ord($Mdp[$x]) % ord($Mdp[$y]);
            }
        }
        $crypted = crypt($Mdp, $salt);
    return $crypted;
    }
    else    {
        return $unMdp;
    }
}

/*
 * Fonction permettant le cryptage des mot de passe deja presents dans la base de donnees
 * @param resource $idConnexion
 * @return
 */
function cryptageBDD($idConnexion)  {
    $requete_import = 'SELECT mdp FROM visiteur';
    
}


/**
 * Controle les informations de connexionn de l'utilisateur.
 * Verifie si les informations de connexion $unLogin, $unMdp sont ou non valides.
 * Retourne les informations de l'utilisateur sous forme de tableau associatif
 * dont les cles sont les noms des colonnes (id, nom, prenom, login, mdp)
 * si login et mot de passe existent, le booleen FALSE sinon.
 * @param resource $idConnexion identifiant de connexion
 * @param string $unLogin login
 * @param string $unMdp mot de passe
 * @return array tableau associatif ou booleen FALSE
 */
function verifierInfosConnexion($idConnexion, $unLogin, $unMdp) {
    $unLogin = filtrerChainePourBD($unLogin, $idConnexion);
    $unMdp = filtrerChainePourBD($unMdp, $idConnexion);
    
    // le mot de passe est crypte dans la base avec la fonction crypt() et un salt pour chaque utilisateurs
    if ($unLogin != NULL AND $unMdp != NULL) {
        $requeteVisiteur = "SELECT id, nom, prenom, login, mdp FROM visiteur WHERE login='".$unLogin."' AND mdp='" . $unMdp . "'";
        $resultatsVisiteur = $idConnexion -> prepare($requeteVisiteur);
        $resultatsVisiteur -> execute();
        $ligne = FALSE;
        
        while ($ligne = $resultatsVisiteur -> fetch(PDO::FETCH_ASSOC)) {
            var_dump($ligne); 
            
            if ($ligne != NULL AND $ligne != FALSE) {
                ?><form method="get"><input type="hidden" name="Visiteur" id="Visiteur" value="Visiteur" /></form><?php
                $idConnexion -> closeCursor();
            }
        }  
        return $ligne;
    }
    elseif ($ligne == NULL or $ligne == FALSE) { 
        $requeteComptable = "SELECT (id, nom, prenom, login, mdp) FROM comptable WHERE login='".$unLogin."' AND mdp='" . $unMdp . "'";
        $resultatsComptable = $idConnexion -> prepare($requeteComptable);
        $resultatsComptable -> execute();
        $ligne = FALSE;
        
        while ($ligne = $resultatsComptable -> fetch(PDO::FETCH_ASSOC)) {
            
            if ($ligne != NULL && $ligne != FALSE) {
                ?><form method="get"><input type="hidden" name="Comptable" id="Comptable" value="Comptable" /></form><?php
                $idConnexion -> closeCursor();
            }
        }
        return $ligne;
    }
}
 
/*    $ligne = FALSE;
    if ( $idJeuRes ) {
        $ligne = mysql_fetch_assoc($idJeuRes);
        mysql_free_result($idJeuRes);
    }
    return $ligne;
    $etape = (count($_GET) != 0) ? 'Visiteur' : 'Comptable';
    
    if  ($idJeuResVisiteur -> execute())    {
        ?><form method="get"><input type="hidden" name="etape" id="etape" value="Visiteur" /></form><?php 
        $ligne = FALSE;
        do {
            while ($donnee = $idJeuResVisiteur -> fetch());
                if (!$idJeuResVisiteur -> nextRowset());
                    break;
        } while (true);
        
        return $ligne;
    }
    elseif ($idJeuResComptable -> execute())    {
        ?><form method="get"><input type="hidden" name="etape" id="etape" value="Comptable" /></form><?php
        $ligne = FALSE;
        do {
            while ($donnee = $idJeuResComptable -> fetch());
                if (!$idJeuResComptable -> nextRowset());
                    break;
        } while (true);
    
        return $ligne;
    }
}
   */ 
/*              EXEMPLE INDICATIF
$sth = $dbh->prepare("SELECT nom, couleur FROM fruit");
$sth->execute();

/* Recuperation de toutes les lignes d'un jeu de resultats *//*
$result = $sth->fetchAll();
print_r($result);


while ($donnees = $reponse->fetch())
{
    echo $donnees['Num'] . '<br />';
}
   
$reponse->closeCursor();

*/
/**
 * Fournit les informations sur un visiteur demande.
 * Retourne les informations du visiteur d'id $unId sous la forme d'un tableau
 * associatif dont les cles sont les noms des colonnes(id, nom, prenom).
 * @param resource $idConnexion identifiant de connexion
 * @param string $unId id de l'utilisateur
 * @return array  tableau associatif du visiteur
 */
function obtenirDetailVisiteur($idConnexion, $unId) {
    $id = filtrerChainePourBD($unId, $idConnexion);
    $requete = "SELECT id, nom, prenom FROM visiteur WHERE id='" . $unId . "'";
    
    
    $idJeuRes = $idConnexion -> prepare($requete);
    $idJeuRes -> execute();
    
    $ligne = FALSE;
    
    do {
        while ($donnee = $idJeuRes -> fetchAll())
            ;
        if (!$idJeuRes -> nextRowset())
            break;
    } while (true);
    
    return $ligne;
}
/*
do {
    while ($stmt->fetch())
        ;
    if (!$stmt->nextRowset())
        break;
} while (true);
*/
                          /*_____FONCTIONS__CONSULTATION/SAISIE__FICHES__FRAIS_____*/
 
    
/**
 * Fournit les informations d'une fiche de frais.
 * Retourne les informations de la fiche de frais du mois de $unMois (MMAAAA)
 * sous la forme d'un tableau associatif dont les cles sont les noms des colonnes
 * (nbJustitificatifs, idEtat, libelleEtat, dateModif, montantValide).
 * @param resource $idConnexion identifiant de connexion
 * @param string $unMois mois demande (MMAAAA)
 * @param string $unIdVisiteur id visiteur
 * @return array tableau associatif de la fiche de frais
 */
function obtenirDetailFicheFrais($idConnexion, $unMois, $unIdVisiteur) {
    $unMois = filtrerChainePourBD($unMois, $idConnexion);
    $ligne = FALSE;
    $requete = "SELECT IFNULL(nbJustificatifs,0) as nbJustificatifs, Etat.id as idEtat, libelle as libelleEtat, dateModif, montantValide
    FROM FicheFrais inner join Etat on idEtat = Etat.id
    WHERE idVisiteur='" . $unIdVisiteur . "' AND mois='" . $unMois . "'";
    
    
    $idJeuRes = $idConnexion -> prepare($requete);
    $idJeuRes -> execute();
    
    $ligne = FALSE;
    
    do {
        while ($donnee = $idJeuRes -> fetchAll());
        if (!$idJeuRes -> nextRowset());
            break;
    } while (true);
    
    return $ligne;
}



/**
 * V�rifie si une fiche de frais existe ou non.
 * Retourne true si la fiche de frais du mois de $unMois (MMAAAA) du visiteur
 * $idVisiteur existe, FALSE sinon.
 * @param resource $idConnexion identifiant de connexion
 * @param string $unMois mois demandee (MMAAAA)
 * @param string $unIdVisiteur id visiteur
 * @return boolean existence ou non de la fiche de frais
 */
function existeFicheFraisVisiteur($idConnexion, $unMois, $unIdVisiteur) {
    $unMois = filtrerChainePourBD($unMois, $idConnexion);
    $requete = "SELECT idVisiteur FROM FicheFrais WHERE idVisiteur='" . $unIdVisiteur .
    "' AND mois='" . $unMois . "'";
    
    $idJeuRes = $idConnexion -> prepare($requete);
    $idJeuRes  -> execute();
    
    $ligne = FALSE ;
    if ( $idJeuRes ) {
        $ligne = $idJeuRes -> fetchAll();
        $idJeuRes -> nextRowset();
    }
    
    // si $ligne est un tableau, la fiche de frais existe, sinon elle n'exsite pas
    return is_array($ligne) ;
}



/**
 * Fournit le mois de la derniere fiche de frais d'un visiteur.
 * Retourne le mois de la derniere fiche de frais du visiteur d'id $unIdVisiteur.
 * @param resource $idConnexion identifiant de connexion
 * @param string $unIdVisiteur id visiteur
 * @return string dernier mois sous la forme AAAAMM
 */
function obtenirDernierMoisSaisi($idConnexion, $unIdVisiteur) {
    $requete = "SELECT max(mois) as dernierMois FROM FicheFrais WHERE idVisiteur='" .
        $unIdVisiteur . "'";
        
        $idJeuRes = $idConnexion -> prepare($requete);
        $idJeuRes -> execute();
        
        $ligne = FALSE;
        
        do {
            while ($donnee = $idJeuRes -> fetchAll());
            if (!$idJeuRes -> nextRowset());
                break;
        }while (true);
        
        return $dernierMois;
}



/**
 * Ajoute une nouvelle fiche de frais et les elements forfaitises associes,
 * Ajoute la fiche de frais du mois de $unMois (MMAAAA) du visiteur
 * $idVisiteur, avec les elements forfaitises associes dont la quantite initiale
 * est affectee a 0. Clot eventuellement la fiche de frais precedente du visiteur.
 * @param resource $idConnexion identifiant de connexion
 * @param string $unMois mois demande (MMAAAA)
 * @param string $unIdVisiteur id visiteur
 * @return void
 */
function ajouterFicheFrais($idConnexion, $unMois, $unIdVisiteur) {
    $unMois = filtrerChainePourBD($unMois, $idConnexion);
    // modification de la derniere fiche de frais du visiteur
    $dernierMois = obtenirDernierMoisSaisi($idConnexion, $unIdVisiteur);
    $laDerniereFiche = obtenirDetailFicheFrais($idConnexion, $dernierMois, $unIdVisiteur);
    if ( is_array($laDerniereFiche) && $laDerniereFiche['idEtat']=='CR'){
        modifierEtatFicheFrais($idConnexion, $dernierMois, $unIdVisiteur, 'CL');
    }
    
    // ajout de la fiche de frais a l'etat Cree
    $requete = "insert into FicheFrais (idVisiteur, mois, nbJustificatifs, montantValide, idEtat, dateModif) values ('"
        . $unIdVisiteur
        . "','" . $unMois . "',0,NULL, 'CR', '" . date("Y-m-d") . "')";
        
        $idJeuRes = $idConnexion -> prepare($requete);
        $idJeuRes -> execute();
        
        // ajout des elements forfaitises
        $requete = "SELECT id FROM FraisForfait";
        
        $idJeuRes = $idConnexion -> prepare($requete);
        $idJeuRes  -> execute();
        
        if ( $idJeuRes ) {
            $ligne = $idJeuRes -> fetchAll();
            while ( is_array($ligne) ) {
                $idFraisForfait = $ligne["id"];
                // insertion d'une ligne frais forfait dans la base
                $requete = "insert into LigneFraisForfait (idVisiteur, mois, idFraisForfait, quantite)
                        values ('" . $unIdVisiteur . "','" . $unMois . "','" . $idFraisForfait . "',0)";
                
                $idJeuRes = $idConnexion -> prepare($requete);
                $idJeuRes  -> execute();
                
                // passage au frais forfait suivant
                $ligne = $idJeuRes -> fetch();
            }
            $idConnexion -> closeCursor($idJeuRes);
        }
}



/**
 * Retourne le texte de la requete SELECT concernant les mois pour lesquels un
 * visiteur a une fiche de frais.
 *
 * La requete de selection fournie permettra d'obtenir les mois (AAAAMM) pour
 * lesquels le visiteur $unIdVisiteur a une fiche de frais.
 * @param string $unIdVisiteur id visiteur
 * @return string texte de la requete SELECT
 */
function requeteMoisFicheFrais($unIdVisiteur, $idConnexion) {
    $requete = "SELECT fichefrais.mois as mois FROM  fichefrais WHERE fichefrais.idvisiteur ='"
        . $unIdVisiteur . "' order by fichefrais.mois desc ";
        $requete = $idConnexion -> prepare($requete);
        return $requete;
}



/**
 * Retourne le texte de la requete SELECT concernant les elements forfaitises
 * d'un visiteur pour un mois donn�s.
 *
 * La requete de selection fournie permettra d'obtenir l'id, le libelle et la
 * quantite des elements forfaitises de la fiche de frais du visiteur
 * d'id $idVisiteur pour le mois $mois
 * @param string $unMois mois demandee (MMAAAA)
 * @param string $unIdVisiteur id visiteur
 * @return string texte de la requete SELECT
 */
function requeteElementsForfait($idConnexion, $unMois, $unIdVisiteur) {
    $unMois = filtrerChainePourBD($unMois, $idConnexion);
    $requete = "SELECT idFraisForfait, libelle, quantite FROM LigneFraisForfait
              inner join FraisForfait on FraisForfait.id = LigneFraisForfait.idFraisForfait
              WHERE idVisiteur='" . $unIdVisiteur . "' AND mois='" . $unMois . "'";
    $requete = $idConnexion -> prepare($requete);
    return $requete;
}



/**
 * Retourne le texte de la requete SELECT concernant les elements hors forfait
 * d'un visiteur pour un mois donn�s.
 *
 * La requete de selection fournie permettra d'obtenir l'id, la date, le libelle
 * et le montant des elements hors forfait de la fiche de frais du visiteur
 * d'id $idVisiteur pour le mois $mois
 * @param string $unMois mois demandee (MMAAAA)
 * @param string $unIdVisiteur id visiteur
 * @return string texte de la requete SELECT
 */
function requeteElementsHorsForfait($idConnexion, $unMois, $unIdVisiteur) {
    $unMois = filtrerChainePourBD($unMois, $idConnexion);
    $requete = "SELECT id, date, libelle, montant FROM LigneFraisHorsForfait
              WHERE idVisiteur='" . $unIdVisiteur
              . "' AND mois='" . $unMois . "'";
    $requete = $idConnexion -> prepare($requete);
    return $requete;
}



/**
 * Supprime une ligne hors forfait.
 * Supprime dans la BD la ligne hors forfait d'id $unIdLigneHF
 * @param resource $idConnexion identifiant de connexion
 * @param string $idLigneHF id de la ligne hors forfait
 * @return void
 */
function supprimerLigneHF($idConnexion, $unIdLigneHF) {
    $requete = "DELETE FROM LigneFraisHorsForfait WHERE id = " . $unIdLigneHF;
    
    $requete = $idConnexion -> prepare($requete);
    $requete -> execute();
}



/**
 * Ajoute une nouvelle ligne hors forfait.
 * Ins�re dans la BD la ligne hors forfait de libelle $unLibelleHF du montant
 * $unMontantHF ayant eu lieu � la date $uneDateHF pour la fiche de frais du mois
 * $unMois du visiteur d'id $unIdVisiteur
 * @param resource $idConnexion identifiant de connexion
 * @param string $unMois mois demandee (AAMMMM)
 * @param string $unIdVisiteur id du visiteur
 * @param string $uneDateHF date du frais hors forfait
 * @param string $unLibelleHF libelle du frais hors forfait
 * @param double $unMontantHF montant du frais hors forfait
 * @return void
 */
function ajouterLigneHF($idConnexion, $unMois, $unIdVisiteur, $uneDateHF, $unLibelleHF, $unMontantHF) {
    $unLibelleHF = filtrerChainePourBD($unLibelleHF, $idConnexion);
    $uneDateHF = filtrerChainePourBD(convertirDateFrancaisVersAnglais($uneDateHF));
    $unMois = filtrerChainePourBD($unMois, $idConnexion);
    $requete = "insert into LigneFraisHorsForfait(idVisiteur, mois, date, libelle, montant)
                values ('" . $unIdVisiteur . "','" . $unMois . "','" . $uneDateHF . "','" . $unLibelleHF . "'," . $unMontantHF .")";
    
    $idJeuRes = $idConnexion -> prepare($requete);
    $idJeuRes -> execute();
}



/**
 * Modifie les quantites des elements forfaitises d'une fiche de frais.
 * Met a jour les elements forfaitises contenus
 * dans $desEltsForfaits pour le visiteur $unIdVisiteur et
 * le mois $unMois dans la table LigneFraisForfait, apres avoir filtre
 * (annule l'effet de certains caracteres consideres comme speciaux par
 *  MySql) chaque donnee
 * @param resource $idConnexion identifiant de connexion
 * @param string $unMois mois demande (MMAAAA)
 * @param string $unIdVisiteur  id visiteur
 * @param array $desEltsForfait tableau des quantites des elements hors forfait
 * avec pour cles les identifiants des frais forfaitises
 * @return void
 */
function modifierElementsForfait($idConnexion, $unMois, $unIdVisiteur, $desEltsForfait) {
    $unMois = filtrerChainePourBD($unMois, $idConnexion);
    $unIdVisiteur = filtrerChainePourBD($unIdVisiteur, $idConnexion);
    foreach ($desEltsForfait as $idFraisForfait => $quantite) {
        $requete = "update LigneFraisForfait set quantite = " . $quantite
        . " WHERE idVisiteur = '" . $unIdVisiteur . "' AND mois = '"
            . $unMois . "' AND idFraisForfait='" . $idFraisForfait . "'";
            
            $idJeuRes = $idConnexion -> prepare($requete);
            $idJeuRes -> execute();
    }
}


/**
 * Modifie l'�tat et la date de modification d'une fiche de frais
 * Met a jour l'�tat de la fiche de frais du visiteur $unIdVisiteur pour
 * le mois $unMois a la nouvelle valeur $unEtat et passe la date de modif a
 * la date d'aujourd'hui
 * @param resource $idConnexion identifiant de connexion
 * @param string $unIdVisiteur
 * @param string $unMois mois sous la forme aaaamm
 * @return void
 */
function modifierEtatFicheFrais($idConnexion, $unMois, $unIdVisiteur, $unEtat) {
    
    $requete = "update FicheFrais set idEtat = '" . $unEtat .
    "', dateModif = now() WHERE idVisiteur ='" .
    $unIdVisiteur . "' AND mois = '". $unMois . "'";
    
    $idJeuRes = $idConnexion -> prepare($requete);
    $idJeuRes -> execute();
}             



                    /*_____FONCTIONS__POUR__LES__FONCTIONNALITES__DE__L'ACCEUIL_____*/

/*
 * Fonction permettant de controler les dates limites concernant l'utilisateur connecte
 * Puis affiche une/des alerte(s) generees par les controles de date au moment de la connection et les dates limites
 * @param none
 * @return 
 */
function afficherAlertes($idConnexion)  {
    $idUser = obtenirIdUserConnecte();
       
    $requeteUne = "SELECT 'datelimite' FROM 'visiteur' WHERE 'fichefrais'.'idVisiteur' = '".$idUser."' AND 'fichefrais'.'mois' = '".date(M)."'";

    $datesLimites = $idConnexion -> prepare($requete);
    $datesLimites -> execute();
                                                        // date type : 2018-02-01
    $requeteDeux = "SELECT DATEDIFF( day, ".$datesLimites.", ".date(Y-m-d)." )";
    
    $ecartDeDate = $idConnexion -> prepare($requete);
    $ecartDeDate -> execute();
    
    if ($ecartDeDate <= 14)   {
        $ecartDeDate14j = "il ne reste que : ".$ecartDeDate." jours pour clôturer avant la date limite.";
        return $ecartDeDate14j;
    }
    elseif ($ecartDeDate <= 7)   {
        $ecartDeDate7j = "il ne reste exactement : ".$ecartDeDate." jours pour clôturer";
        return $ecartDeDate7j;
    }
}

// Exemple de requetes de phpmyadmin
//UPDATE `fichefrais` SET `mois` = 'Fev' WHERE `fichefrais`.`idVisiteur` = 'a17' AND `fichefrais`.`mois` = '022018';

/*
 * Fonction
 * @param none
 * @return void
 */
 /*  
    while ($donnees = $reponses -> fetch())  {   // Prend une par une les donnees de la BD
              // Copie les mots de passes 
    }
    $reponses -> closeCursor();                  // Termine la requete
    */
?>