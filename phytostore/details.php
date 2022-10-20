<?php
require_once "./src/Phyto.php";
require_once "./src/Effet.php";
require_once "./src/PhytoModel.php";
require_once "./src/BasketModel.php";
require_once "./includes/header.php";
$phytoModel = new PhytoModel();
$basketModel = new BasketModel();
$plant = $phytoModel->getOnePlant();
$user = getLoggedUser();

if (isset($_POST['delete'])) {
    $phytoModel->deletePlant();
} else if (isset($_POST['add'])) {
    $basketModel->addToBasket($plant->getId());
}





// Récupération des effets
$stmt2 = $pdo->query("SELECT * FROM effet");
$effets = $stmt2->fetchAll(PDO::FETCH_CLASS, "Effet");

foreach ($effets as $effet) {
    if ($effet->getId() == $plant->getEffet()) {
        $effetname = $effet->getName();
    }
}
?>


<section class="rounded overflow-hidden bg-white shadow-md">
    <header class="py-4 bg-green-800 text-white">
        <h1 class="text-6xl text-center font-light uppercase"><?= $plant->getPlante() ?></h1>
    </header>

    <div class="flex p-10 gap-6">
        <div class="w-1/3">
            <img class="max-w-full" src="<?= $plant->getImage() ?>" alt="">
        </div>

        <div class="w-2/3">
            <h2 class="text-4xl font-bold text-orange-500"><?= $effetname ?></h2>
            <br />
            <h3 class="text-4xl text-green-500"><?= $plant->getPrice() ?> €</h3>

            <div class="mt-10">
                <p class="font-bold text-3xl text-green-700">Description</p>
                <hr class="my-6" />
                <p class="text-2xl"><?= $plant->getDescription() ?></p>
            </div>

            <?php if ($user) : ?>
                <div class="mt-10 flex items-center gap-3">
                    <a class="text-2xl text-gray-500 hover:text-red-500" href="#">
                        <i class="fa-solid fa-heart mr-2"></i> J'aime
                    </a>
                    <form method="post">
                        <button class="text-2xl text-orange-400 hover:text-orange-600" name="add">
                            <i class="fa-solid fa-cart-arrow-down mr-2"></i> Ajouter au panier
                        </button>
                    </form>
                </div>

                <?php if ($user["role"] === "admin") : ?>
                    <div class="mt-10 flex items-center gap-3">
                        <a href="edit.php?id=<?= $plant->getId() ?>" class="py-2 px-4 rounded bg-green-400 hover:bg-green-700 text-white">
                            <i class="fa-solid fa-pen-to-square mr-2"></i>Éditer
                        </a>
                        <form method="post" onsubmit="return confirm('Supprimer cette plante ?')">
                            <button class="py-2 px-4 rounded bg-pink-400 hover:bg-pink-500 text-white" name="delete">
                                <i class="fa-solid fa-ban mr-2"></i>Supprimer
                            </button>
                        </form>
                    </div>
                <?php endif ?>
            <?php else : ?>
                <div class="mt-10">
                    <a class="text-orange-400 hover:text-orange-600" href="login.php">
                        <i class="fa-solid fa-cart-arrow-down mr-2"></i> Ajouter au panier
                    </a>
                </div>
            <?php endif ?>

            <div class="mt-10 text-right">
                <a class="text-2xl text-green-700 hover:text-red-700" href="index.php">
                    <i class="fa-solid fa-backward mr-2"></i> Retour
                </a>
            </div>
        </div>
    </div>

</section>
<?php
require_once "./includes/footer.php";

?>