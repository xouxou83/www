<?php
/*
 * @package GSB-AppliFrais
 * @author x@ux@u   (basé sur )
 * @projet Gsb-AppliFrais
 * @todo RAS
 */

/*$repInclude = "./Include/";
require($repInclude . "_bdGestionDonnees.inc.php");

function connecterServeurBD() {
    $hote = "localhost";
    $database = "gsb-appfrais-visiteur";
    $login = "root";
    $mdp = "";
    $connect = mysqli_connect($hote, $login, $mdp, $database);
    return $connect;
}

function stockageMdpBD($$idConnexion)    {
    $MdpTab = array();
    $requete = 'SELECT mdp FROM visiteur';
    $idJeuRes = mysqli_query($$idConnexion, $requete);
    $ligne = mysqli_fetch_assoc($idJeuRes);
    while (is_array($ligne)) {         // while (mysqli_fetch_field('mdp')) 
       array_push($MdpTab, $idJeuRes);
        $ligne = mysqli_fetch_assoc ($idJeuRes);
    }
    mysqli_free_result($idJeuRes); 
    return $ligne;
}

function updateBD($$idConnexion, $unLogin, $unMdp)   {
  
    $requete = "UPDATE visiteur SET mdp = " . crypto($unLogin, $unMdp) ."'"; 
    $idJeuRes = mysqli_query($$idConnexion, $requete);
    return $idJeuRes;
}
    connecterServeurBD();
    stockageMdpBD($$idConnexion);
*/    
    
/*
 * Fonction de sauveguarde de la base de donnees.
 */

        try {
            $idConnexion = new PDO('mysql:host=localhost;dbname=gsb-applifrais;charset=utf8', 'root', '');
        }
        catch (Exception $e) {
           die('Erreur : ' . $e -> getMessage());
        }

        try {
            $idConnexionSave = new PDO('mysql:host=localhost;dbname=gsb-centre-sauvegarde;charset=utf8', 'root', '');
        }
        catch (Exception $d) {
            die('Erreur : ' . $d -> getMessage());
        }
/*
        $requete = "'CREATE TABLE 'gsb-centre-sauvegarde.save_".date('D-d-M-Y_H:i:s')."' AS SELECT * FROM 'gsb-applifrais.visiteur''";
        $reponses = $idConnexionSave -> prepare($requete);
*/

        $reponseSave = $idConnexionSave -> exec(file_put_contents("gsb-centre-sauvegarde", $idConnexion -> exec(file_get_contents('gsb-applifrais.sql'))));
        echo ($reponseSave);
/*      $MdpSave = array();
        $compt = 0;
        $donnees = FALSE;
        while ($donnees = $idConnexion -> fetch_assoc($idJeuRes))  {   // Prend une par une les donnees de la BD
            $id = $donnees['id'];
            $nom = $donnees['nom'];
            $prenom = $donnees['prenom'];
            $login = $donnees['login'];
            $mdp = $donnees['mdp']; 
            $adresse = $donnees['adresse'];
            $cp = $donnees['cp'];                   // Copie tout les champs dans la nouvelle base
            $ville = $donnees['ville'];
            $dateEmbauche = $donnees['dateEmbauche'];      
            $compt++;
            $request = 'INSERT INTO visiteur(id, nom, prenom, login, mdp, adresse, cp, ville, dateEmbauche) VALLUES('.$id."','".$nom."','".$prenom."','".$login."','".$mdp."','".$adresse."','".$cp."','".$ville."','".$dateEmbauche."')'";
            $idConnexionSave -> quote($request);
            $idConnexionSave -> query($request);
        }
        $requeteCryptPass = "'UPDATE visiteur SET mdp = '".cryptage($login)."' '";
    echo ("erreur n° " . $idConnexionSave -> errorCode());
   */     
//        $reponses -> closeCursor();                  // Termine la requete
//      CREATE TABLE TABLE2 AS SELECT * FROM TABLE1 ;
/*  CREATE TABLE database2.table2 AS (SELECT * FROM database1.table1)
 * ou  
 *  mysqldump -h monserveur -u admin -p motdepasse -bddA.sql matable
 *  puis mysqlimport
 */
    
//  requete operationnelle :"UPDATE visiteur SET mdp = cryptage(mdp)" 

?>