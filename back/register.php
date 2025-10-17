<?php
require_once 'config.php'; // connexion PDO

// Affichage des erreurs pour debug
ini_set('display_errors', 1);
error_reporting(E_ALL);

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 1️⃣ Récupérer et nettoyer les données du formulaire
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $ville = trim($_POST['ville'] ?? '');
    $departement = trim($_POST['departement'] ?? '');
    $voted = 0; // par défaut

    // 2️⃣ Validation simple
    $errors = [];
    if (empty($nom)) $errors[] = "Le nom est obligatoire.";
    if (empty($prenom)) $errors[] = "Le prénom est obligatoire.";
    if (empty($email)) $errors[] = "L'email est obligatoire.";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalide.";
    if (empty($password)) $errors[] = "Le mot de passe est obligatoire.";
    if (empty($ville)) $errors[] = "La ville est obligatoire.";
    if (empty($departement)) $errors[] = "Le département est obligatoire.";

    // 3️⃣ Si pas d'erreur, insérer en base
    if (empty($errors)) {
        try {
            // Vérifier si l’email existe déjà
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->rowCount() > 0) {
                $errors[] = "Un compte existe déjà avec cet email.";
            } else {
                // Hasher le mot de passe
                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                // Insérer les données dans la table users
                $insert = $pdo->prepare(
                    "INSERT INTO users (nom, prenom, email, password_hash, role, voted, ville, departement)
                     VALUES (?, ?, ?, ?, 'electeur', ?, ?, ?)"
                );
                $insert->execute([$nom, $prenom, $email, $password_hash, $voted, $ville, $departement]);

                // ✅ Succès → redirection vers login
                header("Location: ../front/index.html");
                exit;
            }
        } catch (PDOException $e) {
            $errors[] = "Erreur lors de l'enregistrement : " . $e->getMessage();
        }
    }

    // 4️⃣ Afficher les erreurs si elles existent
    if (!empty($errors)) {
        foreach ($errors as $err) {
            echo "<p style='color:red;'>$err</p>";
        }
    }
}
?>
