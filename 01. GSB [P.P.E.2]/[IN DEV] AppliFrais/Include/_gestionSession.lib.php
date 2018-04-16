<?php
/** 
 * Regroupe les fonctions de gestion d'une session utilisateur.
 * @package GSB-AppliFrais
 * @author x@ux@u   (basé sur )
 * @projet Gsb-AppliFrais
 * @todo RAS
 */

/**
 * Fonction de changement de la duree de vie d'une session
 * Demarre ou poursuit une session.
 * @param none
 * @return@return boolean         => Indique l'ouverture de session
 */
function configEtOuvertureSession()    {
	$local_sessions_save_path = ini_get('session.save_path') . '/SessionGSB/';
	if ( ! is_dir($local_sessions_save_path) )   {
		mkdir($local_sessions_save_path);
		$ttl = 1800; // Une heure, en secondes
		session_set_cookie_params($ttl);
		ini_set('session.gc_maxlifetime', $ttl);
		ini_set('session.save_path', $local_sessions_save_path);
	}
	return session_start();
}


/** 
 * Fournit l'id de l'utilisateur connecte.                     
 *
 * Retourne l'id de l'utilisateur connecte, une chaine vide si pas de visiteur connecte.
 * @return string id de l'utilisateur connecte
 */
function obtenirLoginUserConnecte() {
    $ident="";
    if ( isset($_SESSION["idUser"]) ) {
        $ident = (isset($_SESSION["loginUser"])) ? $_SESSION["loginUser"] : '';
    }
    return $ident ;
}
function obtenirIdUserConnecte() {
    $ident="";
    if ( isset($_SESSION["loginUser"]) ) {
        $ident = (isset($_SESSION["idUser"])) ? $_SESSION["idUser"] : '';   
    }  
    return $ident ;
}
function obtenirIdUserComptableConnecte() {
    $ident="";
    if ( isset($_SESSION["loginUser"]) ) {
        $ident = (isset($_SESSION["idUser"])) ? $_SESSION["idUser"] : '';
    }
    return $ident ;
}


/**
 * Conserve en variables session les informations de l'utilisateur connecte
 * 
 * Conserve en variables session l'id $id et le login $login du visiteur connecte
 * @param string id de l'utilisateur
 * @param string login de l'utilisateur
 * @return void    
 */
function affecterInfosConnecte($id, $login) {
    $_SESSION["idUser"] = $id;
    $_SESSION["loginUser"] = $login;
}



/** 
 * Deconnecte le visiteur qui s'est identifie sur le site.                     
 *
 * @return void
 */
function deconnecter() {
    unset($_SESSION["idUser"]);
    unset($_SESSION["loginUser"]);
}

/**
 * Verifie si un visiteur s'est connecte sur le site.
 *
 * Retourne true si un utilisateur s'est identifie sur le site, FALSE sinon.
 * @return boolean echec ou succes
 */
function estVisiteurConnecte() {
	return isset($_SESSION["loginUser"]);
}
function estComptableConnecte() {
	return isset($_SESSION["loginUser"]);
}


?>