<?php
/**
 * Librairie des fonctions pour l'accès et la gestion de la base de donnee (PDO)
 * @package GSB-AppliFrais
 * @author x@ux@u   (basé sur _bdGestionDonnees.lib.php par Arthur Martin)
 * @projet Gsb-AppliFrais
 * @todo RAS
 */
   

                       /*_____FONCTIONS__CONNEXIONS__UTILISATEURS__ET__CONNEXIONS__BDD_____*/
/**
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



/**
 * Fonction de connexion au serveur BD en PDO pour la sauvegarde des donnees.
 * @param none
 * @return resource $idConnexionSave
 */
function connecterServeurBDSave()   {
    try {
        $idConnexionSave = new PDO('mysql:host=localhost;dbname=gsb-centre-sauvegarde;charset=utf8', 'root', '');
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


/**
 * Fonction de deconnexion de la base de donnees
 * @param resource $idConnexion
 * @return resource $idConnexion
 */
function deconnecterServeurBD($idConnexion) {
    $idConnexion = NULL;
    return $idConnexion;
}


/**
 * Fonction de filtrage des chaines pour les requetes SQL
 * @param string $str
 * @param resource $idConnexion
 * @return string $str          => Renvoie la chaine filtree pour la base de donnees
 */
function filtrerChainePourBD($str, $idConnexion)  {
    if ( ! get_magic_quotes_gpc() ) {
        $str = $idConnexion -> prepare($str);
    }
   return $str;
    
}

/**
 * Fonction de requêtes SQL avec prepare() et execute()
 * Permet une meilleure efficacité d'exécution, et plus sécurisé.
 * Fonction filtrerChainePourBD devient oboslète !
 * @param resource $idConnexion identifiant de connexion
 * @param string $unLogin login
 * @param string $unMdp mot de passe
 * @return array tableau associatif ou booleen FALSE
 */
function requeteSQL($idConnexion, $requete) {
    $idJeu = $idConnexion -> prepare($requete);
    $ligne = FALSE;
    $idJeu -> execute();
    
    if ( $idJeu != NULL) {
        $ligne = $idJeu -> fetch(PDO::FETCH_ASSOC);
    }
    return $ligne;
}

/**
 * Fonction de requêtes SQL avec prepare() et execute()
 * Permet une meilleure efficacité d'exécution, et plus sécurisé.
 * Fonction filtrerChainePourBD devient oboslète !
 * @param resource $idConnexion identifiant de connexion
 * @param string $unLogin login
 * @param string $unMdp mot de passe
 * @return array tableau associatif ou booleen FALSE
 */
function voidRequeteSQL($idConnexion, $requete) {
    $reponse = $idConnexion -> prepare($requete);
    $reponse -> execute();
}

/**
 * Fonction de requêtes SQL avec prepare() et execute()
 * Permet une meilleure efficacité d'exécution, et plus sécurisé.
 * Fonction filtrerChainePourBD devient oboslète !
 * @param resource $idConnexion identifiant de connexion
 * @param string $unLogin login
 * @param string $unMdp mot de passe
 * @return array tableau associatif ou booleen FALSE
 */
function multiRequeteSQL($idConnexion, $requete) {
    $idJeu = $idConnexion -> prepare($requete);
    $idJeu  -> execute();
    
    $ligne = FALSE ;
    if ( $idJeu ) {
        $ligne = $idJeu -> fetchAll();
        $idJeu -> nextRowset();
    }

    //=> si $ligne est un tableau, la fiche de frais existe, sinon elle n'exsite pas
    return $ligne;
}

/**
 * Fonction de requêtes SQL avec prepare() et execute()
 * Permet une meilleure efficacité d'exécution, et plus sécurisé.
 * Fonction filtrerChainePourBD devient oboslète !
 * @param resource $idConnexion identifiant de connexion
 * @param string $unLogin login
 * @param string $unMdp mot de passe
 * @return array tableau associatif ou booleen FALSE
 */
function exeRequeteSQL($idConnexion, $idJeu) {
    $idJeu -> execute();
    
    if ( $idJeu ) {
        $ligne = $idJeu -> fetch(FETCH_ASSOC);
    }
    $idJeu -> closeCursor();
    return $ligne;
}


/**
 * Fonction de cryptage avec $salt realise par x0ux0u
 * @param string $unMdp         ==> Mot de passe en clair
 * @return string $crypted      ==> Mot de passe crypte
 */
function cryptage($unMdp)	{
    if (strlen($unMdp)!= 0) {
        $Mdp = "$unMdp";
        $var = $Mdp[1].$Mdp[0];
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

/**
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
function verifierInfosConnexionVisiteur($idConnexion, $unLogin, $unMdp) {
    // le mot de passe est crypte dans la base avec la fonction crypt() et un salt pour chaque utilisateurs
    $requete = "SELECT id, nom, prenom, login, mdp FROM visiteur WHERE login='".$unLogin."' AND mdp='" .$unMdp. "'";
    $ligne = requeteSQL($idConnexion, $requete);
    return $ligne;
}

function verifierInfosConnexionComptable($idConnexion, $unLogin, $unMdp) {
    // le mot de passe est crypte dans la base avec la fonction crypt() et un salt pour chaque utilisateurs
    $requete = "SELECT id, nom, prenom, login, mdp FROM comptable WHERE login='".$unLogin."' AND mdp='" .$unMdp. "'";
    $ligne = requeteSQL($idConnexion, $requete);
    return $ligne;
}
    
    
    
/*    do {
        while ($donnee = $idJeuResVisiteur -> fetch());
        if (!$idJeuResVisiteur -> nextRowset());
        break;
    } while (true);
    if ( $idJeuResVisiteur ) {
        $ligne = $idJeuResVisiteur -> fetch();     
        var_dump($ligne); 
        if ($ligne != NULL && $ligne != FALSE) {
            $_POST['Visiteur'] = 1;
           ?><form method="post"><input type="hidden" name="Visiteur" id="Visiteur" value="Visiteur" /></form><?php
          return $ligne;
        }
    
    if ($ligne == NULL or $ligne == FALSE) { 
        $requeteComptable = "SELECT id, nom, prenom, login, mdp FROM comptable WHERE login='".$unLogin."' AND mdp='" .$unMdp. "'";
        $idJeuResComptable = $idConnexion -> prepare($requeteComptable);
    
        $ligne = FALSE;
        $idJeuResComptable -> execute();
        do {
            while ($donnee = $idJeuResComptable -> fetch());
            if (!$idJeuResComptable -> nextRowset());
            break;
        } while (true);
        if ( $idJeuResComptable) {
            $ligne = $idJeuResComptable -> fetch(PDO::FETCH_ASSOC);
        } 
        if ($ligne != NULL && $ligne != FALSE) {
            $_POST['Comptable'] = 1;
            ?><form method="post"><input type="hidden" name="Comptable" id="Comptable" value="Comptable" /></form><?php
            return $ligne;
        }
    }
}
 */
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
    $requete = "SELECT id, nom, prenom FROM visiteur WHERE id='" . $unId . "'";
    $ligne = requeteSQL($idConnexion, $requete);
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
    $requete = "SELECT IFNULL(nbJustificatifs,0) as nbJustificatifs, Etat.id as idEtat, libelle as libelleEtat, dateModif, montantValide
    FROM FicheFrais INNER JOIN Etat on idEtat = Etat.id WHERE idVisiteur='" . $unIdVisiteur . "' AND mois='" . $unMois . "'";
//    $ligne = requeteSQL($idConnexion, $requete);
 
    $idJeuRes = $idConnexion -> prepare($requete);
    $idJeuRes  -> execute();
    
    $ligne = FALSE;
    if ( $idJeuRes ) {
        $ligne = $idJeuRes -> fetch(PDO::FETCH_ASSOC);
    }
    
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
function existeFicheFrais($idConnexion, $unMois, $unIdVisiteur) {
    $requete = "SELECT 'nbJustificatifs' FROM FicheFrais WHERE idVisiteur='" . $unIdVisiteur .
    "' AND mois='" . $unMois . "'";
    
    $idJeuRes = $idConnexion -> prepare($requete);
    $idJeuRes  -> execute();
    
    $ligne = FALSE;
    if ( $idJeuRes ) {
        $ligne = $idJeuRes -> fetch(PDO::FETCH_ASSOC);
    }
    
    //=> si $ligne est un tableau, la fiche de frais existe, sinon elle n'exsite pas
    return is_array($ligne);
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
        $ligne = requeteSQL($idConnexion, $requete);
        return $ligne;
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
    //=> modification de la derniere fiche de frais du visiteur
    $dernierMois = obtenirDernierMoisSaisi($idConnexion, $unIdVisiteur);
    $laDerniereFiche = obtenirDetailFicheFrais($idConnexion, $dernierMois, $unIdVisiteur);
    if ( is_array($laDerniereFiche) && $laDerniereFiche['idEtat']=='CR'){
        modifierEtatFicheFrais($idConnexion, $dernierMois, $unIdVisiteur, 'CL');
    }
    
    //=> ajout de la fiche de frais a l'etat Cree
    $requete = "INSERT INTO FicheFrais (idVisiteur, mois, nbJustificatifs, montantValide, idEtat, dateModif) values ('"
        . $unIdVisiteur
        . "','" . $unMois . "',0,NULL, 'CR', '" . date("Y-m-d") . "')";
        
        requeteSQL($idConnexion, $requete);
        
        //=> ajout des elements forfaitises
        $requete = "SELECT id FROM fraisforfait";
        
        $idJeu = $idConnexion -> prepare($requete);
        $idJeu  -> execute();
        
        if ( $idJeu ) {
            $ligne = $idJeu -> fetchAll();
            while ( is_array($ligne) ) {
                $idFraisForfait = $ligne['id'];
                      // insertion d'une ligne frais forfait dans la base
                $requete = "INSERT INTO LigneFraisForfait (idVisiteur, mois, idFraisForfait, quantite)
                        VALUES ('" . $unIdVisiteur . "','" . $unMois . "','" . $idFraisForfait . "',0)";
                
                $idJeuRes = $idConnexion -> prepare($requete);
                $idJeuRes  -> execute();
            }
            $idJeu -> closeCursor();
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
function requeteMoisFicheFrais($unIdVisiteur) {
    $requete = "SELECT fichefrais.mois as mois FROM  fichefrais WHERE fichefrais.idvisiteur ='"
        . $unIdVisiteur . "' order by fichefrais.mois desc ";
	return $requete;
}


/**
 * Retourne la requete pour obtenir les Frais forfaitisés
 * @param string $unMois mois demandee (MMAAAA)
 * @param string $unIdVisiteur id visiteur
 * @return string texte de la requete SELECT
 */
function requeteElementsForfait() {
	$requete = "SELECT id, libelle, montant FROM FraisForfait";
    return $requete;
}


/**
 * Retourne le texte de la requete SELECT concernant les elements forfaitises
 * d'un visiteur pour un mois donnés.
 *
 * La requete de selection fournie permettra d'obtenir l'id, le libelle et la
 * quantite des elements forfaitises de la fiche de frais du visiteur
 * d'id $idVisiteur pour le mois $mois
 * @param string $unMois mois demandee (MMAAAA)
 * @param string $unIdVisiteur id visiteur
 * @return string texte de la requete SELECT
 */
function requeteElementsForfaitExistant($unMois, $unIdVisiteur) {
    $requete = "SELECT id, libelle, quantite FROM LigneFraisForfait
	        INNER JOIN FraisForfait on FraisForfait.id = LigneFraisForfait.idFraisForfait
            WHERE idVisiteur='" . $unIdVisiteur . "' AND mois='" . $unMois . "'";
    return $requete;
}

/**
 * Retourne le texte de la requete SELECT concernant les elements hors forfait
 * d'un visiteur pour un mois donnés.
 *
 * La requete de selection fournie permettra d'obtenir l'id, la date, le libelle
 * et le montant des elements hors forfait de la fiche de frais du visiteur
 * d'id $idVisiteur pour le mois $mois
 * @param string $unMois mois demandee (MMAAAA)
 * @param string $unIdVisiteur id visiteur
 * @return string texte de la requete SELECT
 */
function requeteElementsHorsForfait($unMois, $unIdVisiteur) {
    $requete = "SELECT id, date, libelle, montant FROM LigneFraisHorsForfait
              WHERE idVisiteur='" . $unIdVisiteur . "' AND mois='" . $unMois . "'";
    return $requete;
}


/**
 * Supprime une ligne hors forfait.
 * Supprime dans la BD la ligne hors forfait d'id $unIdLigneHF
 * @param resource $idConnexion identifiant de connexion
 * @param string $idLigneHF id de la ligne hors forfait
 * @return void
 */
function supprimerLigneHF( $idConnexion, $unIdLigneHF ) {
    $requete = "DELETE FROM LigneFraisHorsForfait WHERE id = " . $unIdLigneHF;
    $requeteSupprLigneHF = $idConnexion -> prepare($requete);
    $requeteSupprLigneHF -> execute();
}


/**
 * Ajoute une nouvelle ligne hors forfait.
 * Insere dans la BD la ligne hors forfait de libelle $unLibelleHF du montant
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
function ajouterLigneHF( $idConnexion, $unMois, $unIdVisiteur, $uneDateHF, $unLibelleHF, $unMontantHF ) {
 //   $uneDateHF = convertirDateFrancaisVersAnglais($uneDateHF);
    $requete = "insert into LigneFraisHorsForfait(idVisiteur, mois, date, libelle, montant)
                values ('" . $unIdVisiteur . "','" . $unMois . "','" . $uneDateHF . "','" . $unLibelleHF . "'," . $unMontantHF .")";
    $requeteAjoutLigneHF = $idConnexion -> prepare($requete);
    $requeteAjoutLigneHF -> execute();
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
    foreach ($desEltsForfait as $idFraisForfait => $quantite) {
        $requete = "update LigneFraisForfait set quantite = " . $quantite
        . " WHERE idVisiteur = '" . $unIdVisiteur . "' AND mois = '"
            . $unMois . "' AND idFraisForfait='" . $idFraisForfait . "'";
            voidRequeteSQL($idConnexion, $requete);
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
    voidRequeteSQL($idConnexion, $requete);
}             


                    /*_____FONCTIONS__POUR__LES__FONCTIONNALITES__DE__L'ACCEUIL_____*/

/**
 * Fonction permettant de controler les dates limites concernant l'utilisateur connecte
 * Puis affiche une/des alerte(s) generees par les controles de date au moment de la connection et les dates limites
 * @param none
 * @return 
 */
function afficherAlertes($idConnexion)  {
    try {
        $idUser = obtenirIdUserConnecte();
       
        $requeteUne = "SELECT datelimite FROM fichefrais WHERE idVisiteur= '".$idUser."' AND mois= '".date('M')."'";
        $dateconcernee = requeteSQL($idConnexion, $requeteUne);
                                                        //=> date type : 2018-02-01
        $requeteDeux = "SELECT DATEDIFF('".date('Y-m-d')."', '".$dateconcernee."')" ;
        $ecart = requeteSQL($idConnexion, $requeteDeux);
                    
        if ($ecart <= 14)   {
            $ecartDeDate14j = "il ne reste que : ".$ecart." jours pour cloturer avant la date limite.";
            return $ecartDeDate14j;
        }
        elseif ($ecart <= 7)   {
            $ecartDeDate7j = "il ne reste exactement : ".$ecart." jours pour cloturer";
        
            return $ecartDeDate7j;
        }
    }
    catch (Exception $e) {
        $e->getMessage() . "\n";
    }
    finally {
        echo'Vous êtes à jour dans vos déclarations.';
    }
}

// Exemple de requetes de phpmyadmin
//UPDATE `fichefrais` SET `mois` = 'Fev' WHERE `fichefrais`.`idVisiteur` = 'a17' AND `fichefrais`.`mois` = '022018';

/**
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