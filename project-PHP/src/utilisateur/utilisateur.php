<?php
include 'config.php';

class Utilisateur {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Méthode pour ajouter un nouvel utilisateur
    public function ajouterUtilisateur($nom, $email, $motDePasse) {
        // Vérifier si l'utilisateur existe déjà
        if ($this->utilisateurExiste($email)) {
            return "Utilisateur existe déjà.";
        }

        // Hacher le mot de passe
        $motDePasseHache = password_hash($motDePasse, PASSWORD_DEFAULT);

        // Préparer la requête SQL
        $stmt = $this->pdo->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (?, ?, ?)");
        $stmt->execute([$nom, $email, $motDePasseHache]);
        return "Utilisateur créé avec succès.";
    }

    // Méthode pour vérifier si l'utilisateur existe
    private function utilisateurExiste($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() ? true : false;
    }
}
?>
