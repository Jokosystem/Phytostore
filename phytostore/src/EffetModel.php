<?php
require_once "Phyto.php";
require_once "Effet.php";
require_once "MainModel.php";

class EffetModel extends MainModel

{
    public function getOneEffetById($id)
    {
      // On effectue notre query SQL pour retourner une donnée unique
      $stmt = $this->pdo->query("SELECT * FROM effet WHERE id = $id");
      $stmt->setFetchMode(PDO::FETCH_CLASS, "Effet");
      $effet = $stmt->fetch();
      return $effet;
    }
}