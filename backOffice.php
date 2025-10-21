<?php
$pdo = new PDO('mysql:host=lakartxela.iutbayonne.univ-pau.fr;dbname=nmondeteguy_pro', 'nmondeteguy_pro', 'nmondeteguy_pro');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FiguDream - Back Office</title>
</head>

<body>
    <header>
        <!-- Logo -->
        <a href="index.php">
            <img src="" alt="Logo"> <!-- ICI -->
        </a>
        <!-- Panier -->
        <a href="panier.php" title="Lien vers le panier"> Panier </a>
        <!-- Back Office -->
        <a href="connexion.php" title="Lien vers le back office"> S'identifier </a>
    </header>

    <main>
        <h1>Ajouter une figurine</h1>
        <form method="post">
            <div>
                <label for="nom">Nom de la figurine : </label>
                <input type="text" name="nom" required />
            </div>
            <div>
                <label for="prix">Prix : </label>
                <input type="number" name="prix" required />
            </div>
            <div>
                <label for="image">Image : </label>
                <input type="file" name="image" required />
            </div>
            <div>
                <label for="quantite">Quantité : </label>
                <input type="number" name="quantite" required />
            </div>
            <input type="submit" name="addBdd" value="Ajouter à la base de données">
        </form>

        <h1>Retirer une figurine</h1>
        <form method="post">
            <div>
                <label for="nom">Nom de la figurine : </label>
                <input type="text" name="nom" />
            </div>
            <input type="submit" name="removeBdd" value="Retirer une figurine">
        </form>

        <h1>Modifier du stock</h1>
        <form method="post">
            <div>
                <label for="nom">Nom de la figurine : </label>
                <input type="text" name="nom" />
            </div>
            <div>
                <label for="quantite">Nouvelle quantité : </label>
                <input type="number" name="quantite" />
            </div>
            <input type="submit" name="modifyStock" value="Ajouter du stock">
        </form>
    </main>
    <?php
    $sql = "SELECT * FROM Figurine"; // ou ajuster la condition
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $utilisateur = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['addBdd']) == "Ajouter à la base de données") {
        // Recup des variables
        $nomFig = $_POST['nom'] ?? null;
        $prixFig = $_POST['prix'] ?? null;
        $imageFig = $_POST['image'] ?? null;
        $quantiteFig = $_POST['quantite'] ?? null;
        var_dump($_POST);

        $sql = "INSERT INTO Figurine(nom,prix,image,quantite) VALUES(?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nomFig, $prixFig, $imageFig, $quantiteFig]);
    }
    if (isset($_POST['modifyStock']) == "Ajouter du stock") {
        $nomFig = $_POST['nom'];
        $quantiteFig = $_POST['quantite'];
        if ($quantiteFig > 999 || $quantiteFig < 0) {
            print("<p>Valeur illégale</p>");
        } else {
            $sql = "UPDATE Figurine SET quantite = ? WHERE UPPER(Nom) = UPPER(?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$quantiteFig, $nomFig]);
        }
    }
    if (isset($_POST['removeBdd']) == "Ajouter à la base de données") {
        $nomFig = $_POST['nom'] ?? null;

        $sql = "DELETE FROM Figurine WHERE UPPER(nom) = UPPER(?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nomFig]);
    }

    ?>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>