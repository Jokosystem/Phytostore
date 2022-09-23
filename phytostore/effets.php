<?php
require_once "./includes/header.php";
require_once "./src/Phyto.php";
require_once "./src/Effet.php";

// nous allons intancier notre méthode
$plant = new Phyto();

$stmt = $pdo->query("SELECT * FROM effet");
$effets = $stmt->fetchAll(PDO::FETCH_CLASS, "Effet");


?>
 
    <?php foreach($effets as $effet): ?> 

    
   
    <h3 class="text-2xl font-light text-orange-500 "><?= $effet->getName() ?></h3>
    <a href="index.php?id=<?= $effet->getId() ?>" class="py-1 px-3 rounded bg-green-400 hover:bg-green-600 text-white">
            <i class="fa-solid fa-eye mr-2"></i>Voir plus
        </a>
   
    <?php endforeach ?> 

     
    
  
    
  <?php  
require_once "./includes/footer.php";

?>