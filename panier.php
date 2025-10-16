<?php
    session_start();
    //Connection à la base
    $pdo = new PDO('mysql:host=lakartxela.iutbayonne.univ-pau.fr;dbname=nmondeteguy_pro', 'nmondeteguy_pro', 'nmondeteguy_pro');
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
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
        <a href="backOffice.php" title="Lien vers le back office"> S'identifier </a> 
    </header>

    <main>

        

    <ul>
        <?php
        var_dump($_SESSION['panier']);

        if (isset($_SESSION)) { 
            $prixTotal = 0; 
            foreach ($_SESSION['panier'] as $id):
                var_dump($id);
                $sql = "SELECT * FROM Figurine F WHERE F.id=:id ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['id' => $id]);

                $figurine = $stmt->fetch(PDO::FETCH_ASSOC); // tableau de lignes
            
                $idFig = htmlspecialchars($figurine["id"]); 
                $prixTotal += htmlspecialchars($figurine['prix'] ?? '');
        ?>
            <li>
                    <img src="images/<?= htmlspecialchars($figurine['image'] ?? '')?> ">
                    <h3><?= htmlspecialchars($figurine['nom'] ?? '') ?></h3>
                    <h4><?= htmlspecialchars($figurine['prix'] ?? '') ?> €</h4>

                <!-- <form method="POST">
                    <input type="hidden" name="idFig" value="<?= $idFig ?>">
                    <button type="submit">Ajouter au panier</button>
                </form> -->
            </li>
    <?php endforeach;}?>
        <section>
                <h1>Total</h1>
                <h4><?= htmlspecialchars($prixTotal ?? '') ?> €</h4>
                <a href="paiement.php?id=<?= $prixTotal ?>" >
                    <button type="button">Payer</button>
                </a>
            </section>
    </ul>
    </main>
</body>
</html>