<?php
require_once "./src/Phyto.php";
require_once "./includes/header.php";
// nous allons intancier notre méthode
$plant = new Phyto();

$pdo = new PDO("mysql:host=localhost;dbname=phytostore;charset=utf8", "root", "", [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$stmt = $pdo->query("SELECT * FROM phyto");
$phyto = $stmt->fetchAll(PDO::FETCH_CLASS, "Phyto");
// var_dump($phyto);
require "./components/marquee.php";
// dump($phyto);
require "./components/caroussel.php";

// require "./components/title_product.php";

//nous avons plus de html sur cette page  nous pouvons donc travailler sur une seule balise php
// sans oublier de faire un require normal et pas once sinon la card ne s'affichera qu'une seule fois 
foreach ($phyto as $phytoInter) {
  require "./components/phyto_card.php";
}


require "./components/caroussel_footer.php";




require_once "./includes/footer.php"; ?>