<?php
require_once "./includes/header.php";
require_once "./src/UserModel.php";
isLogged();
$userModel = new UserModel();
$data = $userModel->getUser();
$errors = $userModel->updateUser();
?>

<form method="post" class="w-1/2 mx-auto bg-white border rounded p-4 shadow-md">
  <h1 class="text-5xl font-light text-green-600 text-center mb-10 uppercase">Mon profil</h1>

  <div class="flex gap-6 mb-4">
    <div class="w-1/2">
      <label class="block mb-2 " for="firstname"> Prénom</label>
      <input value="<?= isset($data) ? $data["firstname"] : "" ?>" class="border rounded border-gray-100 py-2 px-4 w-full outline-none shadow-sm" type="text" name="firstname" id="firstname">
      <?php if(isset($errors) && !empty($errors["errorFirstname"])): ?>
        <p class="text-red-400 text-sm"><?= $errors["errorFirstname"] ?></p>
      <?php endif ?>
    </div>
    <div class="w-1/2">
      <label class="block mb-2 " for="lastname">Nom</label>
      <input value="<?= isset($data) ? $data["lastname"] : "" ?>" class="border rounded border-gray-100 py-2 px-4 w-full outline-none shadow-sm" type="text" name="lastname" id="lastname">
      <?php if(isset($errors) && !empty($errors["errorLastname"])): ?>
        <p class="text-red-400 text-sm"><?= $errors["errorLastname"] ?></p>
      <?php endif ?>
    </div>
  </div>

  <div class="flex gap-6 mb-4">
    <div class="w-1/2">
      <label class="block mb-2 " for="email">Email</label>
      <input value="<?= isset($data) ? $data["email"] : "" ?>" class="border rounded border-gray-100 py-2 px-4 w-full outline-none shadow-sm" type="email" name="email" id="email">
      <?php if(isset($errors) && !empty($errors["errorEmail"])): ?>
        <p class="text-red-400 text-sm"><?= $errors["errorEmail"] ?></p>
      <?php endif ?>
    </div>
    <div class="w-1/2">
      <label class="block mb-2 " for="address">Adresse</label>
      <input value="<?= isset($data) ? $data["address"] : "" ?>" class="border rounded border-gray-100 py-2 px-4 w-full outline-none shadow-sm" type="text" name="address" id="address">
      <?php if(isset($errors) && !empty($errors["errorAddress"])): ?>
        <p class="text-red-400 text-sm"><?= $errors["errorAddress"] ?></p>
      <?php endif ?>
    </div>
  </div>

  <div class="flex gap-6 mb-4">
    <div class="w-1/2">
      <label class="block mb-2 " for="postal"> Code postal</label>
      <input value="<?= isset($data) ? $data["postal"] : "" ?>" class="border rounded border-gray-100 py-2 px-4 w-full outline-none shadow-sm" type="text" name="postal" id="postal">
      <?php if(isset($errors) && !empty($errors["errorPostal"])): ?>
        <p class="text-red-400 text-sm"><?= $errors["errorPostal"] ?></p>
      <?php endif ?>
    </div>
    <div class="w-1/2">
      <label class="block mb-2 " for="city"> ville</label>
      <input value="<?= isset($data) ? $data["city"] : "" ?>" class="border rounded border-gray-100 py-2 px-4 w-full outline-none shadow-sm" type="text" name="city" id="city">
      <?php if(isset($errors) && !empty($errors["errorCity"])): ?>
        <p class="text-red-400 text-sm"><?= $errors["errorCity"] ?></p>
      <?php endif ?>
    </div>
  </div>

  <button class="w-full rounded p-4 bg-green-400 hover:bg-green-600 text-white font-semibold">
  <i class="fa-solid fa-paper-plane mr-2"></i>Envoyer
  </button>
</form>

<a href="modify-password.php" class="text-center font-semibold text-red-500 hover:text-red-700 hover:underline block mt-10">
  Modifier mon mot de passe
</a>

<?php require_once "./includes/footer.php" ?>