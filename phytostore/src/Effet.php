<?php

class Effet{
    private $id;
    private $name;
    private $image;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
         return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getImage()
    {
         return $this->image;
    }

    public function setImage($image)
    {
        $this->name = $image;
    }
}

?>