<?php
//Connection à la base
$pdo = new PDO('mysql:host=lakartxela.iutbayonne.univ-pau.fr;dbname=nmondeteguy_pro', 'nmondeteguy_pro', 'nmondeteguy_pro');


if (isset($_POST['submit'])) {

    $pseudo = strip_tags($_POST['pseudo']);
    $mdp = strip_tags($_POST['mdp']);

    $sql = "SELECT pseudo, mdp, admin FROM Utilisateur WHERE pseudo = '$pseudo'"; // ou ajuster la condition
    $stmt = $pdo->prepare($sql);
    $stmt->execute();


    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC); // tableau de lignes

    if ($utilisateur['mdp'] == $_POST['mdp'] && $utilisateur['admin'] == 1) {
        header('Location: backOffice.php');
        exit;
    } else if ($utilisateur['mdp'] == $_POST['mdp'] && $utilisateur['admin'] == 0){
        print("<h1>Connexion OK</h1>");
    }
    else {
        print("<h1>Connexion refusée</h1>");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="node_modules/bootstrap/dist/css/bootstrap.css">
    <script source="node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
    <link rel='stylesheet' type='text/css' href='style.css'>
    <title>FiguDream</title>
</head>

<body>

    <header>
        <!-- Logo -->
        <a href="index.html">
            <img src="" alt="Logo"> <!-- ICI -->
        </a>
        <!-- Panier -->
        <a href="panier.php" title="Lien vers le panier"> Panier </a>
        <!-- Back Office -->
        <a href="connexion.php" title="Lien vers le back office"> S'identifier </a>
    </header>

    <main>
        <form method="post">
            <div>
                <label for="pseudo">Pseudonyme : </label>
                <input type="text" name="pseudo" />
            </div>
            <div>
                <label for="mdp">Mot de passe : </label>
                <input type="password" name="mdp" />
            </div>
            <input type="submit" name="submit" value="Se connecter" />

        </form>

    </main>



</body>

</html>