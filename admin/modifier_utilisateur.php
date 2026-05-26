<?php
// je charge la connexion et je verifie que c'est un admin
require_once '../config/db.php';
require_once '../includes/auth.php';
exigerAdmin();

// je recupere l'id dans l'URL
$id = intval($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: utilisateurs.php'); exit; }

// je cherche l'utilisateur dans la base
$req = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = :id");
$req->execute([':id' => $id]);
$user = $req->fetch();

// si il existe pas je redirige
if (!$user) { header('Location: utilisateurs.php'); exit; }

require_once '../includes/header.php';
?>

<h2>Modifier l'utilisateur</h2>

<!-- je pre-remplis le formulaire avec les donnees actuelles de l'utilisateur -->
<form method="POST" action="traiter_modifier_user.php">
    <input type="hidden" name="id" value="<?= $user['id'] ?>">

    <label for="prenom">Prenom</label>
    <input type="text" id="prenom" name="prenom" required maxlength="100"
           value="<?= htmlspecialchars($user['prenom'], ENT_QUOTES, 'UTF-8') ?>">

    <label for="nom">Nom</label>
    <input type="text" id="nom" name="nom" required maxlength="100"
           value="<?= htmlspecialchars($user['nom'], ENT_QUOTES, 'UTF-8') ?>">

    <label for="email">Email</label>
    <input type="email" id="email" name="email" required maxlength="150"
           value="<?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?>">

    <!-- si on laisse vide le mot de passe reste le meme -->
    <label for="mot_de_passe">Nouveau mot de passe <small>(laisser vide pour ne pas changer)</small></label>
    <input type="password" id="mot_de_passe" name="mot_de_passe" minlength="6">

    <label for="role">Role</label>
    <select id="role" name="role">
        <option value="utilisateur" <?= $user['role'] === 'utilisateur' ? 'selected' : '' ?>>Utilisateur</option>
        <option value="admin"       <?= $user['role'] === 'admin'       ? 'selected' : '' ?>>Admin</option>
    </select>

    <button type="submit" class="btn">Enregistrer</button>
    <a href="utilisateurs.php" style="margin-left: 1rem;">Annuler</a>
</form>

<?php require_once '../includes/footer.php'; ?>
