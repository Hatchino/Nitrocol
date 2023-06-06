<?php
if (isset($_SESSION['username'])) {
    $hello = 'Bonjour ' . $_SESSION['username'];
    $username = $_SESSION['username'];

    // Requête préparée pour récupérer les informations de l'utilisateur
    $sql = "SELECT username, f_name, l_name, admin, img FROM users WHERE username = :username";
    $stmt = $bdd->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<main id="page-profil">
    <h1>Mon profil d'utilisateur</h1>

    <?php if (isset($user)): ?>
        <div>
            <p>Nom d'utilisateur: <?php echo $user['username']; ?></p>
            <p>Prénom: <?php echo $user['f_name']; ?></p>
            <p>Nom: <?php echo $user['l_name']; ?></p>
            <p>Admin: <?php echo $user['admin'] == 1 ? 'Oui' : 'Non'; ?></p>
            <img src="img/<?php echo $user['img']; ?>" alt="<?php echo $user['username']; ?>">
        </div>
        <button class="all-users button">
            <a href="index.php?page=all-users">Voir tous les utilisateurs</a>
        </button>
        <button class="add-product button">
            <a href="index.php?page=add-product">Ajouter un produit</a>
        </button>
        <button class="product button">
            <a href="index.php?page=products">Voir les produits</a>
        </button>

    <?php endif; ?>
</main>
