<?php
namespace vendor\Nathan\Model;
use vendor\Nathan\Model\config;

class Projet  extends PDO {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Méthode pour ajouter un nouveau projet
    public function ajouterProjet($nom, $administrateurId) {
        // Préparer la requête SQL pour insérer un nouveau projet
        $stmt = $this->pdo->prepare("INSERT INTO projets (nom, administrateur_id) VALUES (?, ?)");
        $stmt->execute([$nom, $administrateurId]);
        return $this->pdo->lastInsertId(); // Retourne l'ID du projet créé
    }

    // Méthode pour affecter un administrateur à un projet
    public function affecterAdministrateur($projetId, $administrateurId) {
        // Vérifier si le projet existe
        if (!$this->projetExiste($projetId)) {
            return "Projet non trouvé.";
        }

        // Mise à jour de l'administrateur du projet
        $stmt = $this->pdo->prepare("UPDATE projets SET administrateur_id = ? WHERE id = ?");
        $stmt->execute([$administrateurId, $projetId]);
        return "Administrateur affecté avec succès.";
    }

    // Méthode pour vérifier si le projet existe
    private function projetExiste($projetId) {
        $stmt = $this->pdo->prepare("SELECT * FROM projets WHERE id = ?");
        $stmt->execute([$projetId]);
        return $stmt->fetch() ? true : false;
    }
}
?>
