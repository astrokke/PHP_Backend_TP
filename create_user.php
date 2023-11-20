<?php

class Database
{
    private $conn;

    public function __construct($host, $db_name, $username, $password)
    {
        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Erreur de connexion à la base de données: " . $e->getMessage();
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}

class UserManager
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function createUser($nom, $prenom, $email, $motDePasse)
    {
        $conn = $this->db->getConnection();

        // Hachage du mot de passe
        $motDePasseHash = password_hash($motDePasse, PASSWORD_DEFAULT);

        try {
            // Requête préparée
            $sql = "INSERT INTO Utilisateur (Nom, Prenom, Email, MotDePasse) VALUES (:nom, :prenom, :email, :motDePasse)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':motDePasse', $motDePasseHash);
            $stmt->execute();

            return true;
        } catch(PDOException $e) {
            echo "Erreur: " . $e->getMessage();
            return false;
        }
    }
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $motDePasse = $_POST['motDePasse'];

    // Connexion à la base de données (à adapter selon notre configuration)
    $host = "localhost";
    $db_name = "project-manager";
    $username = "root";
    $password = "";

    $database = new Database($host, $db_name, $username, $password);
    $userManager = new UserManager($database);

    // Appel de la méthode pour créer un utilisateur
    if ($userManager->createUser($nom, $prenom, $email, $motDePasse)) {
        // Redirection vers une page de confirmation
        header("Location: confirmation_user.php");
        exit();
    }
}

?>
