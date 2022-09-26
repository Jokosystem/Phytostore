<?php
session_start();
require_once "./vendor/autoload.php";
require_once dirname(__DIR__) . "/src/Database.php";
require_once "./utils/utils.php";
require_once dirname(__DIR__) . "/configs/configs.php";
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();
$user = getLoggedUser();
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--css-->
    <link rel="stylesheet" href="./css/phyto.css">
    <!--css de la page blog -->
    <link rel="stylesheet" href="./css/blog.css">

    <title>PhytoBCD</title>

</head>

<body class="bg-slate-50">
    <nav id="nav" class="shadow-md py-3 bg-white">
        <div class="container mx-auto flex justify-between items-center">

            <a href="index.php" alt="Phyto_BCD_logo">
                <div class='at-container'>
                    <!--animation logo -->
                    <div class='at-item'>
                    </div>
                </div>
            </a>

            <ul id="navu" class="list-none flex gap-6 justify-between items-center">
                <?php if ($user) : ?>
                    <?php if ($user["role"] === "admin") : ?>
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
                    <?php endif ?>

                    <li>
                        <div class='at-container6'>
                            <!-- animation slide -->
                            <h1 class='at-item6'>
                                <a class="text-xl text-center text-green-600 hover:text-green-700" href="profile.php">
                                    <i class="fa-solid fa-user mr-2"></i> Bonjour <?= $user["firstname"] ?>
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
                <?php else : ?>
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
                <?php endif ?>
            </ul>
        </div>
    </nav>
    <nav id="navcategory" class="py-3 mb-20">
        <div class="container mx-auto center-block">
            <ul class="list-none flex gap-6 justify-between items-center">
                <li>
                    <div class="text-white text-2xl ml-10">
                        <a class="text-decoration-none hover:text-yellow-500" href="besoins.php">
                            Mes Besoins
                        </a>
                    </div>
                </li>
                <li>
                    <div class="text-white text-2xl mr-5 ml-5">
                        <a class="text-decoration-none hover:text-yellow-500" href="index.php">
                            Nos Produits
                        </a>
                    </div>
                </li>
                <li>
                    <div class="text-white text-2xl mr-10">
                        <a class="text-decoration-none hover:text-yellow-500" href="blog.php">
                            Le Blog
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <main class="container mx-auto">