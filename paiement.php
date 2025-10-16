<?php
    $prix = $_GET['id'];
    $ok = false;
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Simulation de paiement</title>
</head>
<body>
    <main>
        <h2>Paiement </h2>
        <p>Montant à payer : <span><?= $prix ?></span></p>

        <form  method="post" action=""> 
            <label >Nom sur la carte</label>
            <input name="card_holder" type="text" placeholder="NOM PRENOM" value="<?= isset($card_holder) ? htmlspecialchars($card_holder) : '' ?>" required>

            <label>Numéro de carte (16 chiffres)</label>
            <input name="card_number" type="tel" inputmode="numeric" pattern="[0-9\s-]{19,}" placeholder="1234 5678 9012 3456" value="<?= isset($card_number_raw) ? htmlspecialchars($card_number_raw) : '' ?>" required>

                <div>
                    <label>Date de validité (mois/année)</label>
                    <input  name="expire" type="month" value="<?= isset($expire) ? htmlspecialchars($expire) : '' ?>" required>
                </div>
                <div >
                    <label>CVV</label>
                    <input name="cvv" type="tel" inputmode="numeric" maxlength="4" placeholder="123" value="<?= isset($cvv) ? htmlspecialchars($cvv) : '' ?>" required>
                </div>
                <button type="submit" name="paiement">Payer</button>
        </form>

    </main>

<?php
    if(!empty($_POST)){
        $errors = [];
    
            $card_number = $_POST['card_number'];
            // Validation : 16 chiffres
            if (strlen($card_number) !== 16 || !ctype_digit($card_number)) {
                $errors[] = 'Le numéro de carte doit contenir exactement 16 chiffres.';
            } 
            else {
                // Vérifier que le dernier chiffre est identique au premier
                if ($card_number[0] !== $card_number[15]) {
                    $errors[] = 'Le dernier chiffre de la carte doit être identique au premier.';
                }
            }
    
            // Validation date :$expire + 3 months
            $expire = $_POST['expire'];
            if (empty($expire)) {
                $errors[] = 'Veuillez saisir la date de validité (mois/année).';
            } 
            else {
                $expireDate = DateTime::createFromFormat('Y-m', $expire);
                if (!$expireDate) {
                    $errors[] = 'Format de date invalide. Utilisez le champ mois/année.';
                } 
                else {
                    // Considérer la fin du mois comme date d'expiration
                    $expireDate->modify('last day of this month')->setTime(23, 59, 59);
                    $datedexpiration = new DateTime();
                    // ajouter 3 mois au jour courant
                    $datedexpiration->modify('+3 months')->setTime(0, 0, 0);
    
                    if ($expireDate <= $datedexpiration) {
                        $errors[] = "La date de validité doit être supérieure au \"" . $datedexpiration->format('Y-m-d') . "\" (aujourd'hui + 3 mois).";
                    }
                }
            }
    
            // CVV (simple vérification)
            $cvv = $_POST['cvv'];

            if (strlen($cvv) < 3 || strlen($cvv) > 4 || !ctype_digit($cvv)) {
                $errors[] = 'CVV invalide (3 ou 4 chiffres).';
            }
            var_dump($errors);
            if (sizeof($errors) == 0) {
                $ok = true;
            }
        }
        if ($ok == true){ ?>
            <p>Paiement effectué  avec succès.</p>
    <?php }else{ ?>
        <p>Paiement refusé.</p>
    <?php } 
    
    ?>
</body>
<script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
</html>