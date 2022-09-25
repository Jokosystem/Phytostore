<?php
require_once "./includes/header.php";
if (getLoggedUser())
{
  header("Location: index.php");
  exit;
}

require_once "./src/UserModel.php";
$userModel = new UserModel();
$data = $userModel->setupUser();
?>


<h1 class="text-4xl text-center text-green-600 mb-5">Bienvenue !</h1>

<h1 class="text-4xl text-center text-green-600 mb-10">Enregistrer-vous pour profiter pleinement de notre site !</h1>
<h2 class="text-center text-2xl text-green-600 mb-2">Déjà inscrit ? <a class="hover:text-green-700" href="login.php">Se connecter...</a></h2>
<form method="post" class="w-1/2 mx-auto bg-white border text-green-600 rounded p-4 shadow-md">
  <h1 class="text-6xl font-light text-center mb-10 uppercase">S'enregistrer</h1>

  <div class="flex gap-6 mb-4">
    <div class="w-1/2">
      <label class="block mb-2" for="firstname">Prénom</label>
      <input value="<?= isset($data) ? $data["firstname"] : "" ?>" class="border rounded border-gray-100 py-2 px-4 w-full outline-none shadow-sm" type="text" name="firstname" id="firstname">
      <?php if(isset($data) && !empty($data["errorFirstname"])): ?>
        <p class="text-red-400 text-sm"><?= $data["errorFirstname"] ?></p>
      <?php endif ?>
    </div>
    <div class="w-1/2">
      <label class="block mb-2" for="lastname"> Nom</label>
      <input value="<?= isset($data) ? $data["lastname"] : "" ?>" class="border rounded border-gray-100 py-2 px-4 w-full outline-none shadow-sm" type="text" name="lastname" id="lastname">
      <?php if(isset($data) && !empty($data["errorLastname"])): ?>
        <p class="text-red-400 text-sm"><?= $data["errorLastname"] ?></p>
      <?php endif ?>
    </div>
  </div>

  <div class="flex gap-6 mb-4">
    <div class="w-1/2">
      <label class="block mb-2" for="email">Email</label>
      <input value="<?= isset($data) ? $data["email"] : "" ?>" class="border rounded border-gray-100 py-2 px-4 w-full outline-none shadow-sm" type="email" name="email" id="email">
      <?php if(isset($data) && !empty($data["errorEmail"])): ?>
        <p class="text-red-400 text-sm"><?= $data["errorEmail"] ?></p>
      <?php endif ?>
    </div>
    <div class="w-1/2">
      <label class="block mb-2" for="address">Adresse</label>
      <input value="<?= isset($data) ? $data["address"] : "" ?>" class="border rounded border-gray-100 py-2 px-4 w-full outline-none shadow-sm" type="text" name="address" id="address">
      <?php if(isset($data) && !empty($data["errorAddress"])): ?>
        <p class="text-red-400 text-sm"><?= $data["errorAddress"] ?></p>
      <?php endif ?>
    </div>
  </div>

  <div class="flex gap-6 mb-4">
    <div class="w-1/2">
      <label class="block mb-2" for="postal"> Code postal</label>
      <input value="<?= isset($data) ? $data["postal"] : "" ?>" class="border rounded border-gray-100 py-2 px-4 w-full outline-none shadow-sm" type="text" name="postal" id="postal">
      <?php if(isset($data) && !empty($data["errorPostal"])): ?>
        <p class="text-red-400 text-sm"><?= $data["errorPostal"] ?></p>
      <?php endif ?>
    </div>
    <div class="w-1/2">
      <label class="block mb-2" for="city"> Ville</label>
      <input value="<?= isset($data) ? $data["city"] : "" ?>" class="border rounded border-gray-100 py-2 px-4 w-full outline-none shadow-sm" type="text" name="city" id="city">
      <?php if(isset($data) && !empty($data["errorCity"])): ?>
        <p class="text-red-400 text-sm"><?= $data["errorCity"] ?></p>
      <?php endif ?>
    </div>
  </div>

  <div class="flex gap-6 mb-4">
    <div class="w-1/2">
      <label class="block mb-2" for="password"> Mot de passe</label>
      <input class="border rounded border-gray-100 py-2 px-4 w-full outline-none shadow-sm" minlength="6" type="password" name="password" id="password">
      <?php if(isset($data) && !empty($data["errorPassword"])): ?>
        <p class="text-red-400 text-sm"><?= $data["errorPassword"] ?></p>
      <?php endif ?>
    </div>
    <div class="w-1/2">
      <label class="block mb-2" for="confirm">Confirmer Mot de passe</label>
      <input class="border rounded border-gray-100 py-2 px-4 w-full outline-none shadow-sm" minlength="6" type="password" name="confirm" id="confirm">
      <?php if(isset($data) && !empty($data["errorConfirm"])): ?>
        <p class="text-red-400 text-sm"><?= $data["errorConfirm"] ?></p>
      <?php endif ?>
    </div>
  </div>

  <button class="w-full rounded p-4 bg-green-400 hover:bg-green-600 text-white font-semibold">
  <i class="fa-solid fa-paper-plane mr-2"></i>Envoyer
  </button>
</form>

<?php require_once "./includes/footer.php" ?>