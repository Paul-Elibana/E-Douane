<?php
// je demarre la session et je la detruis pour deconnecter l'utilisateur
session_start();
session_destroy();

// je renvoie vers la page de connexion
header('Location: login.php');
exit;
