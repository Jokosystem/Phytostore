<?php
require_once "MainModel.php";
require_once "User.php";

class UserModel extends MainModel
{
   /**
   * Méthode pour chercher un utilisateur
   */
  public function searchUser()
  {
    $loggedUser = getLoggedUser();
    $stmt = $this->pdo->query("SELECT * FROM users WHERE id = " . $loggedUser['id']);
    $stmt->setFetchMode(PDO::FETCH_CLASS, "User");
    return $stmt->fetch();
  }

  /**
   * Méthode pour retourner un utilisateur
   */
  public function getUser()
  {
    $user = $this->searchUser();
    $data = [
      "firstname" => $user->getFirstname(),
      "lastname" => $user->getLastname(),
      "email" => $user->getEmail(),
      "address" => $user->getAddress(),
      "postal" => $user->getPostal(),
      "city" => $user->getCity(),
    ];
    return $data;
  }

  /**
   * Méthode pour enregistrer un utilisateur
   */
  public function setupUser()
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
      $data = [
        "firstname" => "",
        "errorFirstname" => "",
        "lastname" => "",
        "errorLastname" => "",
        "email" => "",
        "errorEmail" => "",
        "address" => "",
        "errorAddress" => "",
        "postal" => "",
        "errorPostal" => "",
        "city" => "",
        "errorCity" => "",
        "errorPassword" => "",
        "errorConfirm" => "",
      ];

      // On stock chacun de nos inputs dans une variable
      $firstname = $_POST["firstname"];
      $data["firstname"] = $firstname;

      $lastname = $_POST["lastname"];
      $data["lastname"] = $lastname;

      $email = $_POST["email"];
      $data["email"] = $email;

      $address = $_POST["address"];
      $data["address"] = $address;

      $postal = $_POST["postal"];
      $data["postal"] = $postal;

      $city = $_POST["city"];
      $data["city"] = $city;

      $password = $_POST["password"];
      $confirm = $_POST["confirm"];

      if (empty($firstname)) {
        $data["errorFirstname"] = "Merci de remplir votre prénom";
      }

      if (empty($lastname)) {
        $data["errorLastname"] = "Merci de remplir votre nom";
      }

      if (!filter_var($email, FILTER_VALIDATE_EMAIL))
      {
        $data["errorEmail"] = "Merci de remplir un email valide";
      }

      if (empty($email)) {
        $data["errorEmail"] = "Merci de remplir votre email";
      }

      if (empty($address)) {
        $data["errorAddress"] = "Merci de remplir votre adresse";
      }

      if (empty($postal)) {
        $data["errorPostal"] = "Merci de remplir votre code postal";
      }

      if (empty($city)) {
        $data["errorCity"] = "Merci de remplir votre ville";
      }

      if (empty($password) || strlen($password) < 6) {
        $data["errorPassword"] = "Merci de remplir votre mot de passe [6 caractères minimum]";
      }

      if ($password !== $confirm) {
        $data["errorConfirm"] = "Les mots de passe ne correspondent pas";
      }

      if (empty($confirm)) {
        $data["errorConfirm"] = "Merci de confirmer votre mot de passe";
      }

      // Si une erreur n'est pas vide (empty), c'est qu'on a une erreur
      // On retourne alors notre array $data, et on ne fait rien d'autre
      if (!empty($data["errorFirstname"]) || !empty($data["errorLastname"]) || !empty($data["errorEmail"]) || !empty($data["errorAddress"]) || !empty($data["errorPostal"]) || !empty($data["errorCity"]) || !empty($data["errorPassword"]) || !empty($data["errorConfirm"]))
      {
        return $data;
      }

      // Si nous n'avons pas d'erreurs, nous pouvons traiter les données.
      // $firstname = htmlspecialchars($firstname); => filtrer les strings sous PHP8
      $firstname = filter_var($firstname, FILTER_SANITIZE_STRING);
      $lastname = filter_var($lastname, FILTER_SANITIZE_STRING);
      $email = filter_var($email, FILTER_SANITIZE_EMAIL);
      $address = filter_var($address, FILTER_SANITIZE_STRING);
      $postal = filter_var($postal, FILTER_SANITIZE_STRING);
      $city = filter_var($city, FILTER_SANITIZE_STRING);
      
      // On veut hasher le mot de passe
      $password = password_hash($password, PASSWORD_DEFAULT);

      // On prépare notre requête SQL
      $query = $this->pdo->prepare("
        INSERT INTO users (firstname, lastname, email, address, postal, city, password)
        VALUES (:firstname, :lastname, :email, :address, :postal, :city, :password);
      ");

      // On remplace les placeholders (optionnellement avec bindParam)
      $success = $query->execute([
        ":firstname" => $firstname,
        ":lastname" => $lastname,
        ":email" => $email,
        ":address" => $address,
        ":postal" => $postal,
        ":city" => $city,
        ":password" => $password,
      ]);

      // if ($success) => if ($success === true)
      // if (!$success) => if ($success === false)
      if ($success) $this->redirect("login.php");
    }
  }

  /**
   * Méthode pour modifier un utilisateur
   */
  public function updateUser()
  {
    $user = getLoggedUser();
    if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
      $data = [
        "errorFirstname" => "",
        "errorLastname" => "",
        "errorEmail" => "",
        "errorAddress" => "",
        "errorPostal" => "",
        "errorCity" => "",
      ];

      // On stock chacun de nos inputs dans une variable
      $firstname = $_POST["firstname"];
      $lastname = $_POST["lastname"];
      $email = $_POST["email"];
      $address = $_POST["address"];
      $postal = $_POST["postal"];
      $city = $_POST["city"];

      if (empty($firstname)) {
        $data["errorFirstname"] = "Merci de remplir votre prénom";
      }

      if (empty($lastname)) {
        $data["errorLastname"] = "Merci de remplir votre nom";
      }

      if (!filter_var($email, FILTER_VALIDATE_EMAIL))
      {
        $data["errorEmail"] = "Merci de remplir un email valide";
      }

      if (empty($email)) {
        $data["errorEmail"] = "Merci de remplir votre email";
      }

      if (empty($address)) {
        $data["errorAddress"] = "Merci de remplir votre adresse";
      }

      if (empty($postal)) {
        $data["errorPostal"] = "Merci de remplir votre code postal";
      }

      if (empty($city)) {
        $data["errorCity"] = "Merci de remplir votre ville";
      }

      // Si une erreur n'est pas vide (empty), c'est qu'on a une erreur
      // On retourne alors notre array $data, et on ne fait rien d'autre
      if (!empty($data["errorFirstname"]) || !empty($data["errorLastname"]) || !empty($data["errorEmail"]) || !empty($data["errorAddress"]) || !empty($data["errorPostal"]) || !empty($data["errorCity"]))
      {
        return $data;
      }

      // Si nous n'avons pas d'erreurs, nous pouvons traiter les données.
      // $firstname = htmlspecialchars($firstname); => filtrer les strings sous PHP8
      $firstname = filter_var($firstname, FILTER_SANITIZE_STRING);
      $lastname = filter_var($lastname, FILTER_SANITIZE_STRING);
      $email = filter_var($email, FILTER_SANITIZE_EMAIL);
      $address = filter_var($address, FILTER_SANITIZE_STRING);
      $postal = filter_var($postal, FILTER_SANITIZE_STRING);
      $city = filter_var($city, FILTER_SANITIZE_STRING);

      // On prépare notre requête SQL
      $query = $this->pdo->prepare("
        UPDATE users SET
        firstname = :firstname,
        lastname = :lastname,
        email = :email,
        address = :address,
        postal = :postal,
        city = :city
        WHERE id = :id
      ");

      // On remplace les placeholders (optionnellement avec bindParam)
      $success = $query->execute([
        ":firstname" => $firstname,
        ":lastname" => $lastname,
        ":email" => $email,
        ":address" => $address,
        ":postal" => $postal,
        ":city" => $city,
        ":id" => $user["id"],
      ]);

      if ($success) {
        $_SESSION["phytostore_logged_user"] = [
          "id" => $user["id"],
          "role" => $user["role"],
          "firstname" => $firstname,
          "lastname" => $lastname,
        ];
        $this->redirect("profile.php");
      }
    }
  }

  /**
   * Méthode pour se connecter
   */
  public function loginUser()
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST") 
    {
      $error = "Identifiants invalides. Merci de réessayer.";

      $email = $_POST["email"];
      $password = $_POST["password"];
      
      // 1ère étape: Vérifier en BDD si cet email existe
      // 2de étape: si l'email existe, vérifier le mot de passe
      $query = $this->pdo->query("SELECT * FROM users WHERE email = '$email'");
      $query->setFetchMode(PDO::FETCH_CLASS, "User");
      $user = $query->fetch();

      if (!$user) return $error;

      // $matchPassword va vérifier le MDP, et nous retourner true ou false
      $matchPassword = password_verify($password, $user->getPassword());

      // Si l'email / mdp sont corrects, se connecter
      // Sinon afficher l'erreur

      if ($matchPassword) {
        // On enregistre notre utilisateur dans une session
        $_SESSION["phytostore_logged_user"] = [
          "id" => $user->getId(),
          "role" => $user->getRole(),
          "firstname" => $user->getFirstname(),
          "lastname" => $user->getLastname(),
        ];
        $this->redirect();
      } 
      else return $error;
    }
  }

  /**
   * Méthode pour déconnecter l'utilisateur
   */
  public function logoutUser()
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
      // Nous allons détruire notre session
      // et rediriger notre utilisateur vers la page de login
      unset($_SESSION["phytostore_logged_user"]);
      session_destroy();
      $this->redirect("login.php");
    }
  }

  /**
   * Méthode pour modifier le mot de passe
   */
  public function modifyPassword()
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
      $current = $_POST["current"];
      $newPassword = $_POST["newPassword"];
      $confirm = $_POST["confirm"];

      // Nous allons vérifier si le mdp $current correspond
      // à celui présent en BDD
      $user = $this->searchUser();
      if (password_verify($current, $user->getPassword()) && $newPassword === $confirm)
      {
        $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $query = $this->pdo->prepare("UPDATE users SET password = :password");
        $success = $query->execute([":password" => $newPassword]);

        if ($success) $this->redirect("profile.php");
      }
      dd("Erreur dans la logique");
    }
  }
}