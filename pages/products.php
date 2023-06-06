<?php

    $sql = "SELECT titre, descriptions, img, dates, avis, prix FROM produits";
    $stmt = $bdd->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<main id="products">
    <h1>Liste des produits</h1>

    <?php if (!empty($products)): ?>
        <table>
            <tr>
                <th>Titre</th>
                <th>Description</th>
                <th>Avis</th>
                <th>Dates</th>
                <th>Image</th>
                <th>Prix</th>
            </tr>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['titre']; ?></td>
                    <td><?php echo $product['descriptions']; ?></td>
                    <td><?php echo $product['avis']; ?></td>
                    <td><?php echo $product['dates']; ?></td>
                    <td><img src="<?php echo $product['img']; ?>" alt="<?php echo $product['titre']; ?>"></td>
                    <td><?php echo $product['dates']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Aucun produit trouvé.</p>
    <?php endif; ?>
</main>