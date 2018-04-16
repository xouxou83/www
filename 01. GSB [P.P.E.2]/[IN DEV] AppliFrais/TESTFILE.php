<?php
/*
   mysqli::__construct($host_name = ini_get("mysqli.default_host") ,$login = ini_get("mysqli.delt_user"), $password = ini_get("mysqli.default_pw"), $dbname = "appli-ffaurais", $port = ini_get("mysqli.default_port"))
?>

<?php
$mysqli = new mysqli('localhost', 'dANDre', 'oppg5', 'gsb-appfrais-visiteur');

/*
 * Ceci est le style POO "officiel"
 * MAIS $connect_error etait errone jusqu'en PHP 5.2.9 et 5.3.0.
 
if ($mysqli->connect_error) {
    die('Erreur de connexion (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

/*
 * Utilisez cette syntaxe de $connect_error si vous devez assurer
 * la compatibilite avec les versions de PHP avant 5.2.9 et 5.3.0.
 
*if (mysqli_connect_error()) {
    die('Erreur de connexion (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
}

echo 'Succes... ' . $mysqli->host_info . "\n";

$mysqli->close();
*/?>
<?php
/* Connexion à une base ODBC avec l'invocation de pilote */
/*$dsn = 'uri:http://localhost/phpmyadmin/gsb-appfrais-visiteur';
$user = 'login';
$password = 'mdp';

try {
    $dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Connexion echouee : ' . $e->getMessage();
}

*/?>
<?php
/*
$host_name = "localhost";
$database = "gsb-appfrais-visiteur";
$login = "root";
$password = "";


$connect = mysqli_connect($host_name, $login, $password, $database);

if(mysqli_connect_errno())
{
echo '<p>La connexion au serveur MySQL a echoue: '.mysqli_connect_error().'</p>';
}
else
{
echo '<p>Connexion au serveur MySQL etablie avec succes.</p>';
}
?>
*/

echo( $_SERVER['PHP_SELF']);