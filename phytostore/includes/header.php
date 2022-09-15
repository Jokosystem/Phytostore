<?php

require_once "./vendor/autoload.php";
require_once dirname(__DIR__) . "/src/Database.php";


$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();
//on intancie notre Class Database
$database = new Database();
// puis on invoque notre méthode connection()
$pdo = $database->connection();
?>


<!DOCTYPE html>
<html lang="FR-fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300i,400" rel="stylesheet">
    <link rel="stylesheet" href="./bootstrap.css">
    <link rel="stylesheet" href="./phyto.css">
    <link rel="stylesheet" href="./blog.css"> <!--css de la page blog -->
    <title>Phytostore</title>
</head>

<body class="bg-slate-50">
    <nav class="shadow-md py-5 bg-white">
        <div class="container mx-auto flex justify-between items-center">

            <a href="index.php">
                <div class='at-container'>
                    <!--animation logo -->
                    <div class='at-item'>
                    </div>
                </div>
            </a>


            <ul class="list-none flex gap-6 justify-between items-center">

                <li>
                    <div class='at-container6'>
                        <!-- animation -->
                        <h1 class='at-item6'>
                            <a class="text-xl text-green-600 hover:text-red-700" href="create.php">
                                <i class="fa-solid fa-circle-plus mr-2"></i>Ajouter un produit
                            </a>
                        </h1>
                    </div>
                </li>

                <li>
                    <div class='at-container6'>
                        <!-- animation slide -->
                        <h1 class='at-item6'>
                            <a class="text-xl text-green-600 hover:text-red-700" href="basket.php">
                                <i class="fa-solid fa-cart-shopping mr-2"></i> Mon panier
                            </a>
                        </h1>
                    </div>
                </li>
                <li>
                    <div class='at-container6'>
                        <!-- animation slide -->
                        <h1 class='at-item6'>
                            <form action="logout.php" class="ml-6" method="post">
                                <button class="text-xl text-green-600 hover:text-red-700">
                                    <i class="fa-solid fa-power-off fa-xl"></i>
                                </button>
                            </form>
                        </h1>
                    </div>
                </li>

                <li>
                    <div class='at-container6'>
                        <!-- animation slide -->
                        <h1 class='at-item6'>
                            <a class="text-xl text-green-600 hover:text-red-700" href="login.php">
                                <i class="fa-solid fa-arrow-right-to-bracket mr-2"></i> Se connecter
                            </a>
                        </h1>
                    </div>
                </li>
                <li>
                    <div class='at-container6'>
                        <!-- animation slide -->
                        <h1 class='at-item6'>
                            <a class="text-xl text-green-600 hover:text-red-700 mr-10" href="register.php">
                                <i class="fa-solid fa-inbox mr-2"></i> S'enregistrer
                            </a>
                        </h1>
                    </div>
                </li>

            </ul>
        </div>
    </nav>
    <nav id="navcategory" class="shadow-md py-4 mb-20">
        <div class="container mx-auto center-block">
            <ul class="list-none flex gap-6 justify-between items-center">
                <li>
                    <a class="text-white text-2xl ml-10 hover:text-gray-300" href="besoins.php">
                        Mes Besoins
                    </a>
                </li>
                <li>
                    <a class="text-white text-2xl hover:text-gray-300" href="index.php">
                        Produits
                    </a>
                </li>
                <li>
                    <a class="text-white text-2xl mr-10 hover:text-gray-300" href="">
                        Blog
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- <div id="title">
            <h1 class="text-3xl mb-20 -mt-10">Phytothérapie</h1>
        </div> -->
    <main class="container mx-auto">