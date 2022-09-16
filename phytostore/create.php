<?php
require_once "./src/Phyto.php";
// nous allons intancier notre méthode
$plant = new Phyto();


require_once "./includes/header.php";

//Nous allons traiter les données si nous recevons une requête html de type POST
if ($_SERVER['REQUEST_METHOD'] === 'POST')
// on vérifie quelques vérifications de base
{

  $pdo = new PDO("mysql:host=localhost;dbname=phytostore;charset=utf8", "root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION

  ]);
  $error = false;
  if (empty($_POST['plante']) || empty($_POST['effet']) || empty($_POST['image']) || empty($_POST['price']) || empty($_POST['description'])) {
    $error = true;
  }
  // on vérifie que notre input pour le prix est de type float/numérique
  if (!is_numeric($_POST['price'])) {
    $error = true;
  }
  if (!$error) {



    $plante = filter_var($_POST["plante"], FILTER_SANITIZE_STRING);
    $effet =  filter_var($_POST["effet"], FILTER_SANITIZE_STRING);
    $image =  filter_var($_POST["image"], FILTER_SANITIZE_URL);
    $description = filter_var($_POST["description"], FILTER_SANITIZE_STRING);
    $price = filter_var($_POST["price"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);



    // dd($plante,$effet,$image); affichage des infos inscrite dans le formulaire

    // Nous utilisons pdo pour enregistrer ces données
    $stmt = $pdo->prepare("
          INSERT INTO phyto(plante, effet, image, price, description)
          VALUES (:plante, :effet, :image, :price, :description)
          ");
    // on va ensuite faire un bindparam pour rempcaer les valeurs dans valeues les placeholder
    $stmt->bindParam(':plante', $plante);
    $stmt->bindParam(':effet', $effet);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':description', $description);
    if ($stmt->execute()) {
      // si la plante est correctement sauvegarder en base de donnée
      // nous faisons une redirection en page d'acceuil
      header("Location: index.php");
    }
  }
}

?>


<div class='at-container3'>
  <div class='at-item3'>


    <form method="post" class="w-2/2 mx-auto mt-20 bg-white border rounded p-4 shadow-md">
      <h1 class="text-6xl font-light text-center text-green-600 mb-10 uppercase">Ajouter une plante</h1>

      <?php if (isset($error) && $error === true) : ?>
        <div class="bg-red-600 text-white py-4 px-8 rounded border border-green-900 mb-10">
          <p> OUPS ! Merci de compléter tous les champs </p>
        </div>
      <?php endif   ?>

      <div class="mb-4">
        <label class="block mb-2" for="plante">Nom de la plante:</label>
        <input class="border rounded border-green-300 py-2 px-4 w-full outline-none shadow-sm" type="text" name="plante" id="plante">
      </div>

      <div class="mb-4">
        <label class="block mb-2" for="effet">Effet de la plante:</label>
        <input class="border rounded border-green-300 py-2 px-4 w-full outline-none shadow-sm" type="text" name="effet" id="effet">
      </div>

      <div class="mb-4">
        <label class="block mb-2" for="image">Image de la plante:</label>
        <input class="border rounded border-green-300 py-2 px-4 w-full outline-none shadow-sm" type="text" name="image" id="image">
      </div>

      <div class="mb-4">
        <label class="block mb-2" for="price">Prix:</label>
        <input class="border rounded border-green-300 py-2 px-4 w-full outline-none shadow-sm" type="number" step="0.01" name="price" id="price">
      </div>

      <div class="mb-4">
        <label class="block mb-2" for="description">Description:</label>
        <textarea class="border rounded border-green-300 py-2 px-4 w-full outline-none shadow-sm" name="description" id="description" rows="10"></textarea>
      </div>


      <button class="w-full rounded p-4 bg-green-400 hover:bg-green-600 text-white font-semibold">
        <i class="fa-solid fa-file-circle-plus mr-2"></i>Envoyer
      </button>
    </form>
  </div>
</div>


















<?php
require_once "./components/caroussel_footer.php";
require_once "./includes/footer.php";
?>