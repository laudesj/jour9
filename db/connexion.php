<?php
$user = "root";
$password = "";
try {
	$dbh = new PDO('mysql:host=127.0.0.1;dbname=jour9;charset=utf8', $user, $password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // mode de gestion d'erreur
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // http://php.net/manual/fr/pdo.setattribute.php
} catch(PDOException $e) {
	echo $e->getMessage();
}