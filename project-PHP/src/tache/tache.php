<?php
namespace vendor\Nathan\tache;
use vendor\Nathan\config\Config;

class Tache {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Méthode pour ajouter une nouvelle tâche
    public function ajouterTache($titre, $description, $priorite, $projetId, $utilisateurId) {
        $stmt = $this->pdo->prepare("INSERT INTO taches (titre, description, priorite, statut, projet_id, utilisateur_id) VALUES (?, ?, ?, 'Non débuté', ?, ?)");
        $stmt->execute([$titre, $description, $priorite, $projetId, $utilisateurId]);
        return $this->pdo->lastInsertId(); // Retourne l'ID de la tâche créée
    }

    // Méthode pour mettre à jour le statut d'une tâche
    public function mettreAJourStatutTache($tacheId, $nouveauStatut) {
        if (!$this->tacheExiste($tacheId)) {
            return "Tâche non trouvée.";
        }

        $stmt = $this->pdo->prepare("UPDATE taches SET statut = ? WHERE id = ?");
        $stmt->execute([$nouveauStatut, $tacheId]);
        return "Statut de la tâche mis à jour.";
    }

    // Méthode pour assigner une tâche à un utilisateur
    public function assignerTache($tacheId, $utilisateurId) {
        if (!$this->tacheExiste($tacheId)) {
            return "Tâche non trouvée.";
        }

        $stmt = $this->pdo->prepare("UPDATE taches SET utilisateur_id = ? WHERE id = ?");
        $stmt->execute([$utilisateurId, $tacheId]);
        return "Tâche assignée à l'utilisateur.";
    }

    // Méthode pour vérifier si la tâche existe
    private function tacheExiste($tacheId) {
        $stmt = $this->pdo->prepare("SELECT * FROM taches WHERE id = ?");
        $stmt->execute([$tacheId]);
        return $stmt->fetch() ? true : false;
    }
}
?>
