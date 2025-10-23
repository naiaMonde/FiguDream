<?php

session_start();

//Connection à la base
$pdo = new PDO('mysql:host=localhost;dbname=nmondeteguy_pro', 'root', '');

$sql = "SELECT * FROM Figurine"; // ou ajuster la condition
$stmt = $pdo->prepare($sql);
$stmt->execute();

$figurines = $stmt->fetchAll(PDO::FETCH_ASSOC); // tableau de lignes

?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>FiguDream</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
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
        <section>
            <ul class="row list-unstyled    ">
                <?php foreach ($figurines as $figurine):
                    $idFig = htmlspecialchars($figurine["id"]);
                ?>
                    <li class="col-md-4 mb-4">
                        <div class="card">
                            <a class="link-underline-opacity-0" href="article.php?id=<?= $idFig ?>">
                                <img class="card-img-top" src="images/<?= htmlspecialchars($figurine['image'] ?? '') ?> ">
                                <div class="card-body">
                                    <h3 class="card-title"><?= htmlspecialchars($figurine['nom'] ?? '') ?></h3>
                                    <h4 class="card-text"><?= htmlspecialchars($figurine['prix'] ?? '') ?> €</h4>
                                    <p class="card-text">Quantité : <?= (int)($figurine['quantite'] ?? 0) ?></p>
                                </div>


                            </a>

                            <form method="POST">
                                <input type="hidden" name="idFig" value="<?= $idFig ?>">
                                <button class="btn btn-primary mb-2 ml-2" type="submit">Ajouter au panier</button>
                            </form>

                        </div>
                    </li>
                <?php
                endforeach;
                // Si le bouton a été cliqué
                if (isset($_POST['idFig'])) {
                    $idFig = (int)$_POST['idFig'];
                    // On ajoute l'id dans la session (panier)
                    if (!isset($_SESSION['panier'])) {
                        $_SESSION['panier'] = [];
                    }

                    // Si l’article n’existe pas encore, on l’ajoute
                    if (isset($_SESSION['panier'])) {
                        $_SESSION['panier'][] = $idFig;
                    }
                }

                ?>
            </ul>
        </section>
    </main>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>