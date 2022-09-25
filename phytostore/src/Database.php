<?php

class Database
{
    public function connection()
    {
        return new PDO("mysql:host=localhost;dbname=phytostore;charset-utf8", "root","",[
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            
            ]);
            
    }
}