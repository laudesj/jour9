<?php

/* Exemple minimaliste d'upload de fichier issu d'un formulaire */

// connexion à la base de données
require_once('db/connexion.php');
if(isset($_POST['ok'])) {
  
  // TODO : faire le contrôle des champs requis
  
  // On insère les données du formulaire via une requête préparée
  $stmt = $dbh->prepare("INSERT INTO clients (nom, prenom, adresse, cp, ville) VALUES (:nom, :prenom, :adresse, :cp, :ville)");
  $stmt->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
  $stmt->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
  $stmt->bindValue(':adresse', $_POST['adresse'], PDO::PARAM_STR);
  $stmt->bindValue(':cp', $_POST['cp'], PDO::PARAM_STR);
  $stmt->bindValue(':ville', $_POST['ville'], PDO::PARAM_STR);
  $stmt->execute();
  
  // Récupération de l'id du dernier enregistrement
  $id = $dbh->lastInsertId();

  // Renommage du fichier : on le préfixe avec l'id du client suivi d'un underscore
  $nom_fichier = $id . "_" . $_FILES['certificat']['name']; // le nom original du fichier certificat (provenant du client) est contenu dans $_FILES['certificat']['name']
  
  // On upload le fichier dans un répertoire uploads/ ; on doit s'assurer que celui-ci est accessible en écriture au minimum
  move_uploaded_file($_FILES['certificat']['tmp_name'], 'uploads/' . $nom_fichier); // le nom temporaire du fichier sur le serveur est contenu dans $_FILES['certificat']['tmp_name']

  // On met à jour afin d'enregistrer le nouveau nom du fichier certificat
  $stmt = $dbh->prepare("UPDATE clients SET certificat = :certificat WHERE id = :id");
  $stmt->bindValue(':certificat', $nom_fichier, PDO::PARAM_STR);
  $stmt->bindValue(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Formulaire d'inscription</title>
</head>
<body>
<form method="POST" action="" enctype='multipart/form-data'>
<input type="text" name="nom" placeholder="Nom"><br>
<input type="text" name="prenom" placeholder="Prénom"><br>
<input type="text" name="adresse" placeholder="Adresse"><br>
<input type="text" name="cp" placeholder="Code postal"><br>
<input type="text" name="ville" placeholder="Ville"><br>
<input type="file" name="certificat"><br>
<input type="submit" name="ok" value="Envoyer">
</form>
</body>
</html>