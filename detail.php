<?php
require_once 'config/db.php';
require_once 'includes/auth.php';
require_once 'includes/header.php';

$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    echo '<p class="alert alert-error">Identifiant invalide.</p>';
    echo '<a href="index.php">Retour a la liste</a>';
    require_once 'includes/footer.php';
    exit;
}

$req = $pdo->prepare("SELECT * FROM declarations WHERE id = :id");
$req->execute([':id' => $id]);
$declaration = $req->fetch();

if (!$declaration) {
    echo '<p class="alert alert-error">Declaration introuvable.</p>';
    echo '<a href="index.php">Retour a la liste</a>';
    require_once 'includes/footer.php';
    exit;
}
?>

<h2>Declaration n° <?= htmlspecialchars($declaration['numero'], ENT_QUOTES, 'UTF-8') ?></h2>

<table>
    <tr><th style="width:200px;">Champ</th><th>Valeur</th></tr>
    <tr><td>Numero</td><td><?= htmlspecialchars($declaration['numero'], ENT_QUOTES, 'UTF-8') ?></td></tr>
    <tr><td>Importateur</td><td><?= htmlspecialchars($declaration['importateur'], ENT_QUOTES, 'UTF-8') ?></td></tr>
    <tr><td>Montant (FCFA)</td><td><?= number_format($declaration['montant'], 2, ',', ' ') ?></td></tr>
    <tr><td>Statut</td><td><?= htmlspecialchars($declaration['statut'], ENT_QUOTES, 'UTF-8') ?></td></tr>
    <tr><td>Enregistree le</td><td><?= date('d/m/Y \a H:i', strtotime($declaration['created_at'])) ?></td></tr>
</table>

<p style="margin-top: 1.5rem;">
    <a href="index.php" class="btn">Retour a la liste</a>
</p>

<script src="assets/app.js"></script>
<?php require_once 'includes/footer.php'; ?>
