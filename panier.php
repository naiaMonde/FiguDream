<?php
session_start();
//Connection à la base
# $pdo = new PDO('mysql:host=lakartxela.iutbayonne.univ-pau.fr;dbname=nmondeteguy_pro', 'nmondeteguy_pro', 'nmondeteguy_pro');

$pdo = new PDO('mysql:host=lakartxela.iutbayonne.univ-pau.fr;dbname=nmondeteguy_pro', 'nmondeteguy_pro', 'nmondeteguy_pro');    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <title>Panier</title>
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
            <div class="card mb-3">
                <ul class="list-unstyled list-group-flush list-group">
                    <?php

                    if (isset($_SESSION)) {
                        $prixTotal = 0;
                        foreach ($_SESSION['panier'] as $id):
                            $sql = "SELECT * FROM Figurine F WHERE F.id=:id ";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute(['id' => $id]);

                            $figurine = $stmt->fetch(PDO::FETCH_ASSOC); // tableau de lignes

                            $idFig = htmlspecialchars($figurine["id"]);
                            $prixTotal += htmlspecialchars($figurine['prix'] ?? '');
                    ?>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img style="max-height: 300px;" src="images/<?= htmlspecialchars($figurine['image'] ?? '') ?> ">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h3 class="card-title"><?= htmlspecialchars($figurine['nom'] ?? '') ?></h3>
                                            <h4 class="card-text"><?= htmlspecialchars($figurine['prix'] ?? '') ?> €</h4>
                                        </div>
                                    </div>
                            </li>
                    <?php endforeach;
                    } ?>
                    <div class="card-footer">
                        <h1>Total</h1>
                        <h4><?= htmlspecialchars($prixTotal ?? '') ?> €</h4>
                        <a href="paiement.php?id=<?= $prixTotal ?>">
                            <button class="btn btn-primary mb-2 ml-2" type="button">Payer</button>
                        </a>
                    </div>
        </section>
        </ul>
    </main>
</body>

</html>