<?php
    // Récupération des données pour se connecter par des variables d'environnement
    $db_host = 'serveur';
    $db_name = 'bdd';
    $db_user = 'cp_user';
    $db_password = 'pass';
    $db_port = '3306';

    // Connexion MysQL avec PDO
    try {
        $lien = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8;port=$db_port", $db_user, $db_password);
    } catch (PDOException $e) {

        $retour = array(
            'status' => 'error',
            'error_message' => 'Erreur de connexion à la base de données'
        );

        header('Content-Type: application/json');
        echo json_encode($retour);
        exit;
    }

?>
