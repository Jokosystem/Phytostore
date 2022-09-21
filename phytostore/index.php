<?php
require_once "./src/Phyto.php";
require_once "./src/Effet.php";
require_once "./includes/header.php";

// nous allons intancier notre méthode
$plant = new Phyto();

$pdo = new PDO("mysql:host=localhost;dbname=phytostore;charset=utf8", "root", "", [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$stmt = $pdo->query("SELECT * FROM phyto");
$phyto = $stmt->fetchAll(PDO::FETCH_CLASS, "Phyto");
//===================================================//
$stmt2 = $pdo->query("SELECT * FROM effet");
$effets = $stmt2->fetchAll(PDO::FETCH_CLASS, "Effet");
// var_dump($phyto);
require "./components/marquee.php";
// dump($phyto);
require "./components/caroussel.php";

require "./components/title_product.php";

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

require "./components/caroussel_footer.php";
require_once "./includes/footer.php";
