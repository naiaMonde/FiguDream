<?php

    session_start();

    //Connection à la base
    $pdo = new PDO('mysql:host=lakartxela.iutbayonne.univ-pau.fr;dbname=nmondeteguy_pro', 'nmondeteguy_pro', 'nmondeteguy_pro');

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
    </head>
<body>
<header> 
    <!-- Logo --> 
    <a href="index.php"> 
    <img src="" alt="Logo" > <!-- ICI --> 
    </a> 
    <!-- Panier --> 
    <a href="panier.php" title="Lien vers le panier"> Panier </a> 
    <!-- Back Office --> 
    <a href="connexion.php" title="Lien vers le back office"> S'identifier </a> 
</header>
    <main>
        <section>
            <ul>
            <?php foreach ($figurines as $figurine): 
                $idFig = htmlspecialchars($figurine["id"]); 
                ?>
                    <li>
                        <a href="article.php?id=<?= $idFig ?>" >
                            <img src="images/<?= htmlspecialchars($figurine['image'] ?? '')?> ">
                            <h3><?= htmlspecialchars($figurine['nom'] ?? '') ?></h3>
                            <h4><?= htmlspecialchars($figurine['prix'] ?? '') ?> €</h4>
                            <p>Quantité : <?= (int)($figurine['quantite'] ?? 0) ?></p>
                        </a>
                        
                        <form method="POST">
                            <input type="hidden" name="idFig" value="<?= $idFig ?>">
                            <button type="submit">Ajouter au panier</button>
                        </form>
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
                var_dump($_SESSION);
            ?>
            </ul>
        </section>
    </main>
    <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>