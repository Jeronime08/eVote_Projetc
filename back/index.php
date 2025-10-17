<?php
session_start();
require_once 'config.php'; // Connexion PDO

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $identifiant = trim($_POST['identifiant'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($identifiant) && !empty($password)) {
        try {
            if (strpos($identifiant, '@') !== false) {
                // Si identifiant contient '@', c'est un email
                $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            } else {
                // Sinon c'est un NPI
                $stmt = $pdo->prepare("SELECT * FROM users WHERE npi = ?");
            }

            $stmt->execute([$identifiant]);
            $users = $stmt->fetch();

            if ($users) {
                // Vérifier le mot de passe
                if ($password == $users['password_hash']) {
                    // Connexion réussie
                    $_SESSION['user_id'] = $users['id'];
                    $_SESSION['user_name'] = $users['nom'] . ' ' . $users['prénom'];
                    $_SESSION['role'] = $users['role'];

                    // Redirection selon le rôle ou type d'identifiant
                    if (strpos($identifiant, '@') !== false) {
                        header("Location: ../front/admin.html "); // tableau de bord électeur
                    } else {
                        header("Location: ../front/vote.html"); // redirection via NPI
                    }
                    exit;
                } else {
                    $message = "❌ Mot de passe incorrect.";
                }
            } else {
                $message = "❌ Identifiant introuvable.";
            }
        } catch (PDOException $e) {
            $message = "Erreur : " . $e->getMessage();
        }
    } else {
        $message = "⚠️ Veuillez remplir tous les champs.";
    }
}

// Affichage du message d'erreur
if (!empty($message)) {
    echo "<p style='color:red;'>$message</p>";
}
?>
