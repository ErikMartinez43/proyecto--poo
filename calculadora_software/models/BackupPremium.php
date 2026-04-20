<?php
require_once __DIR__.'/SoftwareDecorador.php';

class BackupPremium extends SoftwareDecorador{
    public function getNombre(): string
    {
        return parent::getNombre()." Backup Premium ";
    }

    public function getCosto(): float
    {
        return parent::getCosto()+ 29.99;
    }
}