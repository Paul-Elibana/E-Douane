<?php
require_once 'config/db.php';
require_once 'includes/auth.php';

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: index.php'); exit; }

$req = $pdo->prepare("SELECT * FROM declarations WHERE id = :id");
$req->execute([':id' => $id]);
$declaration = $req->fetch();

if (!$declaration) { header('Location: index.php'); exit; }

require_once 'includes/header.php';
?>

<h2>Modifier la declaration</h2>

<form method="POST" action="traiter_modifier_declaration.php">
    <input type="hidden" name="id" value="<?= $declaration['id'] ?>">

    <label for="numero">Numero de declaration</label>
    <input type="text" id="numero" name="numero" required maxlength="100"
           value="<?= htmlspecialchars($declaration['numero'], ENT_QUOTES, 'UTF-8') ?>">

    <label for="importateur">Importateur</label>
    <input type="text" id="importateur" name="importateur" required maxlength="150"
           value="<?= htmlspecialchars($declaration['importateur'], ENT_QUOTES, 'UTF-8') ?>">

    <label for="montant">Montant (FCFA)</label>
    <input type="number" id="montant" name="montant" step="0.01" min="0" required
           value="<?= $declaration['montant'] ?>">

    <label for="statut">Statut</label>
    <input type="text" id="statut" name="statut" maxlength="50" required
           value="<?= htmlspecialchars($declaration['statut'], ENT_QUOTES, 'UTF-8') ?>">

    <button type="submit" class="btn">Enregistrer les modifications</button>
    <a href="index.php" style="margin-left: 1rem;">Annuler</a>
</form>

<script src="assets/app.js"></script>
<?php require_once 'includes/footer.php'; ?>
