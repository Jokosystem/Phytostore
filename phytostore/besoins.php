<?php
require_once "./src/Phyto.php";
require_once "./src/Effet.php";

// nous allons intancier notre méthode
$plant = new Phyto();


require_once "./includes/header.php";

$pdo = new PDO("mysql:host=localhost;dbname=phytostore;charset=utf8", "root", "", [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION

]);

$stmt = $pdo->query("SELECT * FROM effet");
$effets = $stmt->fetchAll(PDO::FETCH_CLASS, "Effet");





?>

<h1 class="text-center text-3xl text-green-600 mb-20">Mes Besoins</h1>


<?php foreach ($effets as $effet) : ?>

  <div class="bg-white flex justify-between items-center shadow-sm mb-6 p-6">
    <img id="imgcard" class="w-80" src="<?= $effet->getImage() ?>" alt="effet">
    <div class="w-1/3">
      <h3 class="text-4xl font-light text-orange-500"><?= $effet->getName() ?></h3>
      </br>
      <div>
        <a href="index.php?id=<?= $effet->getId() ?>" class="py-2 px-4 rounded bg-green-400 hover:bg-green-600 text-white">
          <i class="fa-solid fa-list mr-2"></i>Produits associés
        </a>
      </div>
    </div>
  </div>
<?php endforeach ?>




<?php
require "./components/caroussel_footer.php";
require_once "./includes/footer.php";
?>