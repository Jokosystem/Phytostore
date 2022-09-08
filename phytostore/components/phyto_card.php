<div class='at-container2'>
    <div class='at-item2'>
        <div class="bg-white flex justify-between items-center border rounded shadow-sm mb-6 p-6">
            <img class="w-36" src="<?= $phytoInter->getImage() ?>" alt="">
            <div class="w-1/3">
                <h2 class="text-4xl uppercase"><?= $phytoInter->getPlante() ?></h2>
                <h3 class="text-2xl font-light text-orange-500"><?= $phytoInter->getEffet() ?></h3>
                <h4 class="text-3xl font-light text-green-500"><?= $phytoInter->getPrice() ?> €</h4>
            </div>
            <div>
                <a href="details.php?id=<?= $phytoInter->getId() ?>" class="py-2 px-4 rounded bg-green-400 hover:bg-green-600 text-white">
                    <i class="fa-solid fa-eye mr-2"></i>Voir plus
                </a>
            </div>
        </div>
    </div>
</div>
<br />