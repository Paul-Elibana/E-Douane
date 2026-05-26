<?php
// Demarre la session si ce n'est pas deja fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si l'utilisateur n'est pas connecte, on le redirige vers login
if (!isset($_SESSION['user_id'])) {
    // Detecte si on est dans un sous-dossier (ex: admin/)
    $prefixe = strpos($_SERVER['PHP_SELF'], '/admin/') !== false ? '../' : '';
    header('Location: ' . $prefixe . 'login.php');
    exit;
}

// Verifie que l'utilisateur est admin (a appeler manuellement dans les pages admin)
function exigerAdmin() {
    if ($_SESSION['user_role'] !== 'admin') {
        header('Location: ../index.php');
        exit;
    }
}
