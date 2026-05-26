<?php
// je charge la connexion et je verifie que l'utilisateur est connecte
require_once 'config/db.php';
require_once 'includes/auth.php';
require_once 'includes/header.php';

// je recupere l'id dans l'URL et je le convertis en nombre entier
$id = intval($_GET['id'] ?? 0);

// si l'id est pas valide j'affiche une erreur
if ($id <= 0) {
    echo '<p class="alert alert-error">Identifiant invalide.</p>';
    echo '<a href="index.php">Retour a la liste</a>';
    require_once 'includes/footer.php';
    exit;
}

// je cherche la declaration qui a cet id
$req = $pdo->prepare("SELECT * FROM declarations WHERE id = :id");
$req->execute([':id' => $id]);
$declaration = $req->fetch();

// si je trouve rien j'affiche un message
if (!$declaration) {
    echo '<p class="alert alert-error">Declaration introuvable.</p>';
    echo '<a href="index.php">Retour a la liste</a>';
    require_once 'includes/footer.php';
    exit;
}
?>

<h2>Declaration n° <?= htmlspecialchars($declaration['numero'], ENT_QUOTES, 'UTF-8') ?></h2>

<!-- j'affiche toutes les infos de la declaration dans un tableau -->
<table>
    <tr><th style="width:200px;">Champ</th><th>Valeur</th></tr>
    <tr><td>Numero</td><td><?= htmlspecialchars($declaration['numero'], ENT_QUOTES, 'UTF-8') ?></td></tr>
    <tr><td>Importateur</td><td><?= htmlspecialchars($declaration['importateur'], ENT_QUOTES, 'UTF-8') ?></td></tr>
    <tr><td>Montant (FCFA)</td><td><?= number_format($declaration['montant'], 2, ',', ' ') ?></td></tr>
    <tr><td>Statut</td><td><?= htmlspecialchars($declaration['statut'], ENT_QUOTES, 'UTF-8') ?></td></tr>
    <tr><td>Enregistree le</td><td><?= date('d/m/Y \a H:i', strtotime($declaration['created_at'])) ?></td></tr>
</table>

<!-- boutons en bas de page -->
<p style="margin-top: 1.5rem;">
    <a href="index.php" class="btn">Retour a la liste</a>
    <a href="modifier_declaration.php?id=<?= $declaration['id'] ?>"
       class="btn" style="margin-left: 0.5rem; background: #059669;">Modifier</a>
    <a href="supprimer_declaration.php?id=<?= $declaration['id'] ?>"
       class="btn lien-supprimer" style="margin-left: 0.5rem; background: #dc2626;">Supprimer</a>
</p>

<script src="assets/app.js"></script>
<?php require_once 'includes/footer.php'; ?>
