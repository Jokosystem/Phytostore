<?php
require_once "./includes/header.php";
require_once "./src/Database.php";
require_once "./src/Phyto.php";
require_once "./src/Effet.php";
require_once "./src/PhytoModel.php";
require_once "./utils/utils.php";
require_once "./configs/configs.php";

isAdmin();
$phytoModel = new PhytoModel();
$error = $phytoModel->setupPlant("create");

//on intancie notre Class Database
$database =new Database();
// puis on invoque notre méthode connection()
$pdo = $database->connection();
//-------------------------------------------//
$stmt = $pdo->query("SELECT * FROM effet");
$effets = $stmt->fetchAll(PDO::FETCH_CLASS, "Effet");
//-------------------------------------------//



?>


<div class='at-container3'>
  <div class='at-item3'>


    <form method="post" class="w-2/2 mx-auto mt-20 bg-white border rounded p-4 shadow-md">
      <h1 class="text-6xl font-light text-center text-green-600 mb-10 uppercase">Ajouter une plante</h1>

      <?php if (isset($error) && count($error) > 0 ) : ?>
        <div class="bg-red-600 text-white py-4 px-8 rounded border border-green-900 mb-10">
        <p> <?= $error[0] ?> </p>
    </div>
  <?php endif   ?>

      <div class="mb-4">
        <label class="block mb-2" for="plante">Nom du produit :</label>
        <input class="border rounded border-green-300 py-2 px-4 w-full outline-none shadow-sm" type="text" name="plante" id="plante">
      </div>

      <div class="mb-4">
        <label for="effet" class="block mb-2  font-small text-black">Sélectionner un Effet :</label>
        <select name="effet" id="effet" class="bg-green-50 border border-green-300 text-green-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-white dark:border-green-300 dark:placeholder-green-400 dark:text-black dark:focus:ring-green-500 dark:focus:border-green-500">
          <?php
          foreach ($effets as $effet) {
            echo "<option value=" . $effet->getId() . ">" . $effet->getName() . "</option>";
          }

          ?>
        </select>
      </div>

      <div class="mb-4">
        <label class="block mb-2" for="image">Image de la plante :</label>
        <input class="border rounded border-green-300 py-2 px-4 w-full outline-none shadow-sm" type="text" name="image" id="image">
      </div>

      <div class="mb-4">
        <label class="block mb-2" for="price">Prix :</label>
        <input class="border rounded border-green-300 py-2 px-4 w-full outline-none shadow-sm" type="number" step="0.01" name="price" id="price">
      </div>

      <div class="mb-4">
        <label class="block mb-2" for="description">Description :</label>
        <textarea class="border rounded border-green-300 py-2 px-4 w-full outline-none shadow-sm" name="description" id="description" rows="10"></textarea>
      </div>

      <div class="w-100 flex justify-center">
        <button class="w-80 rounded p-4  bg-green-400 hover:bg-green-600 text-white font-semibold">
          <i class="fa-solid fa-file-circle-plus mr-2"></i>Envoyer
        </button>
      </div>
    </form>
  </div>
</div>




<?php
require_once "./components/caroussel_footer.php";
require_once "./includes/footer.php";
?>