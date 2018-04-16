<?php  
/** 
 * Script de Controle et d'affichage du cas d'utilisation "Se d�connecter"
 * @package GSB-AppliFrais
 * @author x@ux@u   (basé sur )
 * @projet Gsb-AppliFrais
 * @todo RAS
 */


  $repInclude = './include/';
  require($repInclude . "_initialisation.inc.php");
  
  deconnecter();  
  header("Location:identification.php");
  
?>