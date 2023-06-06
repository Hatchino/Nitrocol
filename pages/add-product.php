<?php

if (isset($_SESSION['username'])) {
    if (isset($_POST['envoyer'])) {
        // Tableau pour stocker les éventuelles erreurs
        $errors = array();

        foreach ($_POST as $key => $value) {
            ${$key} = $value;
            if (empty($value)) {
                $errors[] = "Le champ $key doit être rempli.";
            }
        }

        if ($_FILES) {
            if (empty($_FILES['photo']['name'])) {
                $errors[] = 'Veuillez sélectionner une photo pour le produit.';
            } else {
                $tab_return_errors = upload_photo('photo');
                if ($tab_return_errors[0] == false) {
                    $errors[] = $tab_return_errors[1];
                } else {
                    $image = $tab_return_errors[1];
                }
            }
        }

        if (count($errors) === 0) {
            // Requête d'insertion sécurisée
            $query = "INSERT INTO produits (titre, descriptions, img, dates, avis, prix)
             VALUES (:titre , :descriptions, :img, :dates, :avis, :prix)";
            $stmt = $bdd->prepare($query);
            // Liaison des paramètres
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':descriptions', $description);
            $stmt->bindParam(':img', $image);
            $stmt->bindParam(':dates', $date);
            $stmt->bindParam(':prix', $price);
            $stmt->bindParam(':avis', $avis);

            // Exécuter la requête
            $stmt->execute();

            echo "<p>Produit bien enregistré</p>";
        }
    }
}

?>

<main>
    <h1>Ajouter un produit</h1>

    <?php if(isset($errors) && count($errors) > 0): ?>
        <div class="error">
            <ul>
                <?php foreach($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="index.php?page=add-product" method="post" enctype="multipart/form-data">
        <input type="hidden" name="date" value="<?php echo date("Y-m-d"); ?>">
        <label for="titre">Titre du produit</label>
        <input type="text" name="titre" id="titre">

        <label for="description">Description du produit</label>
        <textarea name="description" id="description" cols="30" rows="10"></textarea>

        <label for="photo">Photo</label>
        <input type="file" name="photo" id="photo">

        <label for="avis">Avis du produit</label>
        <textarea name="avis" id="avis" cols="30" rows="10"></textarea>

        <label for="price">Prix du produit</label>
        <input type="number" name="price" id="price">
        <input type="submit" name="envoyer" value="Envoyer">
    </form>
</main>
