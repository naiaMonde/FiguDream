<?php
//Connection à la base
# $pdo = new PDO('mysql:host=lakartxela.iutbayonne.univ-pau.fr;dbname=nmondeteguy_pro', 'nmondeteguy_pro', 'nmondeteguy_pro');

$pdo = new PDO('mysql:host=localhost;dbname=nmondeteguy_pro', 'root', ''); ?>
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
            <div class="card mb-3">
                <ul>
                    <?php
                    $id_fig = $_GET['id'];
                    $sql = "SELECT * FROM Figurine F WHERE F.id=:id_fig "; // ou ajuster la condition
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array(':id_fig' => $id_fig));
                    $figurine = $stmt->fetchAll(PDO::FETCH_ASSOC); // tableau de lignes
                    $figurine = $figurine[0];

                    ?>
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img class="img-fluid rounded-start" src="images/<?= htmlspecialchars($figurine['image'] ?? '') ?> ">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h3><?= htmlspecialchars($figurine['nom'] ?? '') ?></h3>
                                <h4><?= htmlspecialchars($figurine['prix'] ?? '') ?> €</h4>
                                <p>Quantité : <?= (int)($figurine['quantite'] ?? 0) ?></p>
                                <button type="button" class="btn btn-primary mb-2 ml-2">Ajouter au panier</button>
                            </div>
                        </div>


                </ul>
            </div>
        </section>
    </main>
</body>

</html>