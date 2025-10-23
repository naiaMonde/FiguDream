<?php
# $pdo = new PDO('mysql:host=lakartxela.iutbayonne.univ-pau.fr;dbname=nmondeteguy_pro', 'nmondeteguy_pro', 'nmondeteguy_pro');

$pdo = new PDO('mysql:host=localhost;dbname=nmondeteguy_pro', 'root', '');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <title>FiguDream - Back Office</title>
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
        <div class="row">
            <div class="col">
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
            </div>
            <div class="col">
                <h1>Retirer une figurine</h1>
                <form method="post">
                    <div>
                        <label for="nom">Nom de la figurine : </label>
                        <input type="text" name="nom" />
                    </div>
                    <input type="submit" name="removeBdd" value="Retirer une figurine">
                </form>

            </div>
            <div class="col">
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
            </div>
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

        $sql = "INSERT INTO Figurine(nom,prix,image,quantite) VALUES(?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nomFig, $prixFig, $imageFig, $quantiteFig]);

        if (is_uploaded_file($_FILES['image']['tmp_name'])) {
            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                'images/' . $_FILES['image']['name']
            );
        }
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