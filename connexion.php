<?php
//Connection à la base
# $pdo = new PDO('mysql:host=lakartxela.iutbayonne.univ-pau.fr;dbname=nmondeteguy_pro', 'nmondeteguy_pro', 'nmondeteguy_pro');

$pdo = new PDO('mysql:host=localhost;dbname=nmondeteguy_pro', 'root', '');

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
    } else if ($utilisateur['mdp'] == $_POST['mdp'] && $utilisateur['admin'] == 0) {
        print("<h1>Connexion OK</h1>");
    } else {
        print("<h1>Connexion refusée</h1>");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel='stylesheet' type='text/css' href='style.css'>
    <title>FiguDream</title>
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">FiguDream</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="panier.php">Panier</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="connexion.php">S'identifier</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container">
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

        <p>Pseudo: admin; mdp: admin</p>

    </main>



</body>

</html>