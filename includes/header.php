<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Douane</title>
    <link rel="stylesheet" href="<?= strpos($_SERVER['PHP_SELF'], '/admin/') !== false ? '../' : '' ?>assets/style.css">
</head>
<body>
<div class="container">
    <div class="header-top">
        <h1>E-Douane</h1>
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="user-info">
                <span>👤 <?= htmlspecialchars($_SESSION['user_nom'], ENT_QUOTES, 'UTF-8') ?></span>
                <a href="<?= strpos($_SERVER['PHP_SELF'], '/admin/') !== false ? '../' : '' ?>deconnexion.php">Se deconnecter</a>
            </div>
        <?php endif; ?>
    </div>
    <nav>
        <?php $base = strpos($_SERVER['PHP_SELF'], '/admin/') !== false ? '../' : ''; ?>
        <a href="<?= $base ?>index.php">Accueil</a>
        <a href="<?= $base ?>ajouter.php">Nouvelle declaration</a>
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <a href="<?= $base ?>admin/utilisateurs.php">Utilisateurs</a>
        <?php endif; ?>
    </nav>
