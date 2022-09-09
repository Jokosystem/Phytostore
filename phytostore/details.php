<?php
require_once "./src/Phyto.php";
require_once "./includes/header.php";
// nous allons intancier notre méthode
$plant = new Phyto();




$pdo = new PDO("mysql:host=localhost;dbname=phytostore;charset=utf8", "root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION

]);
//nous verifions si notre query ID existe bien et si elle a une valeur numérique
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    //on redirige vers la pasge d'acceuil
    header('Location:index.php');
    exit;
}


$id = $_GET["id"];
$stmt = $pdo->query("SELECT * FROM phyto WHERE id = $id");
$stmt->setFetchMode(PDO::FETCH_CLASS, 'Phyto');
$plant = $stmt->fetch();
//verification si notre id n'estxites pas on est redirigé vers notre page d'acceuil
if (!$plant) {
    header('Location:index.php');
    exit;
}

?>




<section class="rounded overflow-hidden bg-white shadow-md mb-20">

    <header class="py-4 bg-green-800 text-white">
        <h1 class="text-6xl text-center font-light uppercase"><?= $plant->getPlante() ?></h1>
    </header>
    <div class="flex p-10 gap-6">
        <div class="w-1/3">
            <img class="max-w-full" src="<?= $plant->getImage() ?>" alt="">
        </div>

        <div class="w-2/3">
            <h2 class="text-4xl font-light text-orange-500"><?= $plant->getEffet() ?></h2>
            <h3 class="text-4xl text-green-500"><?= $plant->getPrice() ?> €</h3>

            <div class="mt-10">
                <p>Description :</p>
                <hr class="my-6" />
                <p><?= $plant->getDescription() ?></p>
            </div>

            <div class="mt-10 flex items-center gap-3">
                <a class="text-gray-500 hover:text-red-500" href="">
                    <i class="fa-solid fa-heart mr-2"></i> J'aime
                </a>
                <form method="post">
                    <button class="text-orange-400 hover:text-orange-600">
                        <i class="fa-solid fa-cart-arrow-down mr-2"></i> Ajouter au panier
                    </button>
                </form>
            </div>

            <div class="mt-10 flex items-center gap-3">
                <a href="edit.php?id=" class="py-2 px-4 rounded bg-green-400 hover:bg-green-700 text-white">
                    <i class="fa-solid fa-pen-to-square mr-2"></i>Éditer
                </a>
                <form method="post" onsubmit="return confirm('Supprimer cette plante ?')">
                    <button class="py-2 px-4 rounded bg-pink-400 hover:bg-pink-500 text-white">
                        <i class="fa-solid fa-ban mr-2"></i>Supprimer
                    </button>
                </form>
            </div>

            <div class="mt-10 text-right">
                <a class="text-green-700 hover:text-red-700" href="index.php">
                    <i class="fa-solid fa-backward mr-2"></i> Retour
                </a>
            </div>
        </div>
    </div>

</section>
<br />
<?php
require_once "./components/caroussel_footer.php";
require_once "./includes/footer.php";

?>