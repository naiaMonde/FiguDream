<?php
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
    <a href="page_accueil.html"> 
    <img src="" alt="Logo" > <!-- ICI --> 
    </a> 
    <!-- Panier --> 
    <a href="panier.php" title="Lien vers le panier"> Panier </a> 
    <!-- Back Office --> 
    <a href="backOffice.php" title="Lien vers le back office"> S'identifier </a> 
</header>
    <main>
        <section>
            <ul>
                <?php
                    $id_fig = $_GET['id'];
                    $sql = "SELECT * FROM Figurine F WHERE F.id=:id_fig "; // ou ajuster la condition
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array(':id_fig' => $id_fig));
                    $figurine = $stmt->fetchAll(PDO::FETCH_ASSOC); // tableau de lignes
                    $figurine = $figurine[0];
                    
                ?>
                    <img src="images/<?= htmlspecialchars($figurine['image'] ?? '')?> ">
                    <h3><?= htmlspecialchars($figurine['nom'] ?? '') ?></h3>
                    <h4><?= htmlspecialchars($figurine['prix'] ?? '') ?> €</h4>
                    <p>Quantité : <?= (int)($figurine['quantite'] ?? 0) ?></p>
                    <button type="button">Ajouter au panier</button>

            </ul>
        </section>
    </main>
</body>
</html>