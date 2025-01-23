<?php
// require_once 'db.php';
require_once 'demande.php';
class User extends Db
{
    public function __construct()
    {
        parent::__construct();
    }

    public function register($nom, $email, $password, $role)
    {
        // Vérifier si l'email existe déjà
        $checkEmail = "SELECT * FROM utilisateurs WHERE email = :email";
        $stmt = $this->conn->prepare($checkEmail);
        $stmt->execute(['email' => $email]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['email_exist'] = "L'adresse email existe déjà!";
            return false;
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            if ($role === 'enseignant') {
                $sql = 'SELECT * FROM demandes WHERE email = :email';
                $stmt = $this->conn->prepare($sql);
                $stmt->execute(['email' => $email]);

                if ($stmt->rowCount() > 0) {
                    $_SESSION['email_exist'] = "L'adresse email existe déjà!";
                    return false;
                };

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
            $_SESSION['id'] = $id;
            $_SESSION['role'] = $role;

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
            var_dump($user['password']);
            echo'<br>';
            var_dump($password);
            echo'<br>';
            $t = password_hash($password, PASSWORD_DEFAULT) ;
            var_dump($t);
            echo'<br>';
            var_dump(password_verify($password, $user['password']));
            echo'<br>';
            // var_dump(password_verify($password, $t));
            // die;
            if ($user && password_verify($password, $user['password'])) {
                if ($user['status'] !== 'active') {
                    header('location: erreure.php');
                    exit();
                }            
             
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['nom'] = $user['nom'];
                $_SESSION['status'] = $user['status'];

                if ($_SESSION['role'] == 'admin') {
                    header('Location: demandes.php');
                    exit();
                } else if ($_SESSION['role'] == 'enseignant') {
                    header('Location: MesCours.php');
                    exit();
                } else if ($_SESSION['role'] == 'etudiant') {
                    header('location: coursInscrit.php');
                    exit();
                } else if ($_SESSION['role'] == 'visiteur') {
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



    function logout()
    {
        session_start();
        $_SESSION = array();
        session_destroy();

        header('location: index.php');
    }

    function getUsername()
    {
        return $_SESSION['nom'];
    }
    function getAllUsers()
    {
        $stmt = $this->conn->prepare("SELECT * FROM utilisateurs");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function getUserById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM utilisateurs WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    function deleteUser($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM utilisateurs WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
    function suspendUser($id)
    {
        $stmt = $this->conn->prepare("UPDATE utilisateurs SET status = 'suspended' WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
    function activateUser($id)
    {
        $stmt = $this->conn->prepare("UPDATE utilisateurs SET status = 'active' WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
    function desactiverUser($id)
    {
        $stmt = $this->conn->prepare("UPDATE utilisateurs SET status = 'desactiver' WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}