<?php
// je demarre la session si elle est pas encore demarree
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// si l'utilisateur est pas connecte je le renvoie vers la page de login
if (!isset($_SESSION['user_id'])) {
    // je verifie si je suis dans le dossier admin pour mettre le bon chemin
    $prefixe = strpos($_SERVER['PHP_SELF'], '/admin/') !== false ? '../' : '';
    header('Location: ' . $prefixe . 'login.php');
    exit;
}

// cette fonction verifie que l'utilisateur est bien admin
// je l'appelle dans les pages qui sont reservees aux admins
function exigerAdmin() {
    if ($_SESSION['user_role'] !== 'admin') {
        // si c'est pas un admin je le renvoie a l'accueil
        header('Location: ../index.php');
        exit;
    }
}
