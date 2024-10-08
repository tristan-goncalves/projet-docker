<?php
    include 'connect.php';

    // Si le formulaire a été soumis
    if (!empty($_GET['q'])) {
        $q = $_GET['q'];
    } else {
        $q = '';
    }
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code postaux</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Code Postaux</h1>

        <form action="" method="get">
            <div>
                <input type="search" name="q" placeholder="Entrer un code postal ou le nom d'une ville" value="<?= $q ?>" autocomplete="one-time-code">
                <input type="submit" value="Rechercher">    
            </div>
        </form>

        <div class="resultats">
            <?php
                if (!empty($q)) {

                    // Si la requête ne contient que des chiffres, on recherche par code postal
                    if (ctype_digit($q)) {
                        $sql = "SELECT Code_postal AS cp_code, Nom_commune AS cp_ville 
                                FROM codepostal
                                WHERE Code_postal LIKE :cp
                                ORDER BY cp_code ASC";
                        $prep = $lien->prepare($sql);
                        $prep->bindValue(':cp', $q.'%');
                        $prep->execute();
                    } else {
                        // Sinon, on recherche par nom de ville
                        $sql = "SELECT Code_postal AS cp_code, Nom_commune AS cp_ville 
                                FROM codepostal
                                WHERE Nom_commune LIKE :ville
                                ORDER BY cp_code ASC";
                        $prep = $lien->prepare($sql);
                        $prep->bindValue(':ville', '%'.$q.'%');
                        $prep->execute();
                    }
                    
                    while ($cp = $prep->fetch(PDO::FETCH_ASSOC)) {
                        echo '<div class="ligne">';
                        echo '<span class="cp">'.$cp['cp_code']. '</span>';
                        echo '<span class="ville">'.$cp['cp_ville'].'</span>';
                        echo "</div>";
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>
