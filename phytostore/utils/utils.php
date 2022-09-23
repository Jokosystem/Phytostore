<?php

// Fonction pour récupérer l'utilisateur connecté
function getLoggedUser()
{
  if (isset($_SESSION["phytostore_logged_user"])) return $_SESSION["phytostore_logged_user"];
  else return false;
}

/**
 * Fonction pour rediriger l'utilisateur
 */
function redirect($page = "index.php")
{
  // On redirige vers la page d'accueil
  header("Location: $page");
  exit;
}

/**
 * Fonction pour vérifier si l'utilisateur est un admin
 */
function isAdmin()
{
  $user = getLoggedUser();
  if (!$user || $user["role"] !== "admin") redirect();
}

/**
 * Fonction pour rediriger si l'utilisateur n'est pas connecté
 */
function isLogged()
{
  if (!getLoggedUser()) redirect();
}