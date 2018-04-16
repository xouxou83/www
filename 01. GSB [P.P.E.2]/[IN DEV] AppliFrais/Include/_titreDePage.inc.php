<?php 
/**
 * Page permettant l'affichage de chaque titre de page ainsi que
 * @package GSB-AppliFrais
 * @author x@ux@u
 * @projet Gsb-AppliFrais
 * @todo RAS
 */

?>
            <!-- Division principale -->
<div id="page">
	<div class="spacer"></div>
		<div id="contenu">
<?php 
if ( $_SERVER['PHP_SELF'] == '/GSB-New-App/identification.php')   {
    ?>
    <h1 id="titrePage">Identification utilisateur</h1>
    <?php
}
else    {
?>
		<h1 id="titrePage">Bienvenue sur l'intranet GSB</h1>
<?php 
}
?>
		<!-- Division pour le contenu principal -->
			