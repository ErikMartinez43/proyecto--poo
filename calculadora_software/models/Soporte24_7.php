<?php
require_once __DIR__.'/SoftwareDecorador.php';

class Soporte24_7 extends SoftwareDecorador{
    public function getNombre(): string
    {
        return parent::getNombre()." Soporte tecnico 24/7 ";
    }

    public function getCosto(): float
    {
        return parent::getCosto()+ 49.99;
    }
}