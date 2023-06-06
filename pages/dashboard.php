<?php

if ($_POST) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérification des champs vides
    if (empty($username) || empty($password)) {
        $msg_error = "Merci de rentrer vos identifiants.";
    } else {
        // Requête préparée
        $sql = "SELECT username, password_user FROM users WHERE username = :username";
        $stmt = $bdd->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $nbre_result = $stmt->rowCount();

        if ($nbre_result == 1) {
            $_SESSION['username'] = $username;
            header('Location: index.php?page=profil');
            exit(); 
        } else {
            $msg_error = "Identifiant ou mot de passe incorrect.";
        }
    }
}
?>

<main id="page-dashboard">
    <h1>Connexion</h1>

    <?php if(isset($msg_error)): ?>
        <div class="error"><?php echo $msg_error; ?></div>
    <?php endif; ?>

    <form action="" method="post">

        <label for="username">Identifiant</label>
        <input type="text" name="username" id="username" value="<?= $pseudo ?? ''; ?>">

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password">
        <input type="submit" value="Envoyer">
    </form>
</main>