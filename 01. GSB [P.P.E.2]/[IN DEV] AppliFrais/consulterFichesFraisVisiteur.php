<?php
/** 
 * Script de controle et d'affichage du cas d'utilisation "Consulter une fiche de frais" 
 * Page de consultation des frais uniquement pour les visiteurs
 * @package GSB-AppliFrais
 * @author x@ux@u   (basé sur )
 * @projet Gsb-AppliFrais
 * @todo RAS
 */

$repInclude = './Include/';
$repIncludeVisiteur = './Include/Visiteur/';

require($repInclude .'_initialisation.inc.php');

if ( ! estVisiteurConnecte() )   {
    header("Location: identification.php");
}
$tabFicheFrais = array();
$moisEnCours = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");                                                                      //=> acquisition des donnees entrees, ici le numero de mois et l'etape du traitement
$etape = lireDonneePost("etape", "");
$moisSaisi = lireDonneePost("lstMois", "");

if ( $etape != "demanderConsult" && $etape != "validerConsult" ) {
	$etape = "demanderConsult";	        //=> Si autre valeur, on considere que c'est le debut du traitement
}	
if ( $etape == "validerConsult" ) {       //=> l'utilisateur valide ses nouvelles donnees
                                        //=> verification de l'existence de la fiche de frais pour le mois demande
	$existeFicheFrais = existeFicheFrais($idConnexion, $moisSaisi, obtenirIdUserConnecte());
	var_dump($existeFicheFrais);
	
	if ( $existeFicheFrais == FALSE ) {	
//	elseif ( obtenirDetailFicheFrais( $idConnexion, $moisSaisi, obtenirIdUserConnecte() ) == FALSE ) {                                                                                                
		      //=> si elle n'existe pas, on la cree avec les elements frais forfaitisees à 0
	    ajouterErreur($tabErreurs, "Le mois demandé est invalide, et sera créee à zéro");   
		ajouterFicheFrais($idConnexion, $moisSaisi,  obtenirIdUserConnecte());
		?><p><?php echo "\n"."test condition ajouterFicheFrais"."\n";?></p><?php
	}
	elseif ( $existeFicheFrais )     {
	    //    if ( obtenirDetailFicheFrais( $idConnexion, $moisSaisi, obtenirIdUserConnecte() ) ) {                                        //=> recuperation des donnees sur la fiche de frais demandee 
		$tabFicheFrais = obtenirDetailFicheFrais($idConnexion, $moisSaisi, obtenirIdUserConnecte());

	}
	else {
	    ?><p><?php echo ("Une erreure est survenue, veuillez nous en excuser.");?></p><?php
	}
}
?>
 						 <!-- Division principale -->
<h2>Mes fiches de frais</h2>
	<h3>Mois à sélectionner : </h3>
		<form action="" method="post">
			<div class="corpsFormConsult">
          		<input type="hidden" name="etape" value="validerConsult" />
      				<p>
        				<label for="lstMois">Mois : </label>
        					<SELECT id="lstMois" name="lstMois" title="Sélectionnez le mois souhaité pour la fiche de frais">
<?php                           //=> on propose tous les mois pour lesquels le visiteur a une fiche de frais 	                        
                               
                                //=> Par defaut mois en cours
                         /*       if ( is_array($lgMois) ) {
                                    while ( is_array($lgMois) ) {
                                        echo ("TEST WHILE LIGNE 67");
                                        $mois = $lgMois["mois"];
                                        $noMois = intval(substr($mois, 4, 2));
                                        $annee = intval(substr($mois, 0, 4));
                                ?><option value="<?php echo ($mois);?>"<?php if($moisSaisi == $mois){?>selected="selected"<?php }?>><?php echo obtenirLibelleMois($noMois) . " " . $annee; ?></option><?php
            
                                        $lgMois = $idJeuMois -> fetch();
                                    }
                                    $idJeuMois -> closeCursor();
                                ?> 	</SELECT>  <?php
                                }   */
                                $moisEnCours = array('0' => "" ,'1' => "Janvier",'2' => "Février",'3' => "Mars",'4' => "Avril",'5' => "Mai",'6' => "Juin",'7' => "Juillet",'8' => "Août",'9' => "Septembre",'10' => "Octobre",'11' => "Novembre",'12' => "Décembre");
          //                      $numMois = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12");
                                $selection = ''; 
                   //             if  (is_array($lgMois) == FALSE) {
                                    /*    ?><option value="<?php echo ($numMois); ?>"<?php
                                    if ($moisSaisi == $numMois) { 
                                    ?>selected="selected"<?php  ?>><?php echo $moisEnCours[$numMois];//. " " . $annee; ?></option><?php
                                }    	
                                    foreach ($moisEnCours as $Mois)	{*/
                                    for ($numMois = 0; $numMois <= 12; $numMois ++)   {
                                        if ($numMois == 0)  {
                                            $annee = date('Y');
                                            $libelle = $moisEnCours[$numMois] . "Choisir:";
                                            $Mois = $numMois;
                                        }
                                        elseif ($numMois < 10)  {
                                            $annee = date('Y');
                                            $libelle = $moisEnCours[$numMois] . " " . $annee;
                                            $numMois = 0 . $numMois;
                                            $Mois = $annee . $numMois;
                                        }
                                        else {
                                            $annee = date('Y');
                                            $libelle = $moisEnCours[$numMois] . " " . $annee;
                                            $Mois = $annee . $numMois;
                                        }
                               //         if  ($Mois == $moisSaisi)	{
                                //            $selection = 'selected = "selected"';
                               //         }       //=>   $mois = MMAAAA   <=//=>   ex: 022018   <=//
                                        
                                                //=>   Affichage de la ligne
                                        ?><option value="<?php echo ($Mois); ?>"<?php if ($moisSaisi == $Mois){?>selected="selected"<?php }?>><?php echo $libelle; ?></option><?php
                                //        echo "\t",'<option value="', $numMois ,'"', $selection ,'>', $Mois ,'</option>',"\n";
                                                //=> Remise à zéro de $selected
                                        $selection='';          
                                    }    
                                    echo '</SELECT>',"\n";    
                          //      }       				      
?>    			</p>
    		</div>
			<div class="piedForm">
     			<p>
        			<input id="ok" type="submit" value="Valider" size="20"
            			title="demandez à consulter cette fiche de frais" />
        			<input id="annuler" type="reset" value="Effacer" size="20" />
				</p> 
			</div>
		</form>
<?php      
                                         
if ( $etape == "validerConsult" ) {             //=> demande et affichage des differents elements (forfaitisees et non forfaitisees)
    if ( nbErreurs($tabErreurs) > 0 ) {         //=> de la fiche de frais demandee, uniquement si pas d'erreur detecte au controle
        echo toStringErreurs($tabErreurs);
    }
    else /*if ($tabFicheFrais != FALSE)*/ {
        $requete = requeteMoisFicheFrais(obtenirIdUserConnecte());
        $idJeuMois = $idConnexion -> prepare($requete);
        
        $lgMois = FALSE;
        $idJeuMois -> execute();
        
        
        if ( $idJeuMois ) {
            $lgMois = $idJeuMois -> fetch();
        }
//        var_dump($tabFicheFrais);
        ?><div class="corpsForm">
        	<div id="HautEncadre">
    			<h3>Fiche de frais du mois de <?php echo $moisEnCours[intval( substr($moisSaisi, 4) )] . " " . intval( substr($moisSaisi, 0, 2) );?> : 
   					<em><?php echo $tabFicheFrais["libelleEtat"]; ?></em>depuis le : 
   					<em><?php echo $tabFicheFrais["dateModif"]; ?></em>
   				</h3>
    				<p>Montant validé : <?php if ($tabFicheFrais["montantValide"] == NULL) {  echo '0';  } ?></p><?php   
    	  ?></div><?php
    	    
                 //=> demande de la requete pour obtenir la liste des elements 
                 //=> forfaitisees du visiteur connecte pour le mois demande
   /*     $requete = requeteElementsForfaitExistant($moisSaisi, obtenirIdUserConnecte());
        $elementsFraisForfait = $idConnexion -> prepare($requete);
        $ligneElementsForfait = FALSE;
        $elementsFraisForfait -> execute();
        
        if ( $elementsFraisForfait ) {
            $ligneElementsForfait = $elementsFraisForfait -> fetch();
                //=> parcours des frais forfaitisees du visiteur connecté
                //=> le stockage intermédiaire dans un tableau est nécessaire
                //=> car chacune des lignes du jeu d'enregistrements doit etre doit etre
                //=> affichée au sein d'une colonne du tableau HTML
       }    */   
    	  
    	           //=> DEBUT TEST <=//
    	  /**
    	   * Demande du détail des éléments qui sont forfaitisées du visiteur connecté pour le mois demande
    	   */
    	  $requete = requeteElementsForfaitExistant($moisSaisi, obtenirIdUserConnecte());
    	  $elementsFraisForfaitExistant = $idConnexion -> prepare($requete);
    	  $elementsFraisForfaitExistant -> execute();
    	  $idConnexion -> errorInfo();
    	  $ligneElementsFraisForfaitExistant = $elementsFraisForfaitExistant -> fetch();
    	  
    	  //var_dump($ligneElementsFraisForfaitExistant);
    	  
    	  /**
    	   * Demande du détail des éléments qui sont forfaitisées
    	   */
    	  $requete = requeteElementsForfait($moisSaisi, obtenirIdUserConnecte());
    	  $elementsFraisForfait = $idConnexion -> prepare($requete);
    	  $elementsFraisForfait -> execute();
    	  $idConnexion -> errorInfo();
    	  $ligneElementsForfait = $elementsFraisForfait -> fetch();
    	  
    	  /**
    	   * Demande des ID des éléments qui sont forfaitisées
    	   */
    	  $requete = "SELECT id FROM FraisForfait";
    	  $idFraisForfait = $idConnexion -> prepare($requete);
    	  $idFraisForfait -> execute();
    	  $ligneIdForfait = $idFraisForfait -> fetchAll();
    	  
?>    	  
</div>
<div class="corpsFormConsult"> <!--  --> 
    <input type="hidden" name="etape" value="demanderConsult" />
        <fieldset>
            <legend>Eléments forfaitisées</legend>
<?php
        foreach ( $ligneIdForfait as $idFraisForfait /* => $quantite*/ ) {
            $idFraisForfait = $ligneElementsForfait["id"];
            $libelle = $ligneElementsForfait["libelle"];
            $montant = $ligneElementsForfait["montant"];
            if  ($ligneElementsFraisForfaitExistant == FALSE)    {
                $quantite = "0";
            }
            else    {
                $quantite = $ligneElementsFraisForfaitExistant["quantite"];	      
            }

?>    	      <p class="listeConsult">
				<label for="<?php echo $idFraisForfait; ?>"> <?php echo $libelle; ?>* : <?php echo $montant ; ?></label>
					 <div id="quantiteExistante"><?php echo"Quantités déjà entrées pour ce mois :   " . $quantite; ?></div>
						<br>
<?php         $ligneElementsForfait = $elementsFraisForfait -> fetch(); 
            ?></p><?php 
    	  }        ?>
		</fieldset>
 	</div>
<?php                         //=> premier parcours du tableau des frais forfaitisees du visiteur connecte
                              //=> pour afficher la ligne des libelles des frais forfaitisees
  /*      foreach ( $tabEltsFraisForfait as $unLibelle => $uneQuantite ) {
?>					<th><?php echo $unLibelle; ?></th><?php
        }       */
?>			
         			
<?php                         //=> second parcours du tableau des frais forfaitises du visiteur connecte
                              //=> pour afficher la ligne des quantites des frais forfaitises
 /*       foreach ( $tabEltsFraisForfait as $unLibelle => $uneQuantite ) {
?>					<td class="qteForfait"><?php echo $uneQuantite; ?></td><?php
        }          */

    	  
          
    	           //=> FIN TEST <=//
    	  
//        $tabEltsFraisForfait = array();
                /* parcours des frais forfaitisees du visiteur connecte
                 * le stockage intermediaire dans un tableau est necessaire
                 * car chacune des lignes du jeu d'enregistrements doit etre doit etre
                 * affichee au sein d'une colonne du tableau HTML
                 */ 
/*        while ( is_array($ligneElementsForfait) ) {
            $tabEltsFraisForfait[$ligneElementsForfait["libelle"]] = $ligneElementsForfait["quantite"];
            $elementsFraisForfait -> execute();
            
            if ( $elementsFraisForfait ) {
                $ligneElementsForfait = $elementsFraisForfait -> fetch();
            }
        }
        $elementsFraisForfait -> closeCursor();
        var_dump($ligneElementsForfait); 
    
    	      
    	      
		?>		<table class="listeLegere">
  	   				<caption>Quantités des éléments forfaitisés</caption>
       					<tr>
<?php
                              //=> premier parcours du tableau des frais forfaitisees du visiteur connecte
                              //=> pour afficher la ligne des libelles des frais forfaitisees
        foreach ( $tabEltsFraisForfait as $unLibelle => $uneQuantite ) {
?>							<th><?php echo $unLibelle; ?></th><?php
        }
?>						</tr>
         				<tr>	
<?php                         //=> second parcours du tableau des frais forfaitises du visiteur connecte
                              //=> pour afficher la ligne des quantites des frais forfaitises
        foreach ( $tabEltsFraisForfait as $unLibelle => $uneQuantite ) {
?>							<td class="qteForfait"><?php echo $uneQuantite; ?></td><?php
        }
?>						</tr>
    			</table>
*/  ?>
		<div class="corpsFormConsult"> <!--  --> 
    		<input type="hidden" name="etape" value="demanderConsult" />
        		<fieldset>
            		<legend>Eléments hors forfaits</legend>
            			<caption>Descriptif des éléments hors forfaits : <?php if($tabFicheFrais["nbJustificatifs"] != NULL or FALSE) {  echo $tabFicheFrais["nbJustificatifs"]; } ?> justificatifs recus.</caption>  						
  							 <div id="tableDeConsultation"> 
  	<!--  --> 					<table>
    								<tr>
            							<th class="legend">Date</th>
                						<th class="legend">Libellé</th>
                						<th class="legend">Montant</th>                
            						</tr>
<?php          
                //=> demande de la requete pour obtenir la liste des elements hors
                //=> forfait du visiteur connecte pour le mois demande
        $requete = requeteElementsHorsForfait($moisSaisi, obtenirIdUserConnecte());
        $idJeuEltsHorsForfait = $idConnexion -> prepare($requete);
        
        $lgEltHorsForfait = FALSE;
        $idJeuEltsHorsForfait -> execute();
        
        if ( $idJeuEltsHorsForfait ) {
            $lgEltHorsForfait = $idJeuEltsHorsForfait -> fetch();
        }
//        var_dump($lgEltHorsForfait);                                                                      //=> parcours des elements hors forfait 
        while ( is_array($lgEltHorsForfait) ) {
            if    ( $lgEltHorsForfait == FALSE )   {
                $dateHF = "0";
                $libelleHF = "0";
                $montantHF = "0";
   
            }
            else    {
                $dateHF = $lgEltHorsForfait["date"];
                $libelleHF = filtrerChainePourNavig($lgEltHorsForfait["libelle"]);
                $montantHF = $lgEltHorsForfait["montant"];
            }
?>				<tr>
                   	<td><?php echo $dateHF; ?></td>
                   	<td><?php echo $libelleHF; ?></td>
                   	<td><?php echo $montantHF; ?></td>
                </tr>
            		
<?php   $lgEltHorsForfait = $idJeuEltsHorsForfait -> fetch();
        }
?>							</table>		
						</div>
			</div>	
<?php
    }		       //=>		Fin de condition Else   <=//
}			       //=>		Fin de boucle If   <=//
require($repInclude . "_fin.inc.php");
?>    
