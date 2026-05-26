<?php
// je charge la connexion, je verifie la session et je verifie que c'est un admin
require_once '../config/db.php';
require_once '../includes/auth.php';
exigerAdmin();
require_once '../includes/header.php';

// je recupere tous les utilisateurs dans la base
$users = $pdo->query("SELECT * FROM utilisateurs ORDER BY created_at DESC")->fetchAll();
?>

<h2>Gestion des utilisateurs</h2>
<p style="margin-bottom: 1rem;">
    <a href="ajouter_utilisateur.php" class="btn">+ Nouvel utilisateur</a>
</p>

<?php if (isset($_GET['succes'])): ?>
    <p class="alert alert-success">Operation effectuee avec succes.</p>
<?php endif; ?>

<?php if (empty($users)): ?>
    <p>Aucun utilisateur trouve.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Prenom Nom</th>
                <th>Email</th>
                <th>Role</th>
                <th>Cree le</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['prenom'] . ' ' . $user['nom'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($user['role'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                <td>
                    <a href="modifier_utilisateur.php?id=<?= $user['id'] ?>">Modifier</a>
                    <?php if ($user['id'] !== $_SESSION['user_id']): ?>
                        &nbsp;|&nbsp;
                        <!-- je cache le bouton supprimer pour eviter qu'un admin se supprime lui meme -->
                        <a href="supprimer_utilisateur.php?id=<?= $user['id'] ?>"
                           class="lien-supprimer" style="color: #dc2626;">Supprimer</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<script src="../assets/app.js"></script>
<?php require_once '../includes/footer.php'; ?>
