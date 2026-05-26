<?php
// je verifie que c'est bien un admin qui accede a cette page
require_once '../includes/auth.php';
exigerAdmin();
require_once '../includes/header.php';
?>

<h2>Nouvel utilisateur</h2>

<!-- formulaire pour creer un utilisateur -->
<form method="POST" action="traiter_ajouter_user.php">

    <label for="prenom">Prenom</label>
    <input type="text" id="prenom" name="prenom" required maxlength="100">

    <label for="nom">Nom</label>
    <input type="text" id="nom" name="nom" required maxlength="100">

    <label for="email">Email</label>
    <input type="email" id="email" name="email" required maxlength="150">

    <label for="mot_de_passe">Mot de passe</label>
    <input type="password" id="mot_de_passe" name="mot_de_passe" required minlength="6">

    <label for="role">Role</label>
    <select id="role" name="role">
        <option value="utilisateur">Utilisateur</option>
        <option value="admin">Admin</option>
    </select>

    <button type="submit" class="btn">Creer</button>
    <a href="utilisateurs.php" style="margin-left: 1rem;">Annuler</a>

</form>

<?php require_once '../includes/footer.php'; ?>
