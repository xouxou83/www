<?php
/*
 * Page pour le choix du vehicule utilise pour les trajets professionnels des visiteurs
 * @package GSB-AppliFrais
 * @author x@ux@u   (basé sur )
 * @projet Gsb-AppliFrais
 * @todo RAS
 */


$repInclude = './Include/';
$repIncludeVisiteur = './Include/Visiteur/';

require( $repInclude . '_initialisation.inc.php');

$etape = lireDonneePost("etape","typeVehicule");

?>		<form action="" method="post">
			<input type="hidden" name="choixVehicule" value="validerSaisie" />
				<h2>Selectionnez votre véhicule :</h2>
<?php
            var_dump($etape);
            /*
             * Choix du type de vehicules
             */    
?>
				<p>
					<label for="typeVehicule">Type de véhicules :</label>
    					<SELECT name="typeVehicule">
<?php 
                            $typeVehicule = array('Voiture','Moto < 50cm3','Moto > 50cm3');

                            $selection = '';
                            foreach ($typeVehicule as $vehicule)	{
                                if($vehicule == $typeVehicule)	{
                                    $selection = 'selected = "selected"';
                                }
                                    // Affichage de la ligne
                                echo "\t",'<option value="', $vehicule ,'"', $selection ,'>', $vehicule ,'</option >',"\n";
                                    // Remise a zéro de $Selected
                                $selection='';
                            }
                            echo '</SELECT>',"\n";


            /*
             * Si le type de vehicule est une voiture :
             *  Selection de la puissance fiscale
             */
?>
    			</p>
		</form>
<?php 
    if ($etape == "Voiture")    {
?>		<form action="" method="post">
			<p>
				<label for="puissanceAuto">Puissance du véhicule :</label>
    				<SELECT name="puissanceAuto">    		
<?php 
                        $puissanceAuto = array(0 => "Sélectionnez la puissance", 3 => "3 CV et Moins", 4 => "4 CV", 5 => "5 CV", 6 => "6 CV", 7 => "7 CV et plus");
                        var_dump($etape);
                        $selection = '';
                        foreach ($puissanceAuto as $puissance)	{
                            if($puissance == $puissanceAuto)	{
                                $selection = 'selected = "selected"';
                            }
                                // Affichage de la ligne
                            echo "\t",'<option value="', $puissance ,'"', $selection ,'>', $puissance ,'</option >',"\n";
                                // Remise a zéro de $Selected
                            $selection='';
                        }
                        echo '</SELECT>',"\n";
    }
?>
			</p>
		</form>
<?php 
/*
 * Si le type de vehicule est une voiture :
 * Distance parcourue en voiture
 */
?>
		<form>
			<p>
				<label for="distance">Saisissez la distance :</label>
					<input type="number" name="distance" value="distance"/>
<?php

                                    // 1er choix type. Selon type: cinlindree puis distance pour tous mais que quand vehicule choisi

    if  ($etape == "distance")  {
        if (isset($_POST['distance']))    {
            $d = $_POST['distance'];
            if ($d < 5000)  {
                $tarif = $d * 0.41;
            }
            elseif (5000 < $d  and $d < 20000)      {
                $tarif = $d * 0.493;
            }
            elseif ($d > 20000)     {
                $tarif = $d * 0.568;
            }
        }
    }

        $colone1 = array(3 => $d * 0.41, 4 => $d * 0.493, 5 => $d * 0.543, 6 => $d * 0.568, 7 => $d * 0.595);
        $distanceAuto = array(0 => "Sélectionnez la distance", 1 => "Moins de 5 000 Km", 2 => "De 5 001 à 20 000 Km", 3 => "Plus de 20 000 Km");
        
        
?>
			</p>
		</form>
<?php 
$distanceMoto1 = array(0 => "Sélectionnez la distance", 1 => "Moins de 2 000 Km", 2 => "De 2 001 à 5 000 Km", 3 => "Plus de 5 000 Km");
$distanceMoto2 = array(0 => "Sélectionnez la distance", 1 => "Moins de 3 000 Km", 2 => "De 3 001 à 6 000 Km", 3 => "Plus de 6 000 Km");

/*
$selection = '';
foreach ($typeVehicule as $vehicule)	{
    if($vehicule == $typeVehicule)	{
        $selection = 'selected = "selected"';
    } 
    // Affichage de la ligne
    echo "\t",'<option value="', $vehicule ,'"', $selection ,'>', $vehicule ,'</option >',"\n";
    // Remise a zéro de $Selected
    $selection='';
}
echo '</SELECT>',"\n";

if  ($selection == $typeVehicule[0])    {

    
    $colone2 = array(3 => ($d * 0.245) + 824, 4 => ($d * 0.277) + 1082, 5 => ($d * 0.305) + 1188, 6 => ($d * 0.32) + 1244, 7 => ($d * 0.337) + 1288);
    $colone3 = array(3 => $d * 0.286, 4 => $d * 0.332, 5 => $d * 0.364, 6 => $d * 0.382, 7 => $d * 0.401);
}

if ($selection == $typeVehicule[1]) {
    
    $colone1 = $d * 0.269;
    $colone2 = ($d * 0.063) + 412;
    $colone3 = $d * 0.146;
}

if ($selection == $typeVehicule[2]) {
    
    $colone1 = array(3 => $d * 0.338, 4 => ($d * 0.084)+760, 5 => $d * 0.211);
    $colone2 = array(3 => $d * 0.4, 4 => ($d * 0.070) + 989, 5 => $d * 0.235);
    $colone3 = array(3 => $d * 0.518, 4 => ($d * 0.067) + 1351, 5 => $d * 0.292);
    
}

?>

	<h2>Selectionnez votre véhicule :</h2>
	<p>
		<label for="Marquevoiture">Marque :</label>
    		<SELECT name="Marquevoiture">	
<?php 
    $selection = '';
    foreach ($cinlindre as $vehicule)	{
        if($vehicule == $typeVehicule)	{
	        $selection = 'selected = "selected"';
	    }
	       // Affichage de la ligne
	    echo "\t",'<option value="', $vehicule ,'"', $selection ,'>', $vehicule ,'</option >',"\n";
	        // Remise a zéro de $Selected
	    $selection='';
    }
    echo '</SELECT>',"\n";
*/
?>
