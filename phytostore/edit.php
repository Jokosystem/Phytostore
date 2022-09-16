<?php
require_once "./src/Phyto.php";

// nous allons intancier notre méthode
$plant = new Phyto();
//nous verifions si notre query ID existe bien et si elle a une valeur numérique
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    //on redirige vers la pasge d'acceuil
    header('Location:index.php');
    exit();
}
// on a besoin du lien avec la BDD pour supprimer / modifier
require_once "./vendor/autoload.php";
require_once "./src/Database.php";


$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();
//on intancie notre Class Database
$database = new Database();
// puis on invoque notre méthode connection()
$pdo = $database->connection();

$id=$_GET["id"];
$stmt = $pdo->query("SELECT * FROM phyto WHERE id = $id");
$stmt->setFetchMode(PDO::FETCH_CLASS, 'Phyto');
$plant = $stmt->fetch();
//verification si notre id n'estxites pas on est redirigé vers notre page d'acceuil
if (!$plant){
    header('Location:index.php');
    exit();
}

//Nous allons traiter les données si nous recevons une requête html de type POST
if ($_SERVER['REQUEST_METHOD'] === 'POST')


// on vérifie quelques vérifications de base
{

  $pdo = new PDO("mysql:host=localhost;dbname=phytostore;charset=utf8", "root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION

  ]);

  $error = [];// notre error est un tableau vide
  if (empty($_POST['plante']) || empty($_POST['effet']) || empty($_POST['image']) || empty($_POST['price']) || empty($_POST['description'])) {
    $error = ["OUPS! Veuillez remplir tous les champs."];
  }
  // on vérifie que notre input pour le prix est de type float/numérique
   else if (!is_numeric($_POST['price'])) {
    $error = ["OULA! Merci d'indiquer un prix valide."];
  }
  // si mon tableau est vide
  if (!count($error)) {



    $plante = filter_var($_POST['plante'], FILTER_SANITIZE_STRING);
    $effet =  filter_var($_POST['effet'], FILTER_SANITIZE_STRING);
    $image =  filter_var($_POST['image'], FILTER_SANITIZE_URL);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);



    // dd($plante,$effet,$image,$description,$price);// affichage des infos inscrite dans le formulaire

    // Nous utilisons pdo pour enregistrer ces données
    $stmt = $pdo->prepare("
          UPDATE phyto SET plante = :plante, effet = :effet, image = :image, price = :price, description = :description WHERE id = :id;
          ");
    // on va ensuite faire un bindparam pour remplacer les valeurs dans valeurs les placeholder
    $stmt->bindParam(':plante', $plante);
    $stmt->bindParam(':effet', $effet);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
      // si la plante est correctement sauvegarder en base de donnée
      // nous faisons une redirection en page d'acceuil
      header('Location: index.php');
    }
  }
}
// ne surtout pas oublier la redirection en plaçant le require-once du header à la fermeture de la balise php
require_once "./includes/header.php";
?>



<form method="post" class="w-1/2 mx-auto bg-white border rounded p-4 shadow-md">
  <h1 class="text-6xl font-light text-center mb-10 uppercase">Modifier une plante</h1>

  <?php if (isset($error) && count($error) > 0 ) : ?>
    <div class="bg-red-600 text-white py-4 px-8 rounded border border-green-900 mb-10">
      <p> <?= $error[0] ?> </p>
    </div>
  <?php endif   ?>

  <div class="mb-4">
    <label class="block mb-2" for="plante">Nom de la plante:</label>
    <input value="<?= $plant-> getPlante() ?>" class="border rounded border-green-300 py-2 px-4 w-full outline-none shadow-sm" type="text" name="plante" id="plante">
  </div>

  <div class="mb-4">
    <label class="block mb-2" for="effet">Effet de la plante:</label>
    <input value="<?= $plant-> getEffet() ?>" class="border rounded border-green-300 py-2 px-4 w-full outline-none shadow-sm" type="text" name="effet" id="effet">
  </div>

  <div class="mb-4">
    <label class="block mb-2" for="image">Image de la plante:</label>
    <input value="<?= $plant-> getImage() ?>" class="border rounded border-green-300 py-2 px-4 w-full outline-none shadow-sm" type="text" name="image" id="image">
  </div>

  <div class="mb-4">
    <label class="block mb-2" for="price">Prix:</label>
    <input value="<?= $plant-> getPrice() ?>" class="border rounded border-green-300 py-2 px-4 w-full outline-none shadow-sm" type="number" step="0.01" name="price" id="price">
  </div>

  <div class="mb-4">
    <label class="block mb-2" for="description">Description:</label>
    <textarea  class="border rounded border-green-300 py-2 px-4 w-full outline-none shadow-sm" name="description" id="description" rows="10"><?= $plant-> getDescription() ?>"</textarea>
  </div>


  <button class="w-full rounded p-4 bg-green-400 hover:bg-green-600 text-white font-semibold">
    <i class="fa-solid fa-file-circle-plus mr-2"></i>Envoyer
  </button>
</form>

<?php

require_once "./includes/footer.php";
?>