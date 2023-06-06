<?php

    $sql = "SELECT username, f_name, l_name, admin, img FROM users";
    $stmt = $bdd->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<main id="users">
    <h1>Liste des utilisateurs</h1>

    <?php if (!empty($users)): ?>
        <table>
            <tr>
                <th>Nom d'utilisateur</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Admin</th>
                <th>Image de profil</th>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['f_name']; ?></td>
                    <td><?php echo $user['l_name']; ?></td>
                    <td><?php echo $user['admin'] == 1 ? 'Oui' : 'Non'; ?></td>
                    <td><img src="img/<?php echo $user['img']; ?>" alt="<?php echo $user['username']; ?>"></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Aucun utilisateur trouvé.</p>
    <?php endif; ?>
</main>