<?php
/** 
 * Contient la division pour le sommaire, sujet à des variations suivant la 
 * connexion ou non d'un utilisateur, et dans l'avenir, suivant le type de cet utilisateur 
 * Modifie par x0ux0u
 */

?>
    <!-- Division pour le sommaire -->
    <div id="menuGauche">
     <div id="infosUtil">
    <?php      
      if (estComptableConnecte()) {
          $idUser = obtenirIdUserConnecte() ;
          $lgUser = obtenirDetailComptable($idConnexion, $idUser);
          $nom = $lgUser['nom'];
          $prenom = $lgUser['prenom'];            
    ?>
        <h2>
    <?php  
            echo $nom . " " . $prenom ;
    ?>
        </h2>
        <h3>Visiteur m�dical</h3>        
    <?php
       }
    ?>  
      </div>  
<?php      
  if (estComptableConnecte()) {
?>
        <ul id="menuList">
           <li class="smenuComptable">
              <a href="AccueilComptable.php" title="Page d'accueil">Accueil</a>
           </li>
           <li class="smenuComptable">
              <a href="deconnecterComptable.php" title="Se deconnecter">Se deconnecter</a>
           </li>
           <li class="smenuComptable">
              <a href="dossierEnCour.php" title="Consultation des dossiers en cours">Consultation dossier en cours</a>
           </li>
           <li class="smenuComptable">
              <a href="ConsultFichesFraisComptable.php" title="Consultation des fiches de frais">Consultation fiches de frais</a>
           </li>
           <li class="smenuComptable">
           	  <a href="nousContacter.php" title="Nous Contacter">Nous Contacter</a>
           </li>
         </ul>
        <?php
          // affichage des eventuelles erreurs dejà detectees
          if ( nbErreurs($tabErreurs) > 0 ) {
              echo toStringErreurs($tabErreurs) ;
          }
  }
        ?>
    </div>
    