<?php
require_once "./includes/header.php";
require_once "./src/BasketModel.php";
require_once "./src/EffetModel.php";
isLogged();

$bm = new BasketModel();
$basket = $bm->getBasket();
$total = $bm->getFullPrice($basket);

$plm = new EffetModel();




if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if ($_GET["action"] === "add") $bm->addToBasket($_GET["plant_id"]);
  else if ($_GET["action"] === "remove") $bm->removeToBasket($_GET["plant_id"]);
}
?>

<h1 class="text-center text-6xl text-green-600 font-light"><?= $basket ? "Mon panier" : "Votre panier est vide" ?></h1>

<section class="mt-20 flex gap-6">
  <div class="w-2/3">
    <?php if ($basket) : ?>
      <?php foreach ($basket as $plant) : ?>
        <!-- CARTE -->
        <div class="bg-white flex justify-between items-center shadow-sm mb-6 p-3">
          <a href="details.php?id=<?= $plant->getId() ?>">
            <img class="w-20" src="<?= $plant->getImage() ?>" alt="<?= $plant->getPlante() ?>">
          </a>
          <div class="w-1/3">
            <h2 class="text-4xl uppercase">
              <a href="details.php?id=<?= $plant->getId() ?>">
                <?= $plant->getPlante() ?>
              </a>
            </h2>
            <h3 class="text-2xl font-light text-red-400"><?php echo $plm->getOneEffetById(1)->getName(); ?></h3>
            <h4 class="text-2xl font-light text-green-500"><?= $plant->getPrice() ?> €</h4>
          </div>
          <div>
            <p class="font-semibold text-green-600">Quantité : <?= $plant->getQuantity() ?></p>
            <div class="flex items-center gap-6 mt-3">
              <form method="post" action="basket.php?plant_id=<?= $plant->getId() ?>&action=remove">
                <button>
                  <i class="fa-solid fa-circle-minus text-green-400 hover:text-green-500 fa-2xl"></i>
                </button>
              </form>
              <form method="post" action="basket.php?plant_id=<?= $plant->getId() ?>&action=add">
                <button>
                  <i class="fa-solid fa-circle-plus text-green-400 hover:text-green-500 fa-2xl"></i>
                </button>
              </form>
            </div>
          </div>
        </div>
        <!-- FIN CARTE -->
      <?php endforeach ?>
    <?php endif ?>

    <?php if ($basket) : ?>
      <h2 class="text-right text-4xl text-green-600 font-light">Total : <span id="totalPrice"><?= $total ?></span> €</h2>
  </div>
  <div class="w-1/3 mt-20 mb-20"><a href="#" class="ml-20 py-2 px-4 rounded bg-green-500 hover:bg-green-700 text-white">
      <i class="fa-solid fa-cart-shopping mr-2"></i> Passer Commande
    </a>
  </div>
<?php endif ?>
</section>
<script>
  const price = Number(document.querySelector("#totalPrice").innerText)
  document.querySelector("#totalPrice").innerText = price.toFixed(2)
</script>

<?php 
require_once "./includes/footer.php"; ?>
