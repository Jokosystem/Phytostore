<?php
require_once "MainModel.php";
require_once "Phyto.php";
require_once "PhytoModel.php";

class BasketModel extends MainModel
{
  /**
   * Méthode pour retourner notre panier
   */
  public function getBasket()
  {
    $bm = new PhytoModel();
    $user = getLoggedUser();
    $userId = $user["id"];
    $stmt = $this->pdo->query("
    select bb.plant_id, bb.quantity from basket b
    join basket_plants bb 
    on basket_id = b.id
    where user_id = $userId
    ");
    $basket = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($basket)
    {
      $formatedBasket = [];
      foreach($basket as $plant)
      {
        $newPhyto = $bm->getOnePlantById($plant["plant_id"]);
        $newPhyto->setQuantity($plant["quantity"]);
        $formatedBasket[] = $newPhyto;
      }
      return $formatedBasket;
    }

    return false;
  }

  /**
   * Méthode pour calculer le prix du panier
   */
  public function getFullPrice($basket)
  {
    if (!$basket) return;
    $total = 0;
    foreach($basket as $plant)
    {
      $total = $total + $plant->getPrice() * $plant->getQuantity();
    }
    return $total;
  }
  
  /**
   * Méthode pour ajouter une plante à notre panier
   */
  public function addToBasket($plantId)
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
      // 1ère étape: vérifier si le panier existe ou pas
      $user = getLoggedUser();
      $stmt = $this->pdo->query("SELECT * FROM basket WHERE user_id = " . $user["id"]);
      $basket = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$basket)
      {
        $stmt = $this->pdo->prepare("INSERT INTO basket (user_id) VALUES (:user_id)");
        $stmt->execute([":user_id" => $user["id"]]);
        // On récupère l'ID de notre nouveau panier
        $basketId = $this->pdo->lastInsertId();


        $stmt = $this->pdo->prepare("INSERT INTO basket_plants (basket_id, plant_id, quantity) VALUES (:basket_id, :plant_id, 1)");
        $stmt->execute([":basket_id" => $basketId, ":plant_id" => $plantId]);
      }
      else 
      {
        // Si le panier existe, on vérifie si la plante est déjà présente à l'intérieur
        $stmt = $this->pdo->query("SELECT * FROM basket_plants 
        WHERE basket_id = " . $basket["id"] . " AND plant_id = " . $plantId);
        $plant = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Si la plante existe, on augmente sa quantité
        if ($plant)
        {
          $stmt = $this->pdo->prepare("
            UPDATE basket_plants SET quantity = :quantity WHERE plant_id = :plant_id
          ");
          $stmt->execute([":quantity" => $plant["quantity"] + 1, ":plant_id" => $plant["plant_id"]]);
        }
        else {
          $stmt = $this->pdo->prepare("INSERT INTO basket_plants (basket_id, plant_id, quantity) VALUES (:basket_id, :plant_id, 1)");
          $stmt->execute([":basket_id" => $basket["id"], ":plant_id" => $plantId]);
        }
      }

      $this->redirect("basket.php");
    }
  }

  /**
   * Méthode pour supprimer une plante du panier
   */
  public function removeToBasket($plantId)
  {
    // 1ère étape: récupérer le panier
    $user = getLoggedUser();
    $stmt = $this->pdo->query("SELECT * FROM basket WHERE user_id = " . $user["id"]);
    $basket = $stmt->fetch(PDO::FETCH_ASSOC);

    // 2nde étape: récupérer la plante pour vérifier sa quantité
    $stmt = $this->pdo->query("SELECT * FROM basket_plants 
    WHERE basket_id = " . $basket["id"] . " AND plant_id = " . $plantId);
    $plant = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si la plante a une quantité supérieur à 1
    if ($plant["quantity"] > 1)
    {
      $stmt = $this->pdo->prepare("
        UPDATE basket_plants SET quantity = :quantity WHERE plant_id = :plant_id
      ");
      $stmt->execute([":quantity" => $plant["quantity"] - 1, ":plant_id" => $plantId]);
    }
    else if ($plant["quantity"]  == "1")
    {
      $stmt = $this->pdo->prepare("
        DELETE FROM basket_plants WHERE plant_id = :plant_id AND basket_id = :basket_id
      ");
      $stmt->execute([":plant_id" => $plantId, ":basket_id" => $basket["id"]]);
    }

    $this->redirect("http://localhost/phytostore/phytostore/basket.php");
  }
}