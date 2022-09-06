<?php
require_once "./includes/header.php";
require_once "./src/Phyto.php";

// nous allons intancier notre méthode
$plant = new Phyto();




$pdo = new PDO("mysql:host=localhost;dbname=phytostore;charset=utf8", "root", "", [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION

]);

$stmt = $pdo->query("SELECT * FROM phyto");
$phyto = $stmt->fetchAll(PDO::FETCH_CLASS, "Phyto");
// var_dump($phyto);

// dump($phyto);
?>

<?php foreach ($phyto as $phytoInter) : ?>

  <div class='at-container2'>
    <div class='at-item2'>

      <div id="card" class="bg-white flex justify-between items-center shadow-sm mb-6 p-6">
        <img class="w-36" src="<?= $phytoInter->getImage() ?>" alt="">
        <div>
          <h2 class="text-4xl uppercase"><?= $phytoInter->getPlante() ?></h2>
          <h3 class="text-2xl font-light"><?= $phytoInter->getEffet() ?></h3>
        </div>
        <div>
          <button class="py-2 px-4 rounded bg-yellow-400 hover:bg-yellow-500 text-white"><i class="fa-solid fa-pen-to-square mr-2"></i>Modifier</button>
          <button class="py-2 px-4 rounded bg-red-400 hover:bg-red-500 text-white"><i class="fa-solid fa-ban mr-2"></i>Supprimer</button>
        </div>
      </div>

    </div>
  </div>


<?php endforeach; ?>

<?php
require_once "./includes/footer.php";

?>