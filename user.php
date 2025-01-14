<?php
require_once 'db.php';

class User extends Db
{
    // Constructeur qui appelle le constructeur parent de la classe Database
    public function __construct()
    {
        parent::__construct();
    }

    // Méthode d'inscription
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
            if ($this->isFirstUser()) {
                $insertQuery = "INSERT INTO utilisateurs (nom, password, email, role) VALUES (:nom, :password, :email, 'Admin')";
            } else {
                $insertQuery = "INSERT INTO utilisateurs (nom, password, email, role) VALUES (:nom, :password, :email, :role)";
            }

            // Préparer et exécuter la requête d'insertion
            $stmt3 = $this->conn->prepare($insertQuery);
            $stmt3->execute([
                'nom' => $nom,
                'password' => $hashed_password,
                'email' => $email,
                'role'=>$role
            ]);

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




    public function Login($userD){
        try{
            $result=$this->conn->prepare("SELECT * FROM utilisateurs WHERE email=?");
            $result->execute([$userD[0]]);
            $user=$result->fetch(PDO::FETCH_ASSOC);

            if($user && password_verify($userD[1],$user["password"])){
                $checkAdmin = "SELECT * FROM utilisateurs ORDER BY id ASC LIMIT 1";
                $adminResult = $this->conn->query($checkAdmin);
                $admin = $adminResult->fetch(PDO::FETCH_ASSOC);
                
                if ($user['email'] === $admin['email']) {   
                    $_SESSION['is_admin'] = true;
                } else {
                    $_SESSION['is_admin'] = false;
                }

                return $user;
            } else {
                return false;
            }
        }
        catch(PDOException $e){
            echo"Error:".$e->getMessage();
            return false;
        }
    }

    function logout(){
        session_start();
        session_destroy();
    
        header('location: index.php');
    }

    function getUsername(){
        return $_SESSION['username'];
    }
}