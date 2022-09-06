<?php

class Phyto
{

    private $id;
    private $plante;
    private $effet;
    private $image;
    private $price;
    private $description;



    public function getId()
    {
        return $this->id;
    }

    public function getPlante()
    {
        return $this->plante;
    }

    public function setPlante($plante)
    {
        $this->plante = $plante;
    }

    public function getEffet()
    {
        return $this->effet;
    }

    public function setEffet($effet)
    {
        $this->effet = $effet;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getPrice()
    {
        return number_format($this->price, 2, ".");
    }
    public function setPrice($price)
    {
        return $this->price = $price;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }
}
