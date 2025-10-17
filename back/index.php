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
            $user = $stmt->fetch();

            if ($user) {
                // Vérifier le mot de passe
                if (password_verify($password, $user['password_hash'])) {
                    // Connexion réussie
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['nom'] . ' ' . $user['prénom'];
                    $_SESSION['role'] = $user['role'];

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
