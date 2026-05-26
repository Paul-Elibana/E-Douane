<?php
require_once 'includes/auth.php';
require_once 'includes/header.php';
?>

<h2>Nouvelle declaration</h2>

<form action="traiter_ajout.php" method="POST">

    <label for="numero">Numero de declaration</label>
    <input type="text" id="numero" name="numero" required maxlength="100">

    <label for="importateur">Importateur</label>
    <input type="text" id="importateur" name="importateur" required maxlength="150">

    <label for="montant">Montant (FCFA)</label>
    <input type="number" id="montant" name="montant" step="0.01" min="0" required>

    <label for="statut">Statut</label>
    <input type="text" id="statut" name="statut" maxlength="50" value="en_attente" required>

    <button type="submit" class="btn">Enregistrer</button>
    <a href="index.php" style="margin-left: 1rem;">Annuler</a>

</form>

<script src="assets/app.js"></script>
<?php require_once 'includes/footer.php'; ?>
