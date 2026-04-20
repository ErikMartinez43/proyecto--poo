<?php
require_once __DIR__.'/SoftwareDecorador.php';

class LicenciaEducativa extends SoftwareDecorador{
    public function getNombre(): string
    {
        return parent::getNombre()." Licencia Educativa";
    }

    public function getCosto(): float
    {
        return parent::getCosto()+ 19.99;
    }
}