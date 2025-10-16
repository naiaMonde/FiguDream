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
        <a href="index.html">
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
                <input type="text" name="nom" />
            </div>
            <div>
                <label for="prix">Prix : </label>
                <input type="number" name="prix" />
            </div>
            <div>
                <label for="image">Image : </label>
                <input type="file" name="image" />
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

        <h1>Ajouter du stock</h1>
        <form method="post">
            <div>
                <label for="nom">Nom de la figurine : </label>
                <input type="text" name="nom" />
            </div>
            <div>
                <label for="prix">Nombre à ajouter : </label>
                <input type="number" name="prix" />
            </div>
            <input type="submit" name="addStock" value="Ajouter du stock">

            <h1>Retirer du stock</h1>
            <form method="post">
                <div>
                    <label for="nom">Nom de la figurine : </label>
                    <input type="text" name="nom" />
                </div>
                <div>
                    <label for="prix">Nombre à retirer : </label>
                    <input type="number" name="prix" />
                </div>
                <input type="submit" name="removeStock" value="Retirer du stock">
            </form>
        </form>
    </main>
    <?php
    $sql = "SELECT * FROM Figurine"; // ou ajuster la condition
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $utilisateur = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['addBdd']) == "Ajouter à la base de données") {
        print("Add BDD");
    }
    if (isset($_POST['addStock']) == "Ajouter du stock") {
        print("Add Stock");
    }
    if (isset($_POST['removeBdd']) == "Ajouter à la base de données") {
        print("Retirer BDD");
    }
    if (isset($_POST['removeStock']) == "Ajouter du stock") {
        print("Retirer Stock");
    }

    ?>
    <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>

</html>