<?php

require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";
$uploadConfig = require $_SERVER['DOCUMENT_ROOT'] . "/classemetier/configpilote.php";

// Initialisation de la réponse JSON
$reponse = array("success" => false, "error" => array());

try {
    // Vérification des données reçues
    if (!isset($_POST['table']) || $_POST['table'] !== 'pilote') {
        throw new Exception('Requête invalide.');
    }

    // Récupération des données
    $id = intval($_POST['id']);
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $idPays = trim($_POST['idPays']);
    $idEcurie = intval($_POST['idEcurie']);
    $numPilote = intval($_POST['numPilote']);

    // Validation des données
    if (empty($id) || empty($nom) || empty($prenom) || empty($idPays) || empty($idEcurie) || empty($numPilote)) {
        Erreur::envoyerReponse('Tous les champs sont obligatoires.');
    }

    if (!is_numeric($id) || !is_numeric($idEcurie) || !is_numeric($numPilote)) {
        Erreur::envoyerReponse('Les champs ID, ID Écurie et Numéro du pilote doivent être numériques.');
    }

    // Validation du fichier photo
    if (!isset($_FILES['photo'])) {
        Erreur::envoyerReponse('Aucun fichier photo téléchargé.');
    }

    if ($_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
        Erreur::envoyerReponse('Erreur lors du téléchargement de la photo.');
    }

    $photoInfo = $_FILES['photo'];

    // Vérifier la taille du fichier
    if ($photoInfo['size'] > $uploadConfig['maxSize']) {
        Erreur::envoyerReponse('La taille de la photo dépasse la limite autorisée.');
    }

    // Vérifier le type MIME de la photo
    $mimeType = mime_content_type($photoInfo['tmp_name']);
    if (!in_array($mimeType, $uploadConfig['types'])) {
        throw new Exception('Le format de la photo est invalide. Formats acceptés : ' . implode(', ', $uploadConfig['types']));
    }

    // Vérifier l'extension du fichier
    $extension = strtolower(pathinfo($photoInfo['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, $uploadConfig['extensions'])) {
        throw new Exception('L\'extension de la photo est invalide. Extensions acceptées : ' . implode(', ', $uploadConfig['extensions']));
    }

    // Obtenir le nom du fichier sans le chemin
    $nomPhoto = basename($photoInfo['name']);

    // Insertion du pilote dans la base de données
    $db = Database::getInstance();

    // Vérification des duplicatas
    $stmt = $db->prepare("SELECT COUNT(*) FROM pilote WHERE id = :id OR (nom = :nom AND prenom = :prenom AND idEcurie = :idEcurie)");
    $stmt->execute(['id' => $id, 'nom' => $nom, 'prenom' => $prenom, 'idEcurie' => $idEcurie]);
    if ($stmt->fetchColumn() > 0) {
        throw new Exception('Un pilote avec ce numéro ou ces informations existe déjà.');
    }

    // Vérification des doublons pour la clé étrangère idEcurie
    $stmt = $db->prepare("SELECT COUNT(*) FROM pilote WHERE idEcurie = :idEcurie");
    $stmt->execute(['idEcurie' => $idEcurie]);
    $count = $stmt->fetchColumn();
    if ($count > 3) {
        throw new Exception('Vous ne pouvez pas ajouter plus de 4 pilotes à cette écurie.');
    }

    // Vérification des doublons pour la photo
    $stmt = $db->prepare("SELECT COUNT(*) FROM pilote WHERE photo = :photo");
    $stmt->execute(['photo' => $nomPhoto]);
    if ($stmt->fetchColumn() > 0) {
        throw new Exception('Une photo avec ce nom existe déjà.');
    }

    // Insertion des données dans la base de données
    $stmt = $db->prepare("INSERT INTO pilote (id, nom, prenom, idPays, idEcurie, numPilote, photo) VALUES (:id, :nom, :prenom, :idPays, :idEcurie, :numPilote, :photo)");
    $stmt->execute([
        'id' => $id,
        'nom' => $nom,
        'prenom' => $prenom,
        'idPays' => $idPays,
        'idEcurie' => $idEcurie,
        'numPilote' => $numPilote,
        'photo' => $nomPhoto
    ]);

    // Si l'insertion est réussie, mettre à jour la réponse
    $reponse['success'] = true;

} catch (Exception $e) {
    $reponse['error']['global'] = $e->getMessage();
}


echo json_encode($reponse,JSON_UNESCAPED_UNICODE);
?>
