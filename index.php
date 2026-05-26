<?php
require_once 'config/db.php';
require_once 'includes/auth.php';
require_once 'includes/header.php';

$recherche = trim($_GET['q'] ?? '');

if ($recherche !== '') {
    $requete = $pdo->prepare("
        SELECT * FROM declarations
        WHERE numero      LIKE :terme
           OR importateur LIKE :terme
           OR statut      LIKE :terme
        ORDER BY created_at DESC
    ");
    $requete->execute([':terme' => '%' . $recherche . '%']);
} else {
    $requete = $pdo->query("SELECT * FROM declarations ORDER BY created_at DESC");
}

$declarations = $requete->fetchAll();
?>

<?php if (isset($_GET['succes'])): ?>
    <p class="alert alert-success">Declaration ajoutee avec succes.</p>
<?php endif; ?>
<?php if (isset($_GET['modifie'])): ?>
    <p class="alert alert-success">Declaration modifiee avec succes.</p>
<?php endif; ?>
<?php if (isset($_GET['supprime'])): ?>
    <p class="alert alert-success">Declaration supprimee avec succes.</p>
<?php endif; ?>

<!-- Barre de recherche -->
<form method="GET" action="index.php" class="search-bar">
    <input type="text" name="q" id="recherche-live"
           placeholder="Rechercher par numero, importateur, statut..."
           value="<?= htmlspecialchars($recherche, ENT_QUOTES, 'UTF-8') ?>">
    <button type="submit" class="btn">Rechercher</button>
    <?php if ($recherche !== ''): ?>
        <a href="index.php" style="margin-left: 1rem;">Effacer</a>
    <?php endif; ?>
</form>

<!-- Liste -->
<?php if (empty($declarations)): ?>
    <p>Aucune declaration trouvee.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Numero</th>
                <th>Importateur</th>
                <th>Montant (FCFA)</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($declarations as $declaration): ?>
            <tr>
                <td><?= htmlspecialchars($declaration['numero'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($declaration['importateur'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= number_format($declaration['montant'], 2, ',', ' ') ?></td>
                <td><?= htmlspecialchars($declaration['statut'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= date('d/m/Y', strtotime($declaration['created_at'])) ?></td>
                <td>
                    <a href="detail.php?id=<?= $declaration['id'] ?>">Voir</a>
                    &nbsp;|&nbsp;
                    <a href="modifier_declaration.php?id=<?= $declaration['id'] ?>">Modifier</a>
                    &nbsp;|&nbsp;
                    <a href="supprimer_declaration.php?id=<?= $declaration['id'] ?>"
                       class="lien-supprimer" style="color: #dc2626;">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<script src="assets/app.js"></script>
<?php require_once 'includes/footer.php'; ?>
