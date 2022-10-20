<?php
require_once "Database.php";

//la classe parent
class MainModel
{
    // une propriété "protected" ne peut être acessible que par les classes enfants
    //donc celles qui vont faire un "extends"
    protected $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->connection();
    }

    protected function redirect($page = "http://localhost/phytostore/phytostore/index.php")
    {
        // on redirige vers la page d'acceuil
        echo "<script type='text/javascript'>window.top.location='$page';</script>";
    }
}
