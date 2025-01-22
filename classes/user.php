<?php
// require_once '../db.php';
require_once 'demande.php';
class User extends Db
{
    // Constructeur qui appelle le constructeur parent de la classe Database
    public function __construct()
    {
        parent::__construct();
    }

    public function register($nom, $email, $password,$role)
    {
        // Vérifier si l'email existe déjà
        $checkEmail = "SELECT * FROM utilisateurs WHERE email = :email";
        $stmt = $this->conn->prepare($checkEmail);
        $stmt->execute(['email' => $email]);

        // Vérifier si le nom d'utilisateur existe déjà
        $checkUser = "SELECT * FROM utilisateurs WHERE nom = :nom";
        $stmt2 = $this->conn->prepare($checkUser);
        $stmt2->execute(['nom' => $nom]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['email_exist'] = "L'adresse email existe déjà!";
            return false;
        } elseif ($stmt2->rowCount() > 0) {
            $_SESSION['UserName_exist'] = "Le nom d'utilisateur existe déjà!";
            return false;
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            if ($role === 'enseignant') {
                $demande = new Demande();  // Instanciation de la classe Demande
    
                if ($demande->demandes($role, $nom, $email, $hashed_password)) {
                    $_SESSION['success'] = "Votre demande a été envoyée pour validation.";
                    return true;
                } else {
                    $_SESSION['signup_error'] = "Erreur : Impossible d'envoyer votre demande. Veuillez réessayer.";
                    return false;
                }
            }
            if ($this->isFirstUser()) {
                $insertQuery = "INSERT INTO utilisateurs (nom, password, email, role) VALUES (:nom, :password, :email, 'Admin')";
            } else {
                $insertQuery = "INSERT INTO utilisateurs (nom, password, email, role) VALUES (:nom, :password, :email, 'etudiant')";
            }
            $stmt3 = $this->conn->prepare($insertQuery);
            $stmt3->execute([
                ':nom' => $nom,
                ':password' => $hashed_password,
                ':email' => $email,
            ]);
            $id = $this->conn->lastInsertId();
            $_SESSION['id']=$id;
            $_SESSION['role']=$role;

            // Vérifier si l'insertion a été réussie
            if ($stmt3->rowCount() > 0) {
                $_SESSION['succesfull_signup'] = "Inscription réussie";
                return true;
            } else {
                $_SESSION['signup_error'] = "Erreur : Impossible de s'inscrire. Veuillez réessayer.";
                return false;
            }
        }
    }

    // Vérifier s'il y a des utilisateurs existants (premier utilisateur)
    private function isFirstUser()
    {
        // Vérifier s'il y a des utilisateurs dans la base
        $query = "SELECT * FROM utilisateurs";
        $stmt = $this->conn->query($query);

        return $stmt->rowCount() == 0; // Si aucun utilisateur n'existe, c'est le premier utilisateur
    }
    public function Login($email, $password)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM utilisateurs WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user && password_verify($password, $user['password'])) {
                
    
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['nom'] = $user['nom'];
    
                if ($_SESSION['role'] == 'admin') {
                    header('Location: demandes.php');
                    exit();
                } else if ($_SESSION['role'] == 'enseignant') {
                    header('Location: MesCours.php'); 
                    exit();
                }else if ($_SESSION['role'] == 'etudiant') {
                    header('location: coursInscrit.php');
                    exit();
                }
                 else if ($_SESSION['role'] == 'visiteur') {
                    header('Location: index.php');
                    exit();
                }
            } else {
                return "Identifiants incorrects.";
            }
        } catch (PDOException $e) {
            return "Erreur : " . $e->getMessage();
        }
    }
    


    function logout(){
        session_start();
        session_destroy();
    
        header('location: index.php');
    }

    function getUsername(){
        return $_SESSION['nom'];
    }
function getAllUsers(){
    $stmt = $this->conn->prepare("SELECT * FROM utilisateurs");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getUserById($id){
    $stmt = $this->conn->prepare("SELECT * FROM utilisateurs WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);  

}
function deleteUser($id){
    $stmt = $this->conn->prepare("DELETE FROM utilisateurs WHERE id = :id");
    $stmt->execute(['id' => $id]); 
}
function suspendUser($id){
    $stmt = $this->conn->prepare("UPDATE utilisateurs SET status = 'suspended' WHERE id = :id");
    $stmt->execute(['id' => $id]);
}
function activateUser($id){
    $stmt = $this->conn->prepare("UPDATE utilisateurs SET status = 'active' WHERE id = :id");
    $stmt->execute(['id' => $id]);
}
function desactiverUser($id){
    $stmt = $this->conn->prepare("UPDATE utilisateurs SET status = 'desactiver' WHERE id = :id");
    $stmt->execute(['id' => $id]);
}
}
