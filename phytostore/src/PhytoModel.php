<?php
require_once "Phyto.php";
require_once "Effet.php";
require_once "MainModel.php";

class PhytoModel extends MainModel

{
    public function getAllPlants()
    {
      // On effectue notre query SQL pour retourner un array de données
      $stmt = $this->pdo->query("SELECT * FROM phyto");
      return $stmt->fetchAll(PDO::FETCH_CLASS, "Phyto");
    }
  
    public function getOnePlant()
    {
      $id = $this->checkQueryId();
      // On effectue notre query SQL pour retourner une donnée unique
      $stmt = $this->pdo->query("SELECT * FROM phyto WHERE id = $id");
      $stmt->setFetchMode(PDO::FETCH_CLASS, "Phyto");
      $plant = $stmt->fetch();
  
      if (!$plant) {
        $this->redirect();
      }
  
      return $plant;
    }
  
    public function getOnePlantById($id)
    {
      // On effectue notre query SQL pour retourner une donnée unique
      $stmt = $this->pdo->query("SELECT * FROM phyto WHERE id = $id");
      $stmt->setFetchMode(PDO::FETCH_CLASS, "Phyto");
      $plant = $stmt->fetch();
      return $plant;
    }
  
    // Méthode pour créer ou modifier une plante
    public function setupPlant($setup)
    {
      if ($_SERVER["REQUEST_METHOD"] === "POST")
      {
        // checkInputs() va nous retourner un tableau vide, ou avec une erreur;
        $error = $this->checkInputs();
  
        if (!count($error)) // Si l'array est vide / pas d'erreur
        {
          // $title = htmlspecialchars($_POST["title"]) => PHP 8
          $plante = filter_var($_POST["plante"], FILTER_SANITIZE_STRING);
          $effet = filter_var($_POST["effet"], FILTER_SANITIZE_STRING);
          $description = filter_var($_POST["description"], FILTER_SANITIZE_STRING);
          $image = filter_var($_POST["image"], FILTER_SANITIZE_URL);
          $price = filter_var($_POST["price"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
  
          // Nous utilisons PDO pour enregistrer ces données
          if ($setup === "create") {
            $stmt = $this->pdo->prepare("
              INSERT INTO phyto (plante, effet, image, price, description)
              VALUES (:plante, :effet, :image, :price, :description)
            ");
          } else if ($setup === "update") {
            $id = $this->checkQueryId();
            $stmt = $this->pdo->prepare("
              UPDATE phyto SET plante = :plante, effet = :effet, description = :description, image = :image, price = :price WHERE id = :id;
            ");
            $stmt->bindParam(":id", $id);
          }
          // On fait un bindParam pour éviter les injections SQL
          // On interdit une nouvelle requête à l'intérieur de notre requête principale
          $stmt->bindParam(":plante", $plante);
          $stmt->bindParam(":effet", $effet);
          $stmt->bindParam(":image", $image);
          $stmt->bindParam(":price", $price);
          $stmt->bindParam(":description", $description);
          
          if ($stmt->execute()) {
            $this->redirect();
          }
        } else { // Si on a une erreur, on retourne cette erreur
          return $error;
        }
      }
    }
  
    public function deletePlant()
    {
      // Suppression d'une plante
      if ($_SERVER["REQUEST_METHOD"] === "POST")
      {
        $id = $this->checkQueryId();
        $stmt = $this->pdo->prepare("DELETE FROM phyto WHERE id = :id");
        $stmt->bindParam(":id", $id);
  
        // Si la suppression est validée, nous retournons sur la page d'accueil
        if ($stmt->execute())
        {
          $this->redirect();
        }
      }
    }
  
    // Cette méthode vérifie l'ID en query string et nous retourne cet ID
    private function checkQueryId()
    {
      // Nous vérifions si notre query ID existe bien, et a une valeur numéric
      if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
        $this->redirect();
      }
      return (int)$_GET["id"];
    }
  
    // Méthode pour vérifier si nous inputs sont remplis
    // Et si le prix est valide
    private function checkInputs()
    {
      $error = [];
      if (empty($_POST['plante']) || empty($_POST['effet']) || empty($_POST['image']) || empty($_POST['price']) || empty($_POST['description']))
      {
        $error = ["Merci de compléter tous les champs."];
      }
  
      // On vérifie que notre input pour le prix est de type FLOAT / est NUMERIC
      else if (!is_numeric($_POST['price'])) {
        $error = ["Merci d'indiquer un prix valide"];
      }
  
      return $error;
    }
  }