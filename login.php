<?php
// je demarre la session
if (session_status() === PHP_SESSION_NONE) session_start();

// si l'utilisateur est deja connecte je le redirige direct vers l'accueil
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$erreur = '';

// je traite le formulaire quand il est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'config/db.php';

    // je recupere ce que l'utilisateur a tape
    $email = trim($_POST['email'] ?? '');
    $mdp   = trim($_POST['mot_de_passe'] ?? '');

    // je verifie que les champs sont pas vides
    if ($email === '' || $mdp === '') {
        $erreur = "Tous les champs sont obligatoires.";
    } else {
        // je cherche l'utilisateur dans la base avec son email
        $req = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
        $req->execute([':email' => $email]);
        $user = $req->fetch();

        // je verifie si l'utilisateur existe et si le mot de passe est bon
        if ($user && password_verify($mdp, $user['mot_de_passe'])) {
            // connexion reussie je sauvegarde ses infos dans la session
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_nom']  = $user['prenom'] . ' ' . $user['nom'];
            $_SESSION['user_role'] = $user['role'];
            header('Location: index.php');
            exit;
        } else {
            $erreur = "Email ou mot de passe incorrect.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Douane — Connexion</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container" style="max-width: 400px; margin-top: 5rem;">
    <h1>E-Douane</h1>
    <h2 style="margin-bottom: 1.5rem;">Connexion</h2>

    <?php if ($erreur !== ''): ?>
        <p class="alert alert-error"><?= htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <form method="POST" action="login.php" id="form-login">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="mot_de_passe">Mot de passe</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required>

        <button type="submit" class="btn" style="width: 100%;">Se connecter</button>
    </form>

    <p style="margin-top: 1rem; text-align: center;">
        Pas encore de compte ? <a href="inscription.php">S'inscrire</a>
    </p>
</div>
<script src="assets/app.js"></script>
</body>
</html>
