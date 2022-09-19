<?php
require_once "./src/Phyto.php";
require_once "./src/Effet.php";

// nous allons intancier notre méthode
 $plant = new Phyto();


require_once "./includes/header.php";

$pdo = new PDO("mysql:host=localhost;dbname=phytostore;charset=utf8", "root","",[
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION

]);

// Récupération des produits
$stmt = $pdo->query("SELECT * FROM phyto");
$phyto = $stmt->fetchAll(PDO::FETCH_CLASS, "Phyto");

// Récupération des effets
$stmt2 = $pdo->query("SELECT * FROM effet");
$effets = $stmt2->fetchAll(PDO::FETCH_CLASS, "Effet");

// var_dump($phyto);

// dump($phyto);

 //nous avons plus de html sur cette page  nous pouvons donc travailler sur une seule balise php
 // sans oublier de faire un require normal et pas once sinon la card ne s'affichera qu'une seule fois 
    foreach($phyto as $phytoInter) 
   {
    foreach($effets as $effet)
    {
      if($effet->getId() == $phytoInter->getEffet())
      {
        $effetname = $effet->getName();
      }
    }

    if(isset($_GET["id"]))
    {
      $id = $_GET["id"];
      if($phytoInter->getEffet() == $id)
      {
        require "./components/phyto_card.php";
      }
    }
    else
    {
      require "./components/phyto_card.php";
    }
   }
require_once "./includes/footer.php";

?>